<?php

namespace App\Imports;

use App\Models\Student;
use App\Models\StudentParent;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Ramsey\Uuid\Uuid;

class ImportParentData implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        set_time_limit(0);

        if (empty($row['nomor_telepon'])) {
            return;
        }

        DB::transaction(function () use ($row) {
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
                'nisn' => $row['nis'],
                'generation' => $row['angkatan'],
                'violation_points' => $row['poin_pelanggaran'],
                'gender' => $row['jenis_kelamin'],
                'born_date' => Date::excelToDateTimeObject($row['tanggal_lahir']),
                'created_at' => now(),
                'updated_at' => now(),
            ];

            Student::insert($studentData);
        });
    }
}
