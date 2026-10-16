<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <link href="{{ asset('templates/css/sb-admin-2.min.css') }}" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('fontawesome/css/all.min.css') }}" />
    <title>Login Customer</title>
</head>

<body class="bg-admin-login auth-page auth-page-customer">
    @if (Auth::guard('customer')->check())
        @include('components.navbar-customer-after-login')
    @else
        @include('components.navbar-customer-before-login')
    @endif

    <main class="container auth-container auth-container-customer">
        <section class="auth-card" aria-labelledby="customerLoginTitle">
            <div class="auth-visual" role="img" aria-label="Lapangan badminton"></div>
            <div class="auth-panel">
                <a class="auth-brand" href="{{ url('/') }}">BADMINTON RENTAL</a>
                <p class="auth-eyebrow">AKUN CUSTOMER</p>
                <h1 id="customerLoginTitle" class="auth-title">Selamat datang</h1>
                <p class="auth-description">Masuk untuk melanjutkan pemesanan lapangan badminton.</p>

                <form method="POST" action="{{ route('login.customer') }}" class="auth-form">
                    @csrf
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" name="username" id="username" class="form-control"
                            placeholder="Masukkan username" autocomplete="username" value="{{ old('username') }}"
                            required autofocus aria-describedby="usernameError" />
                        @error('username')
                            <p id="usernameError" class="auth-error" role="alert">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" id="password" class="form-control"
                            placeholder="Masukkan password" autocomplete="current-password" required
                            aria-describedby="passwordError" />
                        @error('password')
                            <p id="passwordError" class="auth-error" role="alert">{{ $message }}</p>
                        @enderror
                    </div>
                    <label class="auth-show-password" for="showPassword">
                        <input type="checkbox" id="showPassword" />
                        <span>Tampilkan password</span>
                    </label>
                    <button type="submit" class="btn auth-submit">
                        Masuk <i class="fa-solid fa-arrow-right ms-2" aria-hidden="true"></i>
                    </button>
                    <p class="auth-switch">Belum punya akun? <a href="{{ route('register.form') }}">Daftar sekarang</a></p>
                </form>
            </div>
        </section>
    </main>

    @include('sweetalert2::index')
    <script>
        document.getElementById('showPassword').addEventListener('change', function () {
            document.getElementById('password').type = this.checked ? 'text' : 'password';
        });
    </script>
</body>

</html>
