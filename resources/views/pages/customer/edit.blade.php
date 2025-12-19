<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />

    <title>PENGATURAN PRIVASI</title>

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
    @include('components.navbar-customer-after-login')
    {{-- CONTENT --}}
    <div class="container d-flex justify-content-center min-vh-100 py-5 my-5 align-items-md-center">
        <div class="col-12 col-sm-10 col-md-8 col-lg-6">
            <div class="card p-2 mb-3 border-secondary shadow-sm">
                <div class="card-body">
                    @if ($customer->c_foto_profile)
                        <img src="{{ asset('uploads/customers/' . $customer->c_foto_profile) }}" alt="Foto Profile"
                            class="profile-edit-customer mb-3 mx-auto d-block rounded-circle shadow" />
                    @endif

                    <hr />

                    <form action="{{ route('edit.profile', $customer->c_id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="nama_lengkap" class="form-label">
                                Nama Lengkap*
                            </label>
                            <input type="text" class="form-control shadow-sm" id="nama_lengkap"
                                placeholder="Masukan nama lengkap" name="nama_lengkap"
                                value="{{ old('nama_lengkap', $customer->c_nama_lengkap) }}" />
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
                            <input type="number" class="form-control shadow-sm" id="no_hp"
                                placeholder="Masukan nomor handphone" name="no_hp"
                                value="{{ old('no_hp', $customer->c_no_hp) }}" />
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
                            <input type="text" class="form-control shadow-sm" id="username"
                                placeholder="Masukan username" name="username"
                                value="{{ old('username', $customer->c_username) }}" />
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
                            <input type="password" class="form-control shadow-sm" id="password" name="password"
                                placeholder="Kosongkan jika tidak ingin diubah" />
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
                            <input type="password" class="form-control shadow-sm" id="konfirmasi_password"
                                name="konfirmasi_password" placeholder="Kosongkan jika tidak ingin diubah" />
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
                            <textarea name="alamat" id="alamat" class="form-control shadow-sm">
{{ old('alamat', $customer->c_alamat) }}</textarea>
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
                            <input type="file" class="form-control shadow-sm" id="foto_profile"
                                name="foto_profile" />
                            @error('foto_profile')
                                <p class="text-danger fst-italic">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-dark border-secondary rounded-pill mb-2">
                                Save
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <a href="https://wa.me/6287882000678?text=Halo%20Admin,%20saya%20ingin%20bertanya" class="wa-float" target="_blank"
        title="Chat Admin Wisma Harapan">
        <i class="fab fa-whatsapp"></i>
    </a>
    <footer class="sticky-footer mt-5"
        style="background: linear-gradient(135deg, #1a1a1a 0%, #2c2c2c 100%); border-top: 3px solid #ffb22c;">
        <div class="container my-auto py-4">
            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                    <h5 class="fw-bold mb-2" style="color: #ffb22c;">
                        WISMA HARAPAN
                        <span style="color: #ffa500; font-style: italic;">BADMINTON</span>
                    </h5>
                    <p class="mb-0 small" style="color: #cccccc;">
                        Tempat terbaik untuk bermain badminton
                    </p>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <div class="copyright" style="color: #ffb22c;">
                        <span class="small">Copyright &copy; Muhdiatul Zannah 2025</span>
                    </div>
                    <div class="mt-2">
                        <span class="small" style="color: #cccccc;">Jl. Wisma Lantana IV No.D07-No 49, RT.006/RW.011,
                            Gembor, Kec. Periuk, Kota Tangerang, Banten 15133</span>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    @include('sweetalert2::index')

    {{-- END CONTENT --}}
    {{-- SweetAlert --}}

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
    {{-- SWEET ALERT --}}
</body>

</html>
