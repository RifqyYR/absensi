@extends('layouts.main')

@section('content')
    <div class="container-fluid id-card-grid">
        @foreach ($students as $item)
            <div class="id-card m-auto" style="page-break-after: always;">
                <div class="header">
                    <div class="background-top"></div>
                        <img class="logo-img" width="40px" src="{{ url('logo.png') }}" alt="School Logo">
                        <h6 class="school-name">MAN 1 Bone</h6>
                </div>
                <div class="info my-4">
                    <h2 class="mb-0">{{ $item->name }}</h2>
                    <span>{{ $item->nisn }}</span>
                </div>
                <div class="bottom">
                    <div class="background-bottom">
                        <img width="120px"
                            src="{{ asset('storage/qrcodes/' . $item->generation . '/' . $item->uuid . '.png') }}"
                            alt="QR Code" class="qr-code">
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
