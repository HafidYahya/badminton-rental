<nav class="navbar bg-light shadow-sm fixed-top navbar-expand-lg p-3">
    <div class="container-fluid">
        <a class="navbar-brand text-dark fw-bold">
            BOOKING
            <span class="logo fst-italic">BADMINTON</span>
        </a>
        <ul class="navbar-nav">
            <li class="nav-item dropdown dropstart no-arrow position-relative">
                <a
                    class="nav-link dropdown-toggle"
                    href="#"
                    role="button"
                    data-bs-toggle="dropdown"
                    aria-expanded="false"
                >
                    <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                        {{ Auth::guard("customer")->user()->c_nama_lengkap }}
                    </span>
                    <img
                        class="customer-profile rounded-circle"
                        src="{{ asset("uploads/customers/" . Auth::guard("customer")->user()->c_foto_profile) }}"
                        alt="Foto Profile"
                    />
                </a>
                <ul class="dropdown-menu position-absolute">
                    <li>
                        <a href="/" class="dropdown-item mb-2">
                            <i class="fa-solid fa-house"></i>
                            Home
                        </a>
                    </li>
                    <li>
                        <a
                            class="dropdown-item mb-2"
                            href="{{ route("edit.profile.customer", Auth::guard("customer")->user()->c_id) }}"
                        >
                            <i class="fa-solid fa-user-gear"></i>
                            Pegaturan Privasi
                        </a>
                    </li>
                    <li>
                        <a
                            class="dropdown-item mb-2"
                            href="{{ route("logout") }}"
                        >
                            <i class="fa-solid fa-right-from-bracket"></i>
                            Logout
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</nav>
