@extends('layouts.main')

@section('content')
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h4 mb-0 text-black">Ubah Password</h1>
        </div>

        <div class="card shadow mb-4">
            <div class="card-body">
                <form action="{{ route('user.change-password') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="old_password">Password Lama*</label>
                        <input id="old_password" type="password"
                            class="form-control @error('old_password') is-invalid @enderror" name="old_password"
                            value="{{ old('old_password') }}" autofocus required />
                        @error('old_password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="new_password">Password Baru*</label>
                        <input id="new_password" type="password"
                            class="form-control @error('new_password') is-invalid @enderror" name="new_password"
                            value="{{ old('new_password') }}" autofocus required />
                        @error('new_password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                      <label for="confirm_password">Konfirmasi Password Baru*</label>
                      <input id="confirm_password" type="password"
                          class="form-control @error('confirm_password') is-invalid @enderror" name="confirm_password"
                          value="{{ old('confirm_password') }}" autofocus required />
                      @error('confirm_password')
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
