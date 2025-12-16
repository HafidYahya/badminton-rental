<nav class="navbar navbar-dark shadow-sm fixed-top navbar-expand-lg p-3"
    style="background: linear-gradient(135deg, #2c2c2c 0%, #1a1a1a 100%);">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold" style="color: #ffb22c;">
            WISMA HARAPAN
            <span class="logo fst-italic" style="color: #ffa500; font-weight: 600;">BADMINTON</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            style="border-color: #ffb22c;">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <a href="/" class="nav-link ms-auto navbar-home-link" style="color: #ffb22c;">
                <i class="fa-solid fa-house me-1"></i>
                Home
            </a>
            <div class="ms-auto d-none d-lg-flex">
                <a href="{{ route('login.customer.form') }}"
                    class="btn fw-bold ps-4 pe-4 shadow-sm rounded-pill btn-sm me-2 navbar-btn-login"
                    style="background-color: #ffb22c; color: #1a1a1a; border: 2px solid #ffb22c;">

                    Login
                </a>
                <a href="{{ route('register.form') }}"
                    class="btn shadow-sm fw-bold btn-sm rounded-pill ps-3 pe-3 navbar-btn-register"
                    style="background: linear-gradient(135deg, #ffb22c 0%, #ffa500 100%); color: #1a1a1a; border: 2px solid #ffb22c;">
                    Register
                </a>
            </div>
            <div class="d-lg-none mt-3">
                <div class="justify-content-start">
                    <a href="{{ route('login.customer.form') }}"
                        class="btn fw-bold ps-4 pe-4 shadow-sm rounded-pill btn-sm me-2 navbar-btn-login"
                        style="background-color: #ffb22c; color: #1a1a1a; border: 2px solid #ffb22c;">

                        Login
                    </a>
                    <a href="{{ route('register.form') }}"
                        class="btn shadow-sm fw-bold btn-sm rounded-pill ps-3 pe-3 navbar-btn-register"
                        style="background: linear-gradient(135deg, #ffb22c 0%, #ffa500 100%); color: #1a1a1a; border: 2px solid #ffb22c;">
                        Register
                    </a>
                </div>
            </div>
        </div>
    </div>
</nav>
