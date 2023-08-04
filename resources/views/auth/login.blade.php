<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="2hG9Onhipd8gQW4CzEzxhVefjZEvTRg2u0ecrBLT">

    <title>Login</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('img/mini-logo.png') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Scripts -->
    <link rel="preload" as="style" href="{{ asset('build/assets/bootstrap.css') }}" /><link rel="preload" as="style" href="{{ asset('build/assets/app-76ea0196.css') }}" /><link rel="modulepreload" href="{{ asset('build/assets/app-66e7f68a.js') }}" /><link rel="stylesheet" href="{{ asset('build/assets/bootstrap.css') }}" /><link rel="stylesheet" href="{{ asset('build/assets/app-76ea0196.css') }}" /><script type="module" src="{{ asset('build/assets/app-66e7f68a.js') }}"></script>
    <style>
        html,
        body {
            height: 100vh;
        }

        ul {
            list-style: square
        }

        ul li::marker {
            color: #FFE605;
            font-size: 30px;
            line-height: 10px
        }
    </style>
</head>

<body>
    <!-- login information -->
    <div class="container mw-100 h-100">
        <div class="row justify-content-center h-100">
            <div class="col-md-4 align-self-center">
                <div class="px-5">
                    <!-- logo -->
                    <div class="text-center mb-4">
                        <img src="{{ asset('assets/logo.png') }}" alt="" class="w-50 mb-4" />
                    </div>
                    <h2 class="fw-bold mb-4">Log in</h2>
                    <!-- login information -->
                    <form method="POST" action="{{ route('login') }}" class="w-100">
                        @csrf
                        <!-- username -->
                        <div class="form-group">
                            <label for="email" class="text-fs-5">{{ __('Email Address') }}</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required autofocus />
                        </div>
                        <!-- Password -->
                        <div class="form-group mt-4">
                            <label for="password" class="col-sm-2 col-form-label text-fs-5">{{ __('Password') }}</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>

                        </div>
                        <!-- checkbox -->
                        <div class="form-group mt-4 d-flex justify-content-between">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="default-checkbox" {{ old('remember') ? 'checked' : '' }}>
                                <label for="default-checkbox" class="form-check-label text-sm text-fs-6">Save my
                                    password
                                    for future
                                    logins</label>
                            </div>
                            @if (Route::has('password.request'))
                            <div class="form-check">
                                <a class="btn btn-link p-0" href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                            </div>
                            @endif
                        </div>
                        <!-- login Buttons -->
                        <button class="btn border-0 text-fs-5 fw-bold text-white mt-4 col-md-12 signin-btn">Sign
                            in</button>
                        <!-- other buttons -->
                        <div class="d-flex justify-content-center bg-white mt-5 mb-5">
                            <button class="btn btn-light bg-white border border-0 mr-2">
                                <img src="{{ asset('assets/telephone.png') }}" alt="" />
                            </button>
                            <button class="btn btn-light bg-white border border-0 mx-2">
                                <img src="{{ asset('assets/internet.png') }}" alt="" />
                            </button>
                            <button class="btn btn-light bg-white border border-0 ml-2">
                                <img src="{{ asset('assets/mail.png') }}" alt="" />
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- image and note -->
            <div class="col-md d-flex flex-column" style="border-radius: 10px 0 0 10px; background: radial-gradient(75% 75% at 50% 50%, rgba(2, 62, 138, 0.00) 0%, rgba(2, 62, 138, 0.39) 100%);">
                <img src="{{ asset('assets/artwork-login.png') }}" alt="login" style="max-width: 800px"
                    class="w-100 m-auto" />
                <div class="p-3 rounded-4">
                    <ul>
                        <li>

                            <h4 class="text-dark fw-bold">About Us</h4>
                            <p class="text-fs-6">
                                K & G auto expert is leading importers of the exotic cars , we have completed the
                                chorders of more then 10,000 beautiful clients and we hope to work with YOU too....K & G
                                auto expert is leading importers of the exotic cars , we have completed the chorders of
                                more then 10,000 beautiful clients and we hope to work with YOU too....K & G auto expert
                                is leading importers of the exotic cars , we have completed the chorders of more then
                                10,000 beautiful clients and we hope to work with YOU too....
                        </li>
                        </p>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</body>

</html>