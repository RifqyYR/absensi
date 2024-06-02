<?php

namespace App\Imports;

use App\Models\Student;
use App\Models\StudentParent;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Ramsey\Uuid\Uuid;

class ImportParentData implements ToModel, WithHeadingRow, WithCalculatedFormulas
{
    public function model(array $row)
    {
        set_time_limit(0);

        if (empty($row['nomor_telepon'])) {
            return;
        }

        $parent = StudentParent::firstOrCreate(
            ['phone_number' => $row['nomor_telepon']],
            [
                'uuid' => Uuid::uuid4(),
                'name' => $row['nama_orang_tua'],
                'password' => Hash::make($row['nomor_telepon']),
            ]
        );

        $studentData = [
            'uuid' => Uuid::uuid4(),
            'parent_id' => $parent->id,
            'name' => $row['nama_siswa'],
            'nis' => $row['nis'],
            'nisn' => $row['nisn'],
            'generation' => $row['angkatan'],
            'born_place' => $row['tempat_lahir'],
            'born_date' => new \DateTime($row['tanggal_lahir']),
            'gender' => $row['jenis_kelamin'],
            'address' => $row['alamat'],
            'violation_points' => $row['poin_pelanggaran'] == "" ? 0 : $row['poin_pelanggaran'],
            'class' => $row['kelas'],
            'created_at' => now(),
            'updated_at' => now(),
        ];

        Student::create($studentData);
    }
}
