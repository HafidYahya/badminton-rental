<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1, shrink-to-fit=no"
        />
        <meta name="description" content="" />
        <meta name="author" content="" />

        <title>BOOKING BADMINTON</title>
        {{-- GOOGLE FONT --}}
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link
            href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap"
            rel="stylesheet"
        />

        <link
            href="{{ asset("templates/vendor/fontawesome-free/css/all.min.css") }}"
            rel="stylesheet"
            type="text/css"
        />
        <link
            href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
            rel="stylesheet"
        />

        <!-- Custom styles for this template-->
        <link
            href="{{ asset("templates/css/sb-admin-2.min.css") }}"
            rel="stylesheet"
        />
        @vite(["resources/css/app.css", "resources/js/app.js"])

        {{-- Custome CSS --}}
        <link rel="stylesheet" href="{{ asset("css/style.css") }}" />

        {{-- Font Awesome --}}
        <link
            rel="stylesheet"
            href="{{ asset("fontawesome/css/all.min.css") }}"
        />
    </head>

    <body>
        {{-- CONTENT --}}
        @if (Auth::guard("customer")->check())
            @include("components.navbar-customer-after-login")
        @else
            @include("components.navbar-customer-before-login")
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
                        <div class="card h-100 shadow-sm">
                            <img
                                src="{{ asset("uploads/lapangan/" . $lp->l_foto) }}"
                                class="card-img-top foto-lapangan-index"
                                alt="{{ $lp->l_label }}"
                            />
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title">{{ $lp->l_label }}</h5>
                                <p class="card-text">
                                    Harga: Rp
                                    {{ number_format($lp->l_harga, 0, ",", ".") }}/jam
                                </p>
                                @if ($lp->l_status === "active")
                                    <a href="" class="btn btn-primary mt-auto">
                                        Pesan Sekarang
                                    </a>
                                @else
                                    <a
                                        href=""
                                        class="btn btn-secondary mt-auto disabled"
                                    >
                                        Pesan Sekarang
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        @include("components.footer")

        {{-- END CONTENT --}}

        <!-- Bootstrap core JavaScript-->
        <script src="{{ asset("templates/vendor/jquery/jquery.min.js") }}"></script>
        <script src="{{ asset("templates/vendor/bootstrap/js/bootstrap.bundle.min.js") }}"></script>

        <!-- Core plugin JavaScript-->
        <script src="{{ asset("templates/vendor/jquery-easing/jquery.easing.min.js") }}"></script>

        <!-- Custom scripts for all pages-->
        <script src="{{ asset("templates/js/sb-admin-2.min.js") }}"></script>

        <!-- Page level plugins -->
        <script src="{{ asset("templates/vendor/chart.js/Chart.min.js") }}"></script>

        <!-- Page level custom scripts -->
        <script src="{{ asset("templates/js/demo/chart-area-demo.js") }}"></script>
        <script src="{{ asset("templates/js/demo/chart-pie-demo.js") }}"></script>
        {{-- TYNYMCE --}}
        <script src="{{ asset("tinymce/js/tinymce/tinymce.min.js") }}"></script>

        {{-- CUSTOME JS --}}
        @stack("scripts")
    </body>
</html>
