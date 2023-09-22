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
    <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/js/splide.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script type="text/javascript"  src="{{asset('/js/global-script.js')}}"></script>
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
    <script type="text/javascript">
        $(document).ready(function () {
            $(document).on("submit", ".user-form", function (event) {
                event.preventDefault();
                $.ajax({
                    type: $(this).attr("method"),
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType: "json",
                    url: $(this).attr("action"),
                    data: new FormData(this),
                    headers: { "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content") },
                    success: function (res) {
                        // res = JSON.parse(res);
                        console.log(res);
                        if (res.success == true) {
                            toastr["success"](res.msg, "Completed!");
                            setTimeout(function () {
                                location.reload();
                            }, 2000);
                        } else {
                            toastr["error"](res.msg, "Failed!");
                        }
                    }
                });
            });
            
            $(document).on("click", ".iti__country", function () {
                $("#top_dial_code").val($(".iti__selected-dial-code").first().text().trim());
            });
        });
    </script>
    @yield('script')
    <script type="text/javascript">
        var input = document.querySelector("#phone");
        window.intlTelInput(input, {
            separateDialCode: true,
            excludeCountries: ["in", "il"],
            preferredCountries: ["jo", "iq"]
        });
    </script>
</html>