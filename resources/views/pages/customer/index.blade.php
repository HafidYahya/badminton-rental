<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />

    <title>WISMA HARAPAN - BADMINTON</title>
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
    @if (Auth::guard('customer')->check())
        @include('components.navbar-customer-after-login')
    @else
        @include('components.navbar-customer-before-login')
    @endif
    <div class="main-section-index">
        <div class="container-fluid bg-main">
            <div class="row">
                <div class="col-12">
                    <h2 class="text-center title fw-bold">
                        Pesan Lapangan Badminton Favoritmu Sekarang!
                    </h2>
                </div>
            </div>
        </div>
    </div>
    <div class="container py-5">
        <div class="row g-4">
            @foreach ($lapangan as $lp)
                <div class="col-12 col-md-4">
                    <div class="card h-100 shadow-sm border-0"
                        style="border: 2px solid #ffb22c; border-radius: 15px; overflow: hidden;">
                        <img src="{{ asset('uploads/lapangan/' . $lp->l_foto) }}"
                            class="card-img-top foto-lapangan-index" alt="{{ $lp->l_label }}" />
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title booking-lapangan-title">{{ $lp->l_label }}</h5>
                            <p class="card-text booking-lapangan-price">
                                Harga: Rp
                                {{ number_format($lp->l_harga, 0, ',', '.') }}/jam
                            </p>
                            @auth('customer')
                                @if ($isTodayHoliday)
                                    <button class="btn mt-auto disabled"
                                        style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); color: white; border: 2px solid #dc3545; padding: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; border-radius: 8px;">
                                        Hari Ini Libur
                                    </button>
                                @elseif ($lp->l_status === 'active')
                                    <a href="{{ route('booking.index', $lp->l_id) }}"
                                        class="btn booking-btn-primary mt-auto">
                                        Pesan Sekarang
                                    </a>
                                @else
                                    <button class="btn mt-auto disabled"
                                        style="background: linear-gradient(135deg, #6c757d 0%, #5a6268 100%); color: white; border: 2px solid #6c757d; padding: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; border-radius: 8px;">
                                        Pesan Sekarang
                                    </button>
                                @endif
                            @else
                                @if ($isTodayHoliday)
                                    <button class="btn mt-auto disabled"
                                        style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); color: white; border: 2px solid #dc3545; padding: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; border-radius: 8px;">
                                        Hari Ini Libur
                                    </button>
                                @else
                                    <a href="{{ route('login.customer') }}" class="btn booking-btn-primary mt-auto">
                                        Pesan Sekarang
                                    </a>
                                @endif
                            @endauth
                        </div>
                    </div>
                </div>
            @endforeach
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
