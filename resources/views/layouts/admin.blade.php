<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>@yield('title')</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('img/mini-logo.png') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"
        integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- Scripts -->
    <link rel="preload" as="style" href="{{ asset('build/assets/bootstrap.css') }}" />
    <link rel="preload" as="style" href="{{ asset('build/assets/app-76ea0196.css') }}" />
    <link rel="modulepreload" href="{{ asset('build/assets/app-66e7f68a.js') }}" />
    <link rel="stylesheet" href="{{ asset('build/assets/bootstrap.css') }}" />
    <link rel="stylesheet" href="{{ asset('build/assets/app-76ea0196.css') }}" />
    <script type="module" src="{{ asset('build/assets/app-66e7f68a.js') }}"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/themes/base/jquery-ui.min.css" integrity="sha512-ELV+xyi8IhEApPS/pSj66+Jiw+sOT1Mqkzlh8ExXihe4zfqbWkxPRi8wptXIO9g73FSlhmquFlUOuMSoXz5IRw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js" integrity="sha512-57oZ/vW8ANMjR/KQ6Be9v/+/h6bq9/l3f0Oc7vn6qMqyhvPd1cvKBRWWpzu0QoneImqr2SkmO4MSqU+RpHom3Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
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
    <style type="text/css">
        .center-body {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 999999;
            height: 100%;
            background-color: white;
            opacity: 0.5;
            display: none;
        }
        .loader-circle-9 {
            position: relative;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 70px;
            height: 70px;
            background: transparent;
            border: 3px solid #023e8abd;
            border-radius: 50%;
            text-align: center;
            line-height: 70px;
            font-family: sans-serif;
            font-size: 12px;
            color: #023e8a;
            text-transform: uppercase;
            box-shadow: 0 0 20px rgba(0, 0, 0, .5);
        }
        .loader-circle-9:before {
            content: '';
            position: absolute;
            top: 0px;
            left: 0px;
            width: 100%;
            height: 100%;
            border: 3px solid transparent;
            border-top: 3px solid #023e8a;
            border-right: 3px solid #023e8a;
            border-radius: 50%;
            animation: animateC 2s linear infinite;
        }
        .loader-circle-9 span {
            display: block;
            position: absolute;
            top: calc(50% - 2px);
            left: 50%;
            width: 50%;
            height: 4px;
            background: transparent;
            transform-origin: left;
            animation: animate 2s linear infinite;
        }
        .loader-circle-9 span:before {
            content: '';
            position: absolute;
            width: 16px;
            height: 16px;
            border-radius: 50%;
            background: #023e8a;
            top: -6px;
            right: -8px;
            box-shadow: 0 0 20px #023e8a;
        }
        @keyframes animateC {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(360deg);
            }
        }
        @keyframes animate {
            0% {
                transform: rotate(45deg);
            }
            100% {
                transform: rotate(405deg);
            }
        }
        .admin-sidebar {
            width: 35px;
        }
        .welcome-text {
            margin-left: 150px;
        }
    </style>
</head>

<body>
    <div class="center-body">
        <div class="loader-circle-9">Working
            <span></span>
        </div>
    </div>
    <div id="app">
        <div class="admin-sidebar">
            @include('components.admin-sidebar')
        </div>
        <main class="">
            @include('components.navbar')
            @yield('content')
        </main>
    </div>
</body>
    <script type="text/javascript">
        $(document).ready(function () {
            $('.select3js').select2({
                dropdownParent: $('#add-new-user-modal')
            });
            $("#add-new-user-modal .select2.select2-container").css("width", "100%");
            $("#add-new-user-modal .select2-selection").css("height", "40px");
            $("#add-new-user-modal .select2-selection__arrow").css("display", "none");

            $(".datepicker").datepicker({ dateFormat: 'yy-mm-dd' });

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

            $(document).on("click", ".toggle-btn", function () {
                if ($(".admin-sidebar").css("width") == "35px") {
                    $(".admin-sidebar").css("width", "auto");
                    $(".welcome-text").css("margin-left", "0px");
                } else {
                    $(".admin-sidebar").css("width", "35px");
                    $(".welcome-text").css("margin-left", "150px");
                }
            });

            $(document).on("change", ".countries", function () {
                var selected = $(this).find("option:selected").attr('data-code');
                $(".phone_code").val("+"+selected);
            });
        });
    </script>
    @yield('script')
</html>