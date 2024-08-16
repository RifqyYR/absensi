<?php

namespace App\Exports;

use App\Models\Violation;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportViolation implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Violation::with('student', 'violationPoint')
            ->get()
            ->map(function($violation) {
                return [
                    'name' => $violation->student->name,
                    'violation_name' => $violation->violationPoint->name,
                    'category' => $violation->violationPoint->category,
                    'points' => $violation->violationPoint->points,
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Nama Siswa',
            'Pelanggaran',
            'Kategori',
            'Poin Pelanggaran'
        ];
    }
}
