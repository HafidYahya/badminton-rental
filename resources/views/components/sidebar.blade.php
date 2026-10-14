<ul class="navbar-nav sidebar sidebar-light accordion admin-sidebar" id="accordionSidebar"
    aria-label="Navigasi admin">
    <li class="nav-item sidebar-brand-item">
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard') }}">
            <span class="sidebar-brand-icon" aria-hidden="true">
                <i class="fa-solid fa-magnifying-glass-chart"></i>
            </span>
            <span class="sidebar-brand-text mx-3">ADMIN PANEL</span>
        </a>
    </li>

    <li class="nav-item sidebar-section-start">
        <a class="nav-link {{ Route::is('dashboard') ? 'active' : '' }}"
            href="{{ route('dashboard') }}" @if (Route::is('dashboard')) aria-current="page" @endif>
            <i class="fas fa-fw fa-tachometer-alt" aria-hidden="true"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <li class="sidebar-heading">Transaksi</li>
    <li class="nav-item">
        <a class="nav-link {{ Route::is('transaksi.booking') ? 'active' : '' }}"
            href="{{ route('transaksi.booking') }}" @if (Route::is('transaksi.booking')) aria-current="page" @endif>
            <i class="fa-solid fa-cart-shopping" aria-hidden="true"></i>
            <span>Kelola Pesanan</span>
        </a>
    </li>

    <li class="sidebar-heading">Master</li>
    <li class="nav-item">
        <a class="nav-link {{ Route::is('lapangan.*') ? 'active' : '' }}"
            href="{{ route('lapangan.index') }}" @if (Route::is('lapangan.*')) aria-current="page" @endif>
            <i class="fa-solid fa-table-cells-large" aria-hidden="true"></i>
            <span>Lapangan</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ Route::is('customer.*') ? 'active' : '' }}"
            href="{{ route('customer.index') }}" @if (Route::is('customer.*')) aria-current="page" @endif>
            <i class="fa-solid fa-users" aria-hidden="true"></i>
            <span>Customer</span>
        </a>
    </li>

    <li class="sidebar-heading">Jadwal</li>
    <li class="nav-item">
        <a class="nav-link {{ Route::is('jam-operasional.*') ? 'active' : '' }}"
            href="{{ route('jam-operasional.index') }}" @if (Route::is('jam-operasional.*')) aria-current="page" @endif>
            <i class="fa-solid fa-clock" aria-hidden="true"></i>
            <span>Jam Operasional</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ Route::is('hari.libur.*') ? 'active' : '' }}"
            href="{{ route('hari.libur.index') }}" @if (Route::is('hari.libur.*')) aria-current="page" @endif>
            <i class="fa-solid fa-calendar-xmark" aria-hidden="true"></i>
            <span>Hari Libur</span>
        </a>
    </li>

    <li class="sidebar-heading">Pengaturan</li>
    <li class="nav-item">
        <a class="nav-link {{ Route::is('user.*') ? 'active' : '' }}"
            href="{{ route('user.index') }}" @if (Route::is('user.*')) aria-current="page" @endif>
            <i class="fas fa-fw fa-users" aria-hidden="true"></i>
            <span>Kelola Pengguna</span>
        </a>
    </li>

    <li class="sidebar-toggle-item d-none d-md-block">
        <hr class="sidebar-divider">
        <button class="rounded-circle border-0" id="sidebarToggle" type="button" aria-label="Ciutkan sidebar"
            title="Ciutkan sidebar"></button>
    </li>
</ul>
