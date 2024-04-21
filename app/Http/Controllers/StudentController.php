<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStudentDataRequest;
use App\Models\Student;
use App\Models\StudentParent;
use App\Models\Violation;
use App\Models\ViolationPoint;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
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

        try {
            $uuid = Uuid::uuid7();
            $generation = $data['generation'];

            $this->generateQR($uuid, $generation);

            DB::transaction(function () use ($data, $uuid, $generation) {
                $born_date = Carbon::parse($data['born_date']);
                Student::create([
                    'uuid' => $uuid,
                    'name' => $data['name'],
                    'nisn' => $data['nisn'],
                    'generation' => $generation,
                    'born_date' => $born_date,
                    'parent_id' => $data['parent_id'],
                    'violation_points' => 0,
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

    public function generateQR($uuid, $generation)
    {
        $image = QrCode::format('png')->size(120)->generate($uuid);

        $output_dir = 'public/qrcodes/' . $generation;
        if (!Storage::disk('local')->exists($output_dir)) {
            Storage::disk('local')->makeDirectory($output_dir, 0755);
            chmod(storage_path('app/' . $output_dir), 0755);
        }

        $output_file = $output_dir . '/' . $uuid . '.png';
        Storage::disk('local')->put($output_file, $image);
    }

    public function delete(string $uuid)
    {
        try {
            $student = Student::where('uuid', $uuid)->first();

            DB::transaction(function () use ($student) {
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

    public function edit(string $uuid)
    {
        $student = Student::where('uuid', $uuid)->first();
        $parents = StudentParent::all();
        return view('pages.student.edit', [
            'student' => $student,
            'parents' => $parents,
        ]);
    }

    public function editProcess(Request $request, string $uuid)
    {
        $this->validate($request, [
            'name' => 'required',
            'nisn' => 'required',
            'generation' => 'required',
            'born_date' => 'required',
            'parent_id' => 'required',
            'gender' => 'required',
        ]);

        $data = $request->all();

        try {
            $student = Student::where('uuid', $uuid)->first();

            DB::transaction(function () use ($data, $student) {
                $student->update([
                    'name' => $data['name'],
                    'nisn' => $data['nisn'],
                    'generation' => $data['generation'],
                    'born_date' => $data['born_date'],
                    'parent_id' => $data['parent_id'],
                    'violation_points' => $data['violation_points'],
                ]);
            });

            return redirect()->route('student-data')->with('success', 'Berhasil mengubah data');
        } catch (\Throwable $e) {
            return redirect()
                ->back()
                ->with('error', 'Gagal mengubah data: ' . $e->getMessage());
        }
    }

    public function detail(string $uuid)
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
                Violation::create([
                    'student_id' => $student->id,
                    'violation_point_id' => $violation->id,
                ]);
            });

            return redirect()->route('student-data')->with('success', 'Berhasil mengirim data');
        } catch (\Throwable $e) {
            return redirect()
                ->back()
                ->with('error', 'Gagal menambahkan pelanggaran: ' . $e->getMessage());
        }
    }

    public function violationHistory(string $uuid)
    {
        $student = Student::where('uuid', $uuid)->first();
        $violations = Violation::with('violationPoint')
            ->where('student_id', $student->id)
            ->get();

        return view('pages.student.violation-history', [
            'student' => $student,
            'violations' => $violations,
        ]);
    }

    public function deleteViolationHistory(string $uuid)
    {
        try {
            $violation = Violation::where('uuid', $uuid)->first();
            $student = Student::where('id', $violation->student_id)->first();
            $violationPoint = ViolationPoint::where('id', $violation->violation_point_id)->first();

            DB::transaction(function () use ($violation, $student, $violationPoint) {
                $student->update([
                    'violation_points' => $student->violation_points - $violationPoint->points,
                ]);
                $violation->delete();
            });

            if ($student->violation_points == 0) {
                return redirect()
                    ->route('student-data.detail', ['uuid' => $student->uuid])
                    ->with('success', 'Berhasil menghapus data');
            }

            return redirect()
                ->route('student-data.violation-history', ['uuid' => $student->uuid])
                ->with('success', 'Berhasil menghapus data');
        } catch (\Throwable $e) {
            return redirect()
                ->back()
                ->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }

    public function printAllIdCard()
    {
        $students = Student::all();
        return view('pages.student.print-all-id-card', compact('students'));
    }

    public function deleteByGeneration()
    {
        $generation = now()->subYears(3)->year;
        DB::transaction(function () use ($generation) {
            Student::where('generation', $generation)->each(function ($student) {
                $student->absences()->delete();
                $student->delete();
            });
            StudentParent::doesntHave('students')->delete();
            if (Storage::disk('local')->exists('public/qrcodes/' . $generation)) {
                Storage::disk('local')->deleteDirectory('public/qrcodes/' . $generation);
            }
        });
    }
}
