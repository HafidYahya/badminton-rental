<ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar">
    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard') }}">
        <div class="sidebar-brand-icon rotate-n-10">
            <i class="fa-solid fa-magnifying-glass-chart"></i>
        </div>
        <div class="sidebar-brand-text mx-3">BADMINTON</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0" />

    <!-- Nav Item - Dashboard -->
    <li class="nav-item">
        <a class="nav-link {{ Route::is('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider" />

    <!-- Heading -->
    <div class="sidebar-heading">Master</div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link {{ Route::is('lapangan.*') ? 'active' : '' }}" href="{{ route('lapangan.index') }}">
            <i class="fa-solid fa-font-awesome"></i>
            <span>Lapangan</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ Route::is('customer.*') ? 'active' : '' }}" href="{{ route('customer.index') }}">
            <i class="fa-solid fa-users-rays"></i>
            <span>Customer</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider" />

    <!-- Heading -->
    @if (false)
        <div class="sidebar-heading">Jadwal</div>
        <li class="nav-item">
            <a class="nav-link {{ Route::is('jam-operasional.*') ? 'active' : '' }}"
                href="{{ route('jam-operasional.index') }}">
                <i class="fa-solid fa-clock"></i>
                <span>Jam Operasional</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ Route::is('hari.libur.index') ? 'active' : '' }}" href="/hari-libur">
                <i class="fas fa-calendar-xmark"></i>
                <span>Hari Libur</span>
            </a>
        </li>
        <!-- Divider -->
        <hr class="sidebar-divider" />
    @endif

    <!-- Heading -->
    <div class="sidebar-heading">Pengaturan</div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link {{ Route::is('user.*') ? 'active' : '' }}" href="{{ route('user.index') }}">
            <i class="fas fa-fw fa-users"></i>
            <span>Kelola Pengguna</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block" />

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
