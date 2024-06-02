@extends('layouts.main')

@section('content')
    @php
        $addressParts = explode(',', $student->address);
        $addressParts = array_map('trim', $addressParts);
        $address = $addressParts[0];
        $subdistrict = $addressParts[1];
    @endphp
    <div class="container-fluid mb-4">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h4 mb-0 text-black">Detail Siswa</h1>
        </div>

        <div class="row">
            <div class="col-md-4 card-container">
                <div class="card id-card m-auto">
                    <div class="header background-top py-2" style="border-bottom: 1px solid black !important;">
                        <div class="d-flex justify-content-center align-items-center">
                            <div class="col-2 p-0">
                                <img class="logo-img" width="40px" src="{{ url('logo.png') }}" alt="School Logo">
                            </div>
                            <div class="col-10 text-center lh-sm p-0">
                                <span class="d-block fw-bold text-black"
                                    style="font-size: 0.75rem; white-space: nowrap">KEMENTERIAN AGAMA KABUPATEN BONE</span>
                                <span class="d-block fw-bold text-black" style="font-size: 0.75rem">MADRASAH ALIYAH NEGERI 1
                                    BONE</span>
                                <span class="d-block" style="font-size: 0.55rem; white-space: nowrap;">Jl. Letjen Sukawati
                                    Watampone, No. Telepon (0481) 21238</span>
                            </div>
                        </div>
                    </div>
                    <div class="info">
                        <span class="badge text-bg-success mb-4">KARTU SISWA</span>
                        <h2 id="student-name" class="mb-0 mt-2 px-2 student-name">{{ $student->name }}</h2>
                        <span>{{ $student->nis }}</span>
                    </div>
                    <div class="bottom">
                        <div class="background-bottom">
                            <img width="150px"
                                src="{{ Storage::url('qrcodes/' . $student->generation . '/' . $student->uuid . '.png') }}"
                                alt="QR Code" class="qr-code">
                        </div>
                    </div>
                </div>
                <div class="card id-card-back m-auto py-4 px-4 print-only">
                    <div class="header">
                        <h2 class="school-name fw-bold fs-5">KARTU SISWA</h2>
                    </div>
                    <div class="id-card-back-body fw-bold">
                        <div class="row mt-3">
                            <div class="col-4">
                                NISN
                            </div>
                            <div class="col-8">
                                : {{ $student->nisn }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4 text-nowrap">
                                Nama Lengkap
                            </div>
                            <div class="col-8">
                                : {{ $student->name }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4 text-nowrap">
                                Tempat Lahir
                            </div>
                            <div class="col-8">
                                : {{ $student->born_place }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4">
                                Tgl Lahir
                            </div>
                            <div class="col-8">
                                : {{ $student->born_date }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4">
                                Alamat
                            </div>
                            <div class="col-8">
                                : {{ $address }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4">
                                Kecamatan
                            </div>
                            <div class="col-8">
                                : {{ $subdistrict }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4 lh-sm text-nowrap">
                                Kontak Keluarga
                            </div>
                            <div class="col-8">
                                : {{ $student->parent->phone_number }}
                            </div>
                        </div>

                        <div class="mt-3 mb-4">
                            Kartu ini berlaku selama sekolah di MAN 1 Bone
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-5"></div>
                        <div class="col-7">
                            <img src="{{ url('sign.png') }}" class="sign" width="180px">
                            <div class="id-card-back-sign fw-bold lh-sm">
                                Bone, 01 Mei 2024
                                <br>
                                Kepala MAN 1 Bone
                                <br>
                                <br>
                                <br>
                                <br>
                                <br>
                                Drs. H. Abbas, M.Pd.I
                                <br>
                                NIP. 196904182003121003
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header">
                        <h6 class="text-black fw-bold">Data Siswa</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Nama:</strong> {{ $student->name }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>NISN:</strong> {{ $student->nisn }}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>NIS:</strong> {{ $student->nis }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Angkatan:</strong> {{ $student->generation }}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Kelas:</strong> {{ $student->class }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Jenis Kelamin:</strong>
                                    {{ $student->gender == 'L' ? 'Laki-Laki' : 'Perempuan' }}
                                </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Tanggal Lahir:</strong>
                                    {{ Carbon\Carbon::parse($student->born_date)->locale('id')->isoFormat('D MMMM Y') }}
                                </p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Usia:</strong> {{ Carbon\Carbon::parse($student->born_date)->age }} Tahun</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Orang Tua:</strong> {{ $student->parent->name }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Poin Pelanggaran:</strong> {{ $student->violation_points }}</p>
                            </div>
                        </div>
                        <div class="row">
                            <p><strong>Alamat:</strong> {{ $student->address }}</p>
                        </div>

                        <button class="btn btn-md btn-primary mt-4 me-2" onclick="window.print()">Print ID Card</button>
                        <a href="{{ route('student-data.violation-history', $student->uuid) }}"
                            class="{{ $student->violation_points == 0 ? 'disabled-link' : '' }}">
                            <button class="btn btn-md btn-danger mt-4"
                                {{ $student->violation_points == 0 ? 'disabled' : '' }}>Riwayat Pelanggaran</button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
