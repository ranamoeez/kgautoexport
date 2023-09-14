<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>Dashboard</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('img/mini-logo.png') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"
        integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <link rel="stylesheet" href="https://cdn.tutorialjinni.com/intl-tel-input/17.0.19/css/intlTelInput.css" />
    <script src="https://cdn.tutorialjinni.com/intl-tel-input/17.0.19/js/intlTelInput.min.js"></script>

    <!-- Scripts -->
    <link rel="preload" as="style" href="{{ asset('build/assets/bootstrap.css') }}" />
    <link rel="preload" as="style" href="{{ asset('build/assets/app-76ea0196.css') }}" />
    <link rel="modulepreload" href="{{ asset('build/assets/app-66e7f68a.js') }}" />
    <link rel="stylesheet" href="{{ asset('build/assets/bootstrap.css') }}" />
    <link rel="stylesheet" href="{{ asset('build/assets/app-76ea0196.css') }}" />
    <script type="module" src="{{ asset('build/assets/app-66e7f68a.js') }}"></script>
    <style type="text/css">
        a.active {
            background-color: #ADE8F4;
            color: black;
        }
        a.active i {
            color: black;
        }
    </style>
</head>

<body>
    <div id="app">
        <div class="">
            @include('components.user-sidebar')
        </div>
        <main class="">
            @include('components.user-navbar')
            @yield('content')
        </main>
    </div>
</body>
    @yield('script')
</html>