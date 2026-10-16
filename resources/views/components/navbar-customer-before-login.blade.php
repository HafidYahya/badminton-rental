<header class="customer-site-header">
    <nav class="navbar navbar-expand-lg navbar-light customer-navbar" aria-label="Navigasi utama">
        <div class="container-fluid customer-navbar-container">
            <a class="navbar-brand customer-navbar-brand" href="{{ url('/') }}">
                <span>BADMINTON RENTAL</span>
                <span class="customer-navbar-brand-accent">BADMINTON</span>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#customerPublicNavigation" aria-controls="customerPublicNavigation"
                aria-expanded="false" aria-label="Buka menu navigasi">
                <span class="navbar-toggler-icon" aria-hidden="true"></span>
            </button>

            <div class="collapse navbar-collapse" id="customerPublicNavigation">
                <ul class="navbar-nav ms-auto customer-navbar-nav">
                    <li class="nav-item">
                        <a href="{{ url('/') }}" class="nav-link customer-nav-link">Home</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('login.customer.form') }}" class="btn customer-nav-button customer-nav-login">
                            Login
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('register.form') }}" class="btn customer-nav-button customer-nav-register">
                            Register
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>
