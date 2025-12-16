<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <!-- Custom styles for this template-->
    <link href="{{ asset('templates/css/sb-admin-2.min.css') }}" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Custome CSS --}}
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
    {{-- Font Awesome --}}
    <link rel="stylesheet" href="{{ asset('fontawesome/css/all.min.css') }}" />

    <title>Login</title>
</head>

<body class="bg-admin-login">
    @if (Auth::guard('customer')->check())
        @include('components.navbar-customer-after-login')
    @else
        @include('components.navbar-customer-before-login')
    @endif
    <div class="container py-5 my-5">
        <div class="card p-0 overflow-hidden border border-white">
            <div class="row align-items-center g-0">
                <div class="col-lg-6 d-none d-lg-block">
                    <img src="{{ asset('assets/image-login.png') }}" alt="Login Image" class="img-fluid w-100 h-100"
                        style="object-fit: cover" />
                </div>
                <div
                    class="form-login-admin bg-white border border-white bg-opacity-50 col-lg-6 col-md-8 col-sm-12 p-4">
                    <h3 class="card-title text-start fw-bold mb-2">
                        Selamat Datang
                        <i class="fa-solid fa-hands-clapping"></i>
                    </h3>
                    <p class="text-secondary text-start mb 3">
                        Silahkan login terlebih dahulu dan lanjutkan
                        pemesanan anda
                    </p>
                    <hr />
                    <form method="POST" action="{{ route('login.customer') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="username" class="mb-1">
                                Username
                            </label>
                            <input type="text" name="username" id="username" class="form-control"
                                placeholder="Masukan username" />
                            @error('username')
                                <p class="text-danger fst-italic">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="password" class="mb-1 position-relative">
                                Passwrod
                            </label>
                            <input type="password" name="password" id="password" placeholder="Masukan password"
                                class="form-control" />
                            @error('password')
                                <p class="text-danger fst-italic">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <input type="checkbox" name="showPassword" id="showPassword" />
                            <label for="showPassword">Show Password</label>
                        </div>
                        <div class="mb-3 d-grid text-center">
                            <button type="submit" class="btn btn-light border-dark shadow rounded-pill btn-block">
                                Login
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @include('sweetalert2::index')
    <script>
        const password = document.getElementById('password');
        const checkbox = document.getElementById('showPassword');

        checkbox.addEventListener('change', function() {
            password.type = this.checked ? 'text' : 'password';
        });
    </script>
</body>

</html>
