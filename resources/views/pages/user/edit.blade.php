@extends('layouts.main')

@section('content')
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h4 mb-0 text-black">Edit Data User</h1>
        </div>

        <div class="card shadow mb-4">
            <div class="card-body">
                <form action="{{ route('user.edit-process', $user->id) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="name">Nama*</label>
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                            name="name" value="{{ $user->name }}" required autofocus />
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email">Email*</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                            name="email" value="{{ $user->email }}" autofocus required />
                        @error('email')
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
