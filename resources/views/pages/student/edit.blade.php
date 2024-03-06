@extends('layouts.main')

@section('content')
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h4 mb-0 text-black">Edit Data Orang Tua Siswa</h1>
        </div>

        <div class="card shadow mb-4">
            <div class="card-body">
                <form action="{{ route('parent-data.edit-process', $parent->uuid) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="nama">Nama Orang Tua</label>
                        <input id="nama" type="text" class="form-control @error('nama') is-invalid @enderror"
                            name="nama" value="{{ $parent->name }}" required autofocus />
                        @error('nama')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="username">Username</label>
                        <input id="username" type="text" class="form-control @error('username') is-invalid @enderror"
                            name="username" value="{{ $parent->username }}" required autofocus />
                        @error('username')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="phone_number">Nomor Telepon</label>
                        <div class="input-group">
                            <span class="input-group-text">+62</span>
                            <input id="phone_number" type="text"
                                class="form-control @error('phone_number') is-invalid @enderror" name="phone_number"
                                value="{{ $parent->phone_number }}" oninput="validateInput(this)" autofocus />
                        </div>
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
