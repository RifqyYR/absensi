@extends('layouts.main')

@section('content')
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h4 mb-0 text-black">Edit Data Orang Tua Siswa</h1>
        </div>

        <div class="card shadow mb-4">
            <div class="card-body">
                <form action="{{ route('student-data.edit-process', $student->uuid) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="name">Nama Siswa*</label>
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                            name="name" value="{{ $student->name }}" required autofocus />
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-2">
                            <label for="generation">Angkatan*</label>
                            <input id="generation" type="number"
                                class="form-control @error('generation') is-invalid @enderror" name="generation"
                                value="{{ $student->generation }}" required autofocus min="2000" />
                            @error('generation')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group col-md-5">
                            <label for="born_date">Tanggal Lahir*</label>
                            <input id="born_date" type="date"
                                class="form-control @error('born_date') is-invalid @enderror" name="born_date"
                                value="{{ $student->born_date }}" required autofocus />
                            @error('born_date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group col-md-5 mb-0">
                            <label for="gender">Jenis Kelamin*</label>
                            <div class="form-check py-1 px-0">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="gender" id="genderL"
                                        value="L" {{ $student->gender == 'L' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="genderL">Laki-Laki</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="gender" id="genderP"
                                        value="P" {{ $student->gender == 'P' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="genderP">Perempuan</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="parent_id">Orang Tua*</label>
                        <select class="custom-select select2 large-select2 @error('parent_id') is-invalid @enderror"
                            name="parent_id">
                            <option value="{{ $student->parent->id }}" selected hidden>
                                {{ $student->parent->name }}</option>
                            @foreach ($parents as $item)
                                @if ($item->id == $student->parent->id)
                                    @continue
                                @endif
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                        @error('parent_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="image">Foto</label>
                        <input id="image" type="file" class="form-control @error('image') is-invalid @enderror"
                            name="image" value="{{ $student->image }}" autofocus accept="image/*" />
                        @error('image')
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
