@extends('layouts.app') @section('content')
    <div class="container d-flex align-items-center justify-content-center" style="height: 90vh">
        <!-- Outer Row -->
        <div class="row">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card o-hidden border-0 shadow-lg my-5" style="width: 60vw;">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image d-lg-flex align-content-center align-items-center"
                                style="border-right: 2px solid #FFB0B0 !important;">
                                <img src="{{ url('logo.png') }}" alt="logo aplikasi"
                                    class="ratio ratio-16x9 img-fluid mx-auto d-block" style="width: 200px;" />
                            </div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <h1 style="color: #0C2D57 !important;" class="fw-bold fs-5 mb-3 text-center">
                                        Selamat Datang di Aplikasi SiMonas
                                    </h1>
                                    <form method="POST" action="{{ route('login') }}">
                                        @csrf
                                        <div class="form-group mb-3">
                                            <input id="email" type="text"
                                                class="form-control @error('email') is-invalid @enderror" name="email"
                                                value="{{ old('email') }}" required placeholder="Masukkan Email"
                                                autofocus />

                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group mb-3">
                                            <input id="password" type="password"
                                                class="form-control @error('password') is-invalid @enderror" name="password"
                                                required autocomplete="current-password" placeholder="Password" />

                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <button type="submit" class="btn btn-primary" style="background-color: #FC6736">
                                            {{ __('Login') }}
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
