<?php

namespace App\Imports;

use App\Http\Controllers\StudentController;
use App\Http\Controllers\StudentParentController;
use App\Models\Student;
use App\Models\StudentParent;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Ramsey\Uuid\Uuid;

class ImportParentData implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $controller = new StudentParentController();
        $parent = StudentParent::firstOrCreate(
            ['phone_number' => $row['nomor_telepon']],
            [
                'uuid' => Uuid::uuid4(),
                'name' => $row['nama_orang_tua'],
                'password' => Hash::make($row['nomor_telepon']),
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
