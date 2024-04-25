<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use App\Models\ViolationPoint;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Ramsey\Uuid\Uuid;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $attitudes = [
            ['uuid' => Uuid::uuid7(), 'name' => 'Tidak membawa buku sesuai jadwal', 'category' => 'ATTITUDE', 'points' => 2],
            ['uuid' => Uuid::uuid7(), 'name' => 'Mengganggu ketenangan PBM', 'category' => 'ATTITUDE', 'points' => 4],
            ['uuid' => Uuid::uuid7(), 'name' => 'Kurang rasa kesetiakawanan (help-full)', 'category' => 'ATTITUDE', 'points' => 2],
            ['uuid' => Uuid::uuid7(), 'name' => 'Bertindak tidak senonoh kepada kawan', 'category' => 'ATTITUDE', 'points' => 4],
            ['uuid' => Uuid::uuid7(), 'name' => 'Mencoret dinding, meja, kursi dan pagar', 'category' => 'ATTITUDE', 'points' => 6],
            ['uuid' => Uuid::uuid7(), 'name' => 'Mengancam/mengintimidasi', 'category' => 'ATTITUDE', 'points' => 10],
            ['uuid' => Uuid::uuid7(), 'name' => 'Membawa/merokok di sekolah', 'category' => 'ATTITUDE', 'points' => 10],
            ['uuid' => Uuid::uuid7(), 'name' => 'Bertindak tidak sopan kepada guru/pegawai', 'category' => 'ATTITUDE', 'points' => 24],
            ['uuid' => Uuid::uuid7(), 'name' => 'Merusak sarana/prasarana sekolah', 'category' => 'ATTITUDE', 'points' => 16],
            ['uuid' => Uuid::uuid7(), 'name' => 'Mengambil hak orang lain', 'category' => 'ATTITUDE', 'points' => 20],
            ['uuid' => Uuid::uuid7(), 'name' => 'Membawa teman peserta didik sekolah lain atau orang lain', 'category' => 'ATTITUDE', 'points' => 30],
            ['uuid' => Uuid::uuid7(), 'name' => 'Memalsukan tanda tangan', 'category' => 'ATTITUDE', 'points' => 30],
            ['uuid' => Uuid::uuid7(), 'name' => 'Membawa mengedarkan miras, narkoba, VCD porno, buku porno, HP porno', 'category' => 'ATTITUDE', 'points' => 40],
            ['uuid' => Uuid::uuid7(), 'name' => 'Berkelahi di lingkungan sekolah', 'category' => 'ATTITUDE', 'points' => 30],
            ['uuid' => Uuid::uuid7(), 'name' => 'Terlibat tawuran antar sekolah', 'category' => 'ATTITUDE', 'points' => 30],
            ['uuid' => Uuid::uuid7(), 'name' => 'Berperilaku jorok atau asusila', 'category' => 'ATTITUDE', 'points' => 60],
            ['uuid' => Uuid::uuid7(), 'name' => 'Membawa senjata tajam, senjata api, dan sebagainya', 'category' => 'ATTITUDE', 'points' => 80],
            ['uuid' => Uuid::uuid7(), 'name' => 'Terlibat tindakan kriminal', 'category' => 'ATTITUDE', 'points' => 100],
            ['uuid' => Uuid::uuid7(), 'name' => 'Berzinah', 'category' => 'ATTITUDE', 'points' => 100],
            ['uuid' => Uuid::uuid7(), 'name' => 'Mencuri, merampok atau membunuh', 'category' => 'ATTITUDE', 'points' => 100],
        ];

        $discipline = [
            ['uuid' => Uuid::uuid7(), 'name' => 'Datang terlambat ≤ 15 menit', 'category' => 'DISCIPLINE', 'points' => 1],
            ['uuid' => Uuid::uuid7(), 'name' => 'Datang terlambat ≤ 45 menit', 'category' => 'DISCIPLINE', 'points' => 2],
            ['uuid' => Uuid::uuid7(), 'name' => 'Datang terlambat ≥ 45 menit', 'category' => 'DISCIPLINE', 'points' => 4],
            ['uuid' => Uuid::uuid7(), 'name' => 'Tidak mengikuti pelajaran tanpa ijin', 'category' => 'DISCIPLINE', 'points' => 4],
            ['uuid' => Uuid::uuid7(), 'name' => 'Tidak mengerjakan PR', 'category' => 'DISCIPLINE', 'points' => 4],
            ['uuid' => Uuid::uuid7(), 'name' => 'Tidak mengikuti kegiatan ekstrakurikuler', 'category' => 'DISCIPLINE', 'points' => 2],
            ['uuid' => Uuid::uuid7(), 'name' => 'Tidak masuk sekolah tanpa keterangan', 'category' => 'DISCIPLINE', 'points' => 6],
            ['uuid' => Uuid::uuid7(), 'name' => 'Meninggalkan kelas tanpa ijin', 'category' => 'DISCIPLINE', 'points' => 6],
            ['uuid' => Uuid::uuid7(), 'name' => 'Tidak mengikuti upacara', 'category' => 'DISCIPLINE', 'points' => 6],
        ];

        $neatness = [
            ['uuid' => Uuid::uuid7(), 'name' => 'Tidak memasukkan baju (bagi peserta didik laki-laki)', 'category' => 'NEATNESS', 'points' => 1],
            ['uuid' => Uuid::uuid7(), 'name' => 'Tidak memakai kaos kaki', 'category' => 'NEATNESS', 'points' => 2],
            ['uuid' => Uuid::uuid7(), 'name' => 'Tidak memakai ikat pinggang', 'category' => 'NEATNESS', 'points' => 2],
            ['uuid' => Uuid::uuid7(), 'name' => 'Seragam atribut tidak lengkap', 'category' => 'NEATNESS', 'points' => 4],
            ['uuid' => Uuid::uuid7(), 'name' => 'Tidak memakai sepatu hitam', 'category' => 'NEATNESS', 'points' => 4],
            ['uuid' => Uuid::uuid7(), 'name' => 'Tidak berkerudung (bagi peserta didik perempuan)', 'category' => 'NEATNESS', 'points' => 6],
            ['uuid' => Uuid::uuid7(), 'name' => 'Berambut gondrong (bagi peserta didik laki-laki)', 'category' => 'NEATNESS', 'points' => 6],
            ['uuid' => Uuid::uuid7(), 'name' => 'Bertindik (bagi peserta didik laki-laki)', 'category' => 'NEATNESS', 'points' => 8],
            ['uuid' => Uuid::uuid7(), 'name' => 'Memakai giwang/anting (bagi peserta didik laki-laki)', 'category' => 'NEATNESS', 'points' => 10],
            ['uuid' => Uuid::uuid7(), 'name' => 'Bertato', 'category' => 'NEATNESS', 'points' => 10],
            ['uuid' => Uuid::uuid7(), 'name' => 'Menggunakan pewarna rambut', 'category' => 'NEATNESS', 'points' => 10],
            ['uuid' => Uuid::uuid7(), 'name' => 'Bersolek berlebihan', 'category' => 'NEATNESS', 'points' => 10],
            ['uuid' => Uuid::uuid7(), 'name' => 'Pakaian transparan', 'category' => 'NEATNESS', 'points' => 10],
            ['uuid' => Uuid::uuid7(), 'name' => 'Tidak berpakaian/berbusana muslim/Muslimah', 'category' => 'NEATNESS', 'points' => 20],
        ];

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@simonas.com',
            'password' => Hash::make('webaliyah@2024.sch.id'),
        ]);

        ViolationPoint::insert($attitudes);
        ViolationPoint::insert($discipline);
        ViolationPoint::insert($neatness);
    }
}
