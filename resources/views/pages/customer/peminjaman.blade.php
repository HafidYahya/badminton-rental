<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />

    <title>BOOKING LAPANGAN - WISMA HARAPAN</title>
    {{-- GOOGLE FONT --}}
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet" />

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

<body>
    {{-- CONTENT --}}
    @include('components.navbar-customer-after-login')
    <div class="main-section-peminjaman ">
        <div class="container-fluid ">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                    <img class="img-fluid rounded shadow-sm" src="{{ asset('uploads/lapangan/' . $lapangan->l_foto) }}"
                        alt="Foto Lapangan">
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                    <h2>{{ $lapangan->l_label }}</h2>
                    <h5 class="mb-3">
                        Harga/Jam :
                        <small class="text-body-dark">Rp {{ number_format($lapangan->l_harga, 0, ',', '.') }}</small>
                    </h5>
                    <h5>Deskripsi:</h5>
                    <div class="deskripsi">{!! $lapangan->l_deskripsi !!}</div>
                </div>
            </div>
        </div>
    </div>
    @include('components.footer')

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
