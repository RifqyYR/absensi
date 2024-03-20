@extends('layouts.main')

@section('content')
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h4 mb-0 text-black">Tambah Data Orang Tua Siswa</h1>
        </div>

        <div class="card shadow mb-4">
            <div class="card-body">
                <form action="/data-orang-tua/tambah" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="nama">Nama Orang Tua*</label>
                        <input id="nama" type="text" class="form-control @error('nama') is-invalid @enderror"
                            name="nama" value="{{ old('nama') }}" required autofocus />
                        @error('nama')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="phone_number">Nomor Telepon*</label>
                        <input id="phone_number" type="text"
                            class="form-control @error('phone_number') is-invalid @enderror" name="phone_number"
                            value="{{ old('phone_number') }}" oninput="validateInput(this)" autofocus />
                        @error('phone_number')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary mt-3" style="background-color: #0C2D57; border: #0C2D57">
                        {{ __('Submit') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
