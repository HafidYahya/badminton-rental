<header class="customer-site-header">
    <nav class="navbar navbar-expand-lg navbar-light customer-navbar" aria-label="Navigasi customer">
        <div class="container-fluid customer-navbar-container">
            <a class="navbar-brand customer-navbar-brand" href="{{ url('/') }}">
                <span>BADMINTON RENTAL</span>
                <span class="customer-navbar-brand-accent">BADMINTON</span>
            </a>

            <ul class="navbar-nav ms-auto customer-navbar-nav">
                <li class="nav-item dropdown">
                    <button class="nav-link dropdown-toggle customer-profile-toggle" type="button"
                        data-bs-toggle="dropdown" aria-expanded="false"
                        aria-label="Menu akun {{ Auth::guard('customer')->user()->c_nama_lengkap }}">
                        <span class="customer-profile-name">
                            {{ Auth::guard('customer')->user()->c_nama_lengkap }}
                        </span>
                        <img class="customer-profile rounded-circle"
                            src="{{ asset('uploads/customers/' . Auth::guard('customer')->user()->c_foto_profile) }}"
                            alt="Foto profil {{ Auth::guard('customer')->user()->c_nama_lengkap }}" />
                    </button>

                    <ul class="dropdown-menu dropdown-menu-end customer-account-menu">
                        <li>
                            <a href="{{ url('/') }}" class="dropdown-item customer-account-link">
                                <i class="fa-solid fa-house" aria-hidden="true"></i>
                                <span>Home</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('riwayat.booking', Auth::guard('customer')->user()->c_id) }}"
                                class="dropdown-item customer-account-link">
                                <i class="fa-solid fa-clock-rotate-left" aria-hidden="true"></i>
                                <span>Riwayat Booking</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('edit.profile.customer', Auth::guard('customer')->user()->c_id) }}"
                                class="dropdown-item customer-account-link">
                                <i class="fa-solid fa-user-gear" aria-hidden="true"></i>
                                <span>Pengaturan Privasi</span>
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a href="{{ route('logout') }}" class="dropdown-item customer-account-link">
                                <i class="fa-solid fa-right-from-bracket" aria-hidden="true"></i>
                                <span>Logout</span>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>
