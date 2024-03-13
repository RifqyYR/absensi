<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStudentDataRequest;
use App\Models\Student;
use App\Models\StudentParent;
use App\Models\ViolationPoint;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Ramsey\Uuid\Uuid;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::all();
        $violations = ViolationPoint::all();
        return view('pages.student.index', [
            'students' => $students,
            'violations' => $violations,
        ]);
    }

    public function create()
    {
        $parents = StudentParent::all();
        return view('pages.student.create', [
            'parents' => $parents,
        ]);
    }

    public function store(StoreStudentDataRequest $request)
    {
        $request->validated();
        $data = $request->all();
        $fileName = '';

        try {
            $uuid = Uuid::uuid7();
            $generation = $data['generation'];

            $this->generateQR($uuid, $generation);

            if (isset($data['image'])) {
                $fileName = $uuid . '-' . time() . '.png';
                Storage::putFileAs('/public/uploads/images', $request->file('image'), $fileName);
            }

            DB::transaction(function () use ($data, $uuid, $generation, $fileName) {
                $born_date = Carbon::parse($data['born_date']);
                Student::create([
                    'uuid' => $uuid,
                    'name' => $data['name'],
                    'generation' => $generation,
                    'born_date' => $born_date,
                    'parent_id' => $data['parent_id'],
                    'violation_points' => 0,
                    'image' => $fileName != '' ? $fileName : null,
                    'gender' => $data['gender'],
                ]);
            });

            return redirect()->route('student-data')->with('success', 'Berhasil menambahkan data siswa');
        } catch (\Throwable $e) {
            return redirect()
                ->back()
                ->with('error', 'Gagal menambahkan data: ' . $e->getMessage());
        }
    }

    private function generateQR($uuid, $generation)
    {
        $image = QrCode::format('png')->size(320)->generate($uuid);

        $output_file = 'public/qrcodes/' . $generation . '/' . $uuid . '.png';
        Storage::disk('local')->put($output_file, $image);
    }

    public function delete(String $uuid)
    {
        try {
            $student = Student::where('uuid', $uuid)->first();

            DB::transaction(function () use ($student) {
                if (Storage::exists('/public/uploads/images/' . $student->image)) {
                    Storage::delete('/public/uploads/images/' . $student->image);
                }
                if (Storage::exists('/public/qrcodes/' . $student->generation . '/' . $student->uuid . '.png')) {
                    Storage::delete('/public/qrcodes/' . $student->generation . '/' . $student->uuid . '.png');
                }
                $student->delete();
            });

            return redirect()->route('student-data')->with('success', 'Berhasil menghapus data');
        } catch (\Throwable $e) {
            return redirect()
                ->back()
                ->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }

    public function edit(String $uuid)
    {
        $student = Student::where('uuid', $uuid)->first();
        $parents = StudentParent::all();
        return view('pages.student.edit', [
            'student' => $student,
            'parents' => $parents,
        ]);
    }

    public function editProcess(Request $request, String $uuid)
    {
        $this->validate($request, [
            'name' => 'required',
            'generation' => 'required',
            'born_date' => 'required',
            'parent_id' => 'required',
            'gender' => 'required',
        ]);

        $data = $request->all();
        $fileName = '';

        try {
            $student = Student::where('uuid', $uuid)->first();

            if (isset($data['image'])) {
                if (Storage::exists('/public/uploads/images/' . $student->image)) {
                    Storage::delete('/public/uploads/images/' . $student->image);
                }

                $fileName = $uuid . '-' . time() . '.png';
                Storage::putFileAs('/public/uploads/images', $request->file('image'), $fileName);
            }

            DB::transaction(function () use ($data, $student, $fileName) {
                $student->update([
                    'name' => $data['name'],
                    'generation' => $data['generation'],
                    'born_date' => $data['born_date'],
                    'parent_id' => $data['parent_id'],
                    'violation_points' => $data['violation_points'],
                    'image' => $fileName != '' ? $fileName : $student->image,
                ]);
            });

            return redirect()->route('student-data')->with('success', 'Berhasil mengubah data');
        } catch (\Throwable $e) {
            return redirect()
                ->back()
                ->with('error', 'Gagal mengubah data: ' . $e->getMessage());
        }
    }

    public function detail(String $uuid)
    {
        $student = Student::where('uuid', $uuid)->first();
        return view('pages.student.detail', [
            'student' => $student,
        ]);
    }

    public function violation(Request $request)
    {
        $data = $request->all();
        $student = Student::where('id', $data['student_id'])->first();
        $violation = ViolationPoint::where('id', $data['violation_id'])->first();
        try {
            DB::transaction(function () use ($student, $violation) {
                $student->update([
                    'violation_points' => $student->violation_points + $violation->points,
                ]);
            });

            return redirect()->route('student-data')->with('success', 'Berhasil mengirim data');
        } catch (\Throwable $e) {
            return redirect()
                ->back()
                ->with('error', 'Gagal menambahkan pelanggaran: ' . $e->getMessage());
        }
    }
}
