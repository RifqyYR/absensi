@extends('layouts.main')

@section('content')
    <div class="container-fluid id-card-grid">
        @foreach ($students as $item)
            <div class="font id-card m-auto" style="page-break-after: always;">
                <div class="top">
                    <img
                        src="{{ $item->image != null ? asset('storage/uploads/images/' . $item->image) : url('default.png') }}">
                </div>
                <div class="bottom">
                    <p class="fs-5 lh-2 m-1 text-black">
                        {{ $item->name }}
                        <br>
                        <span class="fs-6">{{ $item->nisn }}</span>
                    </p>
                    <div class="barcode">
                        <img src="{{ asset('storage/qrcodes/' . $item->generation . '/' . $item->uuid . '.png') }}">
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
