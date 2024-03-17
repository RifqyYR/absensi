<?php

namespace App\Imports;

use App\Http\Controllers\StudentController;
use App\Models\Student;
use App\Models\StudentParent;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Ramsey\Uuid\Uuid;

class ImportParentData implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $parent = StudentParent::firstOrCreate(
            ['username' => $row['username']],
            [
                'uuid' => Uuid::uuid4(),
                'name' => $row['nama_orang_tua'],
                'phone_number' => $row['nomor_telepon'],
                'password' => Hash::make(env('DEFAULT_PASSWORD', 'password')),
            ]
        );

        $uuid = Uuid::uuid4();

        $student = new Student([
            'uuid' => $uuid,
            'parent_id' => $parent->id,
            'name' => $row['nama_siswa'],
            'nisn' => $row['nisn'],
            'generation' => $row['angkatan'],
            'violation_points' => $row['poin_pelanggaran'],
            'gender' => $row['jenis_kelamin'],
            'born_date' => Date::excelToDateTimeObject($row['tanggal_lahir']),
        ]);

        $student->save();

        $controller = new StudentController();
        $controller->generateQR($uuid, $row['angkatan']);

        return $student;
    }
}
