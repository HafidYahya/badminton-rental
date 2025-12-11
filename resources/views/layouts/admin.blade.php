<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />

        <title>@yield("title")</title>

        {{-- Font Awesome --}}
        <link
            rel="stylesheet"
            href="{{ asset("templates/vendor/fontawesome-free/css/all.min.css") }}"
        />
        <link
            rel="stylesheet"
            href="{{ asset("fontawesome/css/all.min.css") }}"
        />

        {{-- Google Fonts --}}
        <link
            href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900"
            rel="stylesheet"
        />

        {{-- SB Admin 2 --}}
        <link
            rel="stylesheet"
            href="{{ asset("templates/css/sb-admin-2.min.css") }}"
        />

        {{-- Vite (Tailwind, Alpine, atau asset Anda) --}}
        @vite(["resources/css/app.css", "resources/js/app.js"])

        {{-- Custom CSS --}}
        <link rel="stylesheet" href="{{ asset("css/style.css") }}" />
        {{-- FULL CALENDER --}}
        <link
            href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css"
            rel="stylesheet"
        />
    </head>

    <body id="page-top">
        <!-- Wrapper -->
        <div id="wrapper">
            {{-- Sidebar --}}
            @include("components.sidebar")

            <!-- Content Wrapper -->
            <div id="content-wrapper" class="d-flex flex-column">
                <!-- Main Content -->
                <div id="content">
                    {{-- Navbar --}}
                    @include("components.navbar")

                    <!-- Page Content -->
                    <div class="container-fluid">
                        {{-- Page Heading --}}
                        <div
                            class="d-sm-flex align-items-center justify-content-between mb-4"
                        >
                            <h1 class="h3 text-gray-800 font-weight-bold">
                                @yield("page-heading")
                            </h1>
                        </div>

                        {{-- Content --}}
                        @yield("content")
                    </div>
                    <!-- End .container-fluid -->
                </div>
                <!-- End Main Content -->

                {{-- Footer --}}
                @include("components.footer")
            </div>
            <!-- End Content Wrapper -->
        </div>
        <!-- End Wrapper -->

        <!-- Scroll to Top Button-->
        <a class="scroll-to-top rounded" href="#page-top">
            <i class="fas fa-angle-up"></i>
        </a>

        {{-- Core JS --}}
        <script src="{{ asset("templates/vendor/jquery/jquery.min.js") }}"></script>
        <script src="{{ asset("templates/vendor/bootstrap/js/bootstrap.bundle.min.js") }}"></script>
        <script src="{{ asset("templates/vendor/jquery-easing/jquery.easing.min.js") }}"></script>

        {{-- SB Admin JS --}}
        <script src="{{ asset("templates/js/sb-admin-2.min.js") }}"></script>

        {{-- TinyMCE --}}
        <script src="{{ asset("tinymce/js/tinymce/tinymce.min.js") }}"></script>
        <script>
            tinymce.init({
                selector: '#deskripsi',
                height: 400,
                plugins: 'lists',
                toolbar:
                    'bold italic underline | bullist numlist | alignleft aligncenter alignright | undo redo',
                menubar: false,
                license_key: 'gpl',
            });
        </script>
        {{-- FULL CALENDER --}}
        <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.19/index.global.min.js"></script>

        {{-- SWEET ALERT --}}
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        {{-- Custom JS From Child Pages --}}
        @stack("scripts")
    </body>
</html>
