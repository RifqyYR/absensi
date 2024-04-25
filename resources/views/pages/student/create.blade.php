@extends('layouts.main')

@section('content')
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h4 mb-0 text-black">Tambah Data Siswa</h1>
        </div>

        <div class="card shadow mb-4">
            <div class="card-body">
                <form action="/data-siswa/tambah" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="name">Nama Siswa*</label>
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                            name="name" value="{{ old('name') }}" required autofocus />
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="nisn">NIS*</label>
                            <input id="nisn" type="text"
                                class="form-control @error('nisn') is-invalid @enderror" name="nisn"
                                value="{{ old('nisn') }}" required autofocus />
                            @error('nisn')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group col-md-3">
                            <label for="generation">Angkatan*</label>
                            <input id="generation" type="number"
                                class="form-control @error('generation') is-invalid @enderror" name="generation"
                                value="{{ old('generation') }}" required autofocus min="2000" />
                            @error('generation')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group col-md-3">
                            <label for="born_date">Tanggal Lahir*</label>
                            <input id="born_date" type="date"
                                class="form-control @error('born_date') is-invalid @enderror" name="born_date"
                                value="{{ old('born_date') }}" required autofocus />
                            @error('born_date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group col-md-3 mb-0">
                            <label for="gender">Jenis Kelamin*</label>
                            <div class="form-check py-1 px-0">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="gender" id="genderL"
                                        value="L" checked>
                                    <label class="form-check-label" for="genderL">Laki-Laki</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="gender" id="genderP"
                                        value="P">
                                    <label class="form-check-label" for="genderP">Perempuan</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="parent_id">Orang Tua*</label>
                        <select class="custom-select select2 large-select2 @error('parent_id') is-invalid @enderror"
                            name="parent_id">
                            <option value="" selected disabled></option>
                            @foreach ($parents as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
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
