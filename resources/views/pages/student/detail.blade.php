@extends('layouts.main')

@section('content')
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h4 mb-0 text-black">Detail Siswa</h1>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="font id-card m-auto">
                    <div class="top">
                        <img src="{{ $student->image != null ? asset('storage/uploads/images/' . $student->image) : url('default.png') }}">
                    </div>
                    <div class="bottom">
                        <p class="fs-5 lh-1">{{ $student->name }}</p>
                        <div class="barcode">
                            <img src="{{ asset('storage/qrcodes/' . $student->generation . '/' . $student->uuid . '.png') }}">
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
                        <p><strong>Nama:</strong> {{ $student->name }}</p>
                        <p><strong>Usia:</strong> {{ Carbon\Carbon::parse($student->born_date)->age }} Tahun</p>
                        <p><strong>Tanggal Lahir:</strong> {{ Carbon\Carbon::parse($student->born_date)->locale('id')->isoFormat('D MMMM Y') }}
                        </p>
                        <p><strong>Orang Tua:</strong> {{ $student->parent->name }}</p>
                        <p><strong>Jenis Kelamin:</strong> {{ $student->gender == 'L' ? 'Laki-Laki' : 'Perempuan' }}</p>
                        <p><strong>Angkatan:</strong> {{ $student->generation }}</p>
                        <p><strong>Poin Pelanggaran:</strong> {{ $student->violation_points }}</p>
                        <button class="btn btn-primary mt-4" onclick="window.print()">Print ID Card</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
