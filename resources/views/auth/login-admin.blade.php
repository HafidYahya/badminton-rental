<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('fontawesome/css/all.min.css') }}" />
    <title>Login Admin</title>
</head>

<body class="bg-admin-login auth-page">
    <main class="container auth-container">
        <section class="auth-card auth-card-admin" aria-labelledby="adminLoginTitle">
            <div class="auth-visual" role="img" aria-label="Lapangan badminton"></div>
            <div class="auth-panel">
                <a class="auth-brand" href="{{ url('/') }}">BADMINTON RENTAL</a>
                <p class="auth-eyebrow">AREA ADMINISTRATOR</p>
                <h1 id="adminLoginTitle" class="auth-title">Selamat datang</h1>
                <p class="auth-description">Masuk untuk mengelola pemesanan dan informasi lapangan.</p>

                <form method="POST" action="{{ route('login.admin') }}" class="auth-form">
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
                </form>
            </div>
        </section>
    </main>
    <script>
        document.getElementById('showPassword').addEventListener('change', function () {
            document.getElementById('password').type = this.checked ? 'text' : 'password';
        });
    </script>
</body>

</html>
