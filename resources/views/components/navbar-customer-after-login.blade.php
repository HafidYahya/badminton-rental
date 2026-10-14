<nav class="navbar navbar-dark shadow-sm fixed-top navbar-expand-lg p-3"
    style="background: linear-gradient(135deg, #2c2c2c 0%, #1a1a1a 100%);">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold" style="color: #ffb22c;">
            WISMA HARAPAN
            <span class="logo fst-italic" style="color: #ffa500; font-weight: 600;">BADMINTON</span>
        </a>
        <ul class="navbar-nav">
            <li class="nav-item dropdown dropstart no-arrow position-relative">
                <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button"
                    data-bs-toggle="dropdown" aria-expanded="false" style="color: #ffb22c;">
                    <span class="mr-2 d-none d-lg-inline small me-2">
                        {{ Auth::guard('customer')->user()->c_nama_lengkap }}
                    </span>
                    <img class="customer-profile rounded-circle" style="border: 2px solid #ffb22c;"
                        src="{{ asset('uploads/customers/' . Auth::guard('customer')->user()->c_foto_profile) }}"
                        alt="Foto Profile" />
                </a>
                <ul class="dropdown-menu position-absolute shadow-lg"
                    style="background: linear-gradient(135deg, #2c2c2c 0%, #1a1a1a 100%); border: 2px solid #ffb22c;">
                    <li>
                        <a href="/" class="dropdown-item mb-2 navbar-dropdown-item" style="color: #ffb22c;">
                            <i class="fa-solid fa-house me-2"></i>
                            Home
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('riwayat.booking', Auth::guard('customer')->user()->c_id) }}"
                            class="dropdown-item mb-2 navbar-dropdown-item" style="color: #ffb22c;">
                            <i class="fa-solid fa-clock-rotate-left me-2"></i>
                            Riwayat Booking
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item mb-2 navbar-dropdown-item" style="color: #ffb22c;"
                            href="{{ route('edit.profile.customer', Auth::guard('customer')->user()->c_id) }}">
                            <i class="fa-solid fa-user-gear me-2"></i>
                            Pengaturan Privasi
                        </a>
                    </li>
                    <li>
                        <hr class="dropdown-divider" style="border-color: #ffb22c; opacity: 0.3;">
                    </li>
                    <li>
                        <a class="dropdown-item mb-2 navbar-dropdown-item" href="{{ route('logout') }}"
                            style="color: #ffa500;">
                            <i class="fa-solid fa-right-from-bracket me-2"></i>
                            Logout
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</nav>
