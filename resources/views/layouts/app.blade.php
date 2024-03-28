<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Absensi</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    {{-- Favicon --}}
    <link rel="icon" type="image/x-icon" href="{{ url('favicon.ico') }}">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <style>
        .login-logo {
            display: flex !important;
            justify-content: center;
            align-items: center;
        }
    </style>
</head>

<body class="bg-image"
    @php
if (Request::is('login')) {
        echo 'style="background-image: url(\'bg.svg\'); background-size: cover; background-repeat: no-repeat; height: 100vh;"';
    } @endphp>
    @yield('content')
</body>

</html>
