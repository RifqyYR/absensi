<?php

namespace App\Exports;

use App\Models\Absence;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportAbsence implements FromCollection, WithHeadings
{
    var $date;

    private function convertStatus($status)
    {
        if ($status === 'PRESENT') return 'Hadir';
        else if ($status === 'LATE') return 'Terlambat';
        else if ($status === 'ABSENT') return 'Tidak Absen';
        else if ($status === 'PERMIT') return 'Izin';
    }

    public function __construct($date)
    {
        $this->date = $date;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Absence::with('student')
            ->whereDate('datetime', $this->date)
            ->orderBy('datetime', 'asc')
            ->get()
            ->map(function($absence) {
                return [
                    'student_name' => $absence->student->name,
                    'date' => $absence->date,
                    'time' => $absence->time,
                    'category' => $absence->category == 'IN' ? 'Masuk' : 'Keluar',
                    'status' => $this->convertStatus($absence->status)
                ];
            });
    }

    public function headings(): array 
    {
        return [
            'Nama Siswa',
            'Tanggal',
            'Waktu',
            'Kategori',
            'Status'
        ];
    }
}
