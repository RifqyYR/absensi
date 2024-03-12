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
        $todayAbsences = Absence::whereDate('datetime', now())->get();

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
            if ($currentHour > 8 || ($currentHour == 8 && $currentMinute > 30)) {
                $status = 'LATE';
            }

            $alreadyPresent = Absence::where('student_id', $student->id)
                ->whereDate('date', now())
                ->where('status', '!=', 'ABSENT')
                ->exists();

            if ($alreadyPresent) {
                return redirect()->route('absence.in')->with('error', 'Siswa sudah melakukan absensi');
            }

            try {
                DB::transaction(function () use ($student, $status) {
                    Absence::create([
                        'student_id' => $student->id,
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

    public function indexOut()
    {
        return view('pages.absence.out');
    }
}
