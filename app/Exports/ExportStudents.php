<?php

namespace App\Exports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportStudents implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Student::with('parent')
            ->get()
            ->map(function($student) {
                return [
                    'name' => $student->name,
                    'nis' => $student->nis,
                    'nisn' => $student->nisn,
                    'generation' => $student->generation,
                    'born_place' => $student->born_place,
                    'born_date' => $student->born_date,
                    'gender' => $student->gender,
                    'address' => $student->address,
                    'class' => $student->class,
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Nama',
            'NIS',
            'NISN',
            'Angkatan',
            'Tempat Lahir',
            'Tanggal Lahir',
            'Jenis Kelamin',
            'Alamat',
            'Kelas',
        ];
    }
}
