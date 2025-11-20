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

        <title>@yield('title')</title>

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
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        {{-- Custome CSS --}}
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    </head>

    <body id="page-top">
        <!-- Page Wrapper -->
        <div id="wrapper">
            <!-- Sidebar -->
            @include("components.sidebar")
            <!-- End of Sidebar -->

            <!-- Content Wrapper -->
            <div id="content-wrapper" class="d-flex flex-column">
                <!-- Main Content -->
                <div id="content">
                    <!-- Topbar -->
                    @include("components.navbar")
                    <!-- End of Topbar -->

                    <!-- Begin Page Content -->
                    <div class="container-fluid">
                        <!-- Page Heading -->
                        <div
                            class="d-sm-flex align-items-center justify-content-between mb-5"
                        >
                            <h1 class="h3 mb-0 text-gray-800"><strong>@yield('page-heading')</strong></h1>
                        </div>
                        @yield('content')
                    <!-- /.container-fluid -->
                </div>
                <!-- End of Main Content -->

                <!-- Footer -->
                @include("components.footer")
                <!-- End of Footer -->
            </div>
            <!-- End of Content Wrapper -->
        </div>
        <!-- End of Page Wrapper -->

        <!-- Bootstrap core JavaScript-->
        <script src="{{ asset("templates/vendor/jquery/jquery.min.js") }}"></script>
        <script src="{{ asset("templates/vendor/bootstrap/js/bootstrap.bundle.min.js") }}"></script>

        <!-- Core plugin JavaScript-->
        <script src="{{ asset("templates/vendor/jquery-easing/jquery.easing.min.js" )}}"></script>

        <!-- Custom scripts for all pages-->
        <script src="{{ asset("templates/js/sb-admin-2.min.js") }}"></script>

        <!-- Page level plugins -->
        <script src="{{ asset("templates/vendor/chart.js/Chart.min.js") }}"></script>

        <!-- Page level custom scripts -->
        <script src="{{ asset("templates/js/demo/chart-area-demo.js") }}"></script>
        <script src="{{ asset("templates/js/demo/chart-pie-demo.js") }}"></script>
        {{-- CUSTOME JS --}}
        @stack('scripts')
    </body>
</html>
