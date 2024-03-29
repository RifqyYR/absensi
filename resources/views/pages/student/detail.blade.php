@extends('layouts.main')

@section('content')
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h4 mb-0 text-black">Detail Siswa</h1>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="card id-card m-auto">
                    <div class="header">
                        <div class="background-top"></div>
                        <img class="logo-img" width="40px" src="{{ url('logo.png') }}" alt="School Logo">
                        <h6 class="school-name">MAN 1 Bone</h6>
                    </div>
                    <div class="info">
                        <h2 class="mb-0">{{ $student->name }}</h2>
                        <span>{{ $student->nisn }}</span>
                    </div>
                    <div class="bottom">
                        <div class="background-bottom">
                            <img width="150px"
                                src="{{ Storage::url('qrcodes/' . $student->generation . '/' . $student->uuid . '.png') }}"
                                alt="QR Code" class="qr-code">
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
                                <p><strong>Angkatan:</strong> {{ $student->generation }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Jenis Kelamin:</strong> {{ $student->gender == 'L' ? 'Laki-Laki' : 'Perempuan' }}
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
