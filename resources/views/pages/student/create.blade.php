@extends('layouts.main')

@section('content')
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h4 mb-0 text-black">Tambah Data Siswa</h1>
        </div>

        <div class="card shadow mb-4">
            <div class="card-body">
                <form action="/data-siswa/tambah" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="nama">Nama Siswa</label>
                        <input id="nama" type="text" class="form-control @error('nama') is-invalid @enderror"
                            name="nama" value="{{ old('nama') }}" required autofocus />
                        @error('nama')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="generation">Angkatan</label>
                            <input id="generation" type="number" class="form-control @error('generation') is-invalid @enderror"
                                name="generation" value="{{ old('generation') }}" required autofocus min="2000" />
                            @error('generation')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group col-md-6">
                            <label for="born_date">Tanggal Lahir</label>
                            <input id="born_date" type="date" class="form-control @error('born_date') is-invalid @enderror"
                                name="born_date" value="{{ old('born_date') }}" required autofocus />
                            @error('born_date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="parent_id">Orang Tua</label>
                        <input id="parent_id" type="text" class="form-control @error('parent_id') is-invalid @enderror"
                            name="parent_id" value="{{ old('parent_id') }}" required autofocus />
                        @error('parent_id')
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
