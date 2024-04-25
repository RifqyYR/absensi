<?php

namespace App\Http\Controllers;

use App\Models\Absence;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AbsenceController extends Controller
{
    public function indexIn()
    {
        $students = Student::all();
        $todayAbsences = Absence::whereDate('datetime', now())->where('category', 'IN')->where('status', 
        '!=', 'ABSENT')->get();

        return view('pages.absence.index-in', [
            'students' => $students,
            'absences' => $todayAbsences,
        ]);
    }

    public function absenceIn(Request $request)
    {
        $studentId = $request->input('barcode');

        $uuidRegex = '/^[0-9a-fA-F]{8}\-[0-9a-fA-F]{4}\-[0-9a-fA-F]{4}\-[0-9a-fA-F]{4}\-[0-9a-fA-F]{12}$/';

        if (!preg_match($uuidRegex, $studentId)) {
            return redirect()->route('absence.in')->with('error', 'ID siswa tidak valid');
        }

        $student = Student::where('uuid', $studentId)->first();

        if ($student != null) {
            $currentTime = now()->setTimezone('Asia/Singapore');
            $currentHour = $currentTime->hour;
            $currentMinute = $currentTime->minute;

            if ($currentHour < 6 || ($currentHour == 6 && $currentMinute < 30)) {
                return redirect()->route('absence.in')->with('error', 'Absensi hanya dapat dilakukan setelah pukul 06:30');
            }

            $status = 'PRESENT';
            if ($currentHour > 7 || ($currentHour == 7 && $currentMinute > 15)) {
                $status = 'LATE';
            }

            $alreadyPresent = Absence::where('student_id', $student->id)
                ->whereDate('date', now())
                ->where('status', '!=', 'ABSENT')
                ->where('category', 'IN')
                ->exists();

            if ($alreadyPresent) {
                return redirect()->route('absence.in')->with('error', 'Siswa sudah melakukan absensi');
            }

            try {
                DB::transaction(function () use ($student, $status) {
                    $latestAbsence = $student->absences()->where('category', 'IN')->latest()->first();
                    $latestAbsence->update([
                        'date' => now(),
                        'time' => now(),
                        'datetime' => now(),
                        'status' => $status,
                    ]);
                });

                return redirect()->route('absence.in')->with('success', 'Berhasil melakukan absensi');
            } catch (\Exception $e) {
                return redirect()
                    ->route('absence.in')
                    ->with('error', 'Gagal melakukan absensi: ' . $e->getMessage());
            }
        } else {
            return redirect()->route('absence.in')->with('error', 'Id siswa tidak ditemukan');
        }
    }

    public function createAbsenceToday()
    {
        $students = Student::all();

        foreach ($students as $student) {
            if (now()->dayName != 'Minggu') {
                Absence::create([
                    'student_id' => $student->id,
                    'category' => 'IN',
                    'date' => now(),
                    'time' => null,
                    'datetime' => now(),
                    'status' => 'ABSENT',
                ]);
                Absence::create([
                    'student_id' => $student->id,
                    'category' => 'OUT',
                    'date' => now(),
                    'time' => null,
                    'datetime' => now(),
                    'status' => 'ABSENT',
                ]);
            }
        }
    }

    public function indexOut()
    {
        $students = Student::all();
        $todayAbsences = Absence::whereDate('datetime', now())->where('category', 'OUT')->where('status', '!=', 'ABSENT')->get();

        return view('pages.absence.index-out', [
            'students' => $students,
            'absences' => $todayAbsences,
        ]);
    }

    public function absenceOut(Request $request)
    {
        $studentId = $request->input('barcode');

        $uuidRegex = '/^[0-9a-fA-F]{8}\-[0-9a-fA-F]{4}\-[0-9a-fA-F]{4}\-[0-9a-fA-F]{4}\-[0-9a-fA-F]{12}$/';

        if (!preg_match($uuidRegex, $studentId)) {
            return redirect()->route('absence.out')->with('error', 'ID siswa tidak valid');
        }

        $student = Student::where('uuid', $studentId)->first();

        if ($student != null) {
            $currentTime = now()->setTimezone('Asia/Singapore');
            $currentHour = $currentTime->hour;
            $currentMinute = $currentTime->minute;

            if ($currentHour < 11 || ($currentHour == 11 && $currentMinute < 30)) {
                return redirect()->route('absence.out')->with('error', 'Absensi hanya dapat dilakukan setelah pukul 16:30');
            }

            $alreadyPresent = Absence::where('student_id', $student->id)
                ->whereDate('date', now())
                ->where('status', '!=', 'ABSENT')
                ->where('category', 'OUT')
                ->exists();

            if ($alreadyPresent) {
                return redirect()->route('absence.out')->with('error', 'Siswa sudah melakukan absensi');
            }

            $status = 'PRESENT';

            try {
                DB::transaction(function () use ($student, $status) {
                    $latestAbsence = $student->absences()->where('category', 'OUT')->latest()->first();
                    $latestAbsence->update([
                        'date' => now(),
                        'time' => now(),
                        'datetime' => now(),
                        'status' => $status,
                        'category' => 'OUT',
                    ]);
                });

                return redirect()->route('absence.out')->with('success', 'Berhasil melakukan absensi');
            } catch (\Exception $e) {
                return redirect()
                    ->route('absence.out')
                    ->with('error', 'Gagal melakukan absensi: ' . $e->getMessage());
            }
        } else {
            return redirect()->route('absence.out')->with('error', 'Id siswa tidak ditemukan');
        }
    }

    public function history()
    {
        $absences = Absence::with('student')
            ->selectRaw('date(datetime) as date, category, student_id')
            ->orderBy('datetime', 'desc')
            ->get()
            ->groupBy(['date', 'category']);

        return view('pages.absence.history', [
            'absences' => $absences,
        ]);
    }

    public function deleteHistory(string $uuid)
    {
        $absence = Absence::where('uuid', $uuid)->first();

        if ($absence != null) {
            $absence->delete();

            return redirect()->route('absence-history')->with('success', 'Berhasil menghapus data');
        } else {
            return redirect()->route('absence-history')->with('error', 'Data tidak ditemukan');
        }
    }

    public function detailHistory($date)
    {
        $absences = Absence::with('student')->whereDate('datetime', $date)->orderBy('datetime', 'asc')->get();

        return view('pages.absence.detail-history', [
            'absences' => $absences,
        ]);
    }

    public function updateStatus(Request $request)
    {
        try {
            $request->validate([
                'ids' => 'required',
                'status' => 'required|string',
            ]);

            Absence::whereIn('id', $request->ids)->update(['status' => $request->status]);
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Gagal mengubah data: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Berhasil mengubah status');
    }

    public function getAbsencesByDate()
    {
        $absencesPresent = Absence::where('category', 'IN')->where('status', 'PRESENT')->select(DB::raw('DATE(date) as date'), DB::raw('count(*) as count'))->groupBy(DB::raw('DATE(date)'))->get();
        $absencesLate = Absence::where('category', 'IN')->where('status', 'LATE')->select(DB::raw('DATE(date) as date'), DB::raw('count(*) as count'))->groupBy(DB::raw('DATE(date)'))->get();
        $notPresent = Absence::where('category', 'IN')->where('status', 'ABSENT')->select(DB::raw('DATE(date) as date'), DB::raw('count(*) as count'))->groupBy(DB::raw('DATE(date)'))->get();

        return response()->json([$absencesPresent, $absencesLate, $notPresent]);
    }
}
