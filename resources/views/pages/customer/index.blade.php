<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />

    <title>Badminton</title>
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
    <main class="court-listing-page">
        <section class="container court-listing-section" aria-labelledby="courtListingTitle">
            <header class="court-listing-header">
                <p class="court-listing-eyebrow">BADMINTON RENTAL</p>
                <p>Temukan lapangan yang sesuai dan pesan jadwal bermain Anda.</p>
            </header>
            <div class="row g-4">
                @foreach ($lapangan as $lp)
                    <div class="col-12 col-sm-6 col-xl-4">
                        <article class="card court-card h-100">
                            <img src="{{ asset('uploads/lapangan/' . $lp->l_foto) }}"
                                class="card-img-top foto-lapangan-index" alt="{{ $lp->l_label }}" />
                            <div class="card-body court-card-body d-flex flex-column">
                                <h5 class="card-title booking-lapangan-title">{{ $lp->l_label }}</h5>
                                <p class="card-text booking-lapangan-price">
                                    <span>Harga per jam</span>
                                    <strong>Rp{{ number_format($lp->l_harga, 0, ',', '.') }}</strong>
                                </p>
                                @auth('customer')
                                    @if ($isTodayHoliday)
                                        <button class="btn mt-auto court-unavailable-button" disabled>
                                            Hari Ini Libur
                                        </button>
                                    @elseif ($lp->l_status === 'active')
                                        <a href="{{ route('booking.index', $lp->l_id) }}"
                                            class="btn booking-btn-primary mt-auto">
                                            Pesan Sekarang
                                        </a>
                                    @else
                                        <button class="btn mt-auto court-unavailable-button" disabled>
                                            Pesan Sekarang
                                        </button>
                                    @endif
                                @else
                                    @if ($isTodayHoliday)
                                        <button class="btn mt-auto court-unavailable-button" disabled>
                                            Hari Ini Libur
                                        </button>
                                    @else
                                        <a href="{{ route('login.customer') }}" class="btn booking-btn-primary mt-auto">
                                            Pesan Sekarang
                                        </a>
                                    @endif
                                @endauth
                            </div>
                        </article>
                    </div>
                @endforeach
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

    {{-- TYNYMCE --}}
    <script src="{{ asset('tinymce/js/tinymce/tinymce.min.js') }}"></script>

    {{-- CUSTOME JS --}}
    @stack('scripts')
</body>

</html>
