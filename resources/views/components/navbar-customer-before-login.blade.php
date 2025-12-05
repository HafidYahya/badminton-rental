<nav class="navbar bg-light shadow-sm fixed-top navbar-expand-lg p-3">
    <div class="container-fluid">
        <a class="navbar-brand text-dark fw-bold">
            BOOKING
            <span class="logo fst-italic">BADMINTON</span>
        </a>
        <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarNav"
        >
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <a href="/" class="nav-link ms-auto">
                <i class="fa-solid fa-house"></i>
                Home
            </a>
            <div class="ms-auto d-none d-lg-flex">
                <a
                    href="{{ route("login.customer.form") }}"
                    class="btn fw-bold ps-4 pe-4 btn-light text-dark shadow-sm border-dark rounded-pill btn-sm me-2"
                >
                    Login
                </a>
                <a
                    href="{{ route("register.form") }}"
                    class="btn btn-register shadow-sm fw-bold btn-sm text-light rounded-pill ps-3 pe-3"
                >
                    Register
                </a>
            </div>
            <div class="d-lg-none mt-3">
                <div class="justify-content-start">
                    <a
                        href="{{ route("login.customer.form") }}"
                        class="btn fw-bold ps-4 pe-4 btn-light text-dark shadow-sm border-dark rounded-pill btn-sm me-2"
                    >
                        Login
                    </a>
                    <a
                        href="{{ route("register.form") }}"
                        class="btn btn-register shadow-sm fw-bold btn-sm text-light rounded-pill ps-3 pe-3"
                    >
                        Register
                    </a>
                </div>
            </div>
        </div>
    </div>
</nav>
