<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />

    <title>REGISTER</title>

    <link href="{{ asset('templates/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css" />
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet" />

    <!-- Custom styles for this template-->
    <link href="{{ asset('templates/css/sb-admin-2.min.css') }}" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Custome CSS --}}
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="{{ asset('fontawesome/css/all.min.css') }}" />
</head>

<body class="register-bg">
    {{-- CONTENT --}}
    @if (Auth::guard('customer')->check())
        @include('components.navbar-customer-after-login')
    @else
        @include('components.navbar-customer-before-login')
    @endif
    <main class="container auth-container auth-container-customer auth-register-container">
        <section class="col-12 col-sm-10 col-md-8 col-lg-7" aria-labelledby="registerTitle">
            <div class="card auth-card auth-register-card shadow-sm">
                <div class="card-body">
                    <a class="auth-brand" href="{{ url('/') }}">BADMINTON RENTAL</a>
                    <p class="auth-eyebrow mt-3">BUAT AKUN CUSTOMER</p>
                    <h1 id="registerTitle" class="auth-title">Mulai pesan lapangan</h1>
                    <p class="auth-description">
                        Daftar untuk memesan dan mengelola pemesanan lapangan secara online.
                    </p>

                    <form action="{{ route('customer.register') }}" method="POST" enctype="multipart/form-data"
                        class="auth-form">
                        @csrf

                        <div class="mb-3">
                            <label for="nama_lengkap" class="form-label">
                                Nama Lengkap*
                            </label>
                            <input type="text" class="form-control" id="nama_lengkap"
                                placeholder="Masukkan nama lengkap" name="nama_lengkap" autocomplete="name"
                                value="{{ old('nama_lengkap') }}" required />
                            @error('nama_lengkap')
                                <p class="text-danger fst-italic">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="no_hp" class="form-label">
                                Nomor HP*
                            </label>
                            <input type="tel" class="form-control" id="no_hp"
                                placeholder="Masukkan nomor handphone" name="no_hp" autocomplete="tel"
                                value="{{ old('no_hp') }}" required />
                            @error('no_hp')
                                <p class="text-danger fst-italic">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="username" class="form-label">
                                Username*
                            </label>
                            <input type="text" class="form-control" id="username"
                                placeholder="Masukkan username" name="username" autocomplete="username"
                                value="{{ old('username') }}" required />
                            @error('username')
                                <p class="text-danger fst-italic">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">
                                Password*
                            </label>
                            <input type="password" class="form-control" id="password" name="password"
                                autocomplete="new-password" required />
                            @error('password')
                                <p class="text-danger fst-italic">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="konfirmasi_password" class="form-label">
                                Konfirmasi Password*
                            </label>
                            <input type="password" class="form-control" id="konfirmasi_password"
                                name="konfirmasi_password" autocomplete="new-password" required />
                            @error('konfirmasi_password')
                                <p class="text-danger fst-italic">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="alamat" class="form-label">
                                Alamat Lengkap
                            </label>
                            <textarea name="alamat" id="alamat" class="form-control" rows="3">{{ old('alamat') }}</textarea>
                            @error('alamat')
                                <p class="text-danger fst-italic">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="foto_profile" class="form-label">
                                Foto Profile
                            </label>
                            <input type="file" class="form-control" id="foto_profile" name="foto_profile"
                                accept="image/*" />
                            @error('foto_profile')
                                <p class="text-danger fst-italic">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn auth-submit mb-2">
                                Daftar
                            </button>
                        </div>

                        <div class="form-text mt-2 text-center">
                            Sudah punya akun?
                            <a href="{{ route('login.customer.form') }}"
                                class="text-primary fw-bold link-underline link-underline-opacity-0">
                                Login
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </main>
    <footer class="sticky-footer customer-footer mt-5">
        <div class="container my-auto py-4">
            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                    <h5 class="customer-footer-brand fw-bold mb-2">
                        BADMINTON RENTAL
                        <span class="customer-footer-accent">BADMINTON</span>
                    </h5>
                    <p class="customer-footer-description mb-0 small">
                        Tempat terbaik untuk bermain badminton
                    </p>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <div class="copyright customer-footer-copyright">
                        <span class="small">Copyright &copy; Hafid Yahya {{ date('Y') }}</span>
                    </div>
                    <div class="mt-2">
                        <span class="customer-footer-details small">Layanan peminjaman lapangan badminton.
                            Aplikasi pemesanan dan pengelolaan lapangan.</span>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    {{-- END CONTENT --}}

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('templates/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('templates/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('templates/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('templates/js/sb-admin-2.min.js') }}"></script>

    <!-- Page level plugins -->
    <script src="{{ asset('templates/vendor/chart.js/Chart.min.js') }}"></script>

    <!-- Page level custom scripts -->
    <script src="{{ asset('templates/js/demo/chart-area-demo.js') }}"></script>
    <script src="{{ asset('templates/js/demo/chart-pie-demo.js') }}"></script>
    {{-- TYNYMCE --}}
    <script src="{{ asset('tinymce/js/tinymce/tinymce.min.js') }}"></script>

    {{-- CUSTOME JS --}}
    @stack('scripts')
</body>

</html>
