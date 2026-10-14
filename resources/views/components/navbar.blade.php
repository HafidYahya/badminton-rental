<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3" type="button"
        aria-label="Buka navigasi" aria-controls="accordionSidebar" aria-expanded="false">
        <i class="fa fa-bars" aria-hidden="true"></i>
    </button>

    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">
        <!-- Nav Item - Alerts -->
        <li class="nav-item dropdown no-arrow mx-1">
            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-bell fa-fw"></i>
                <!-- Counter - Alerts -->
                @if ($notifCount > 0)
                    <span class="badge badge-danger badge-counter"
                        style="position: absolute; transform: translate(50%, -50%); font-size: 0.75rem; padding: 0.25em 0.4em;">{{ $notifCount }}</span>
                @endif
            </a>
            <!-- Dropdown - Alerts -->
            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                aria-labelledby="alertsDropdown">
                <h6 class="dropdown-header text-white font-weight-bold"
                    style="background-color: #ffb22c; border-color: #ffb22c;">
                    PEMBERITAHUAN (SUDAH BAYAR)
                </h6>
                @forelse ($notifList as $item)
                    <a class="dropdown-item d-flex align-items-center"
                        href="{{ route('transaksi.booking', ['p_status' => 'DIBAYAR']) }}">
                        <div class="mr-3">
                            <div class="icon-circle bg-success text-white d-flex align-items-center justify-content-center"
                                style="width: 40px; height: 40px; border-radius: 50%;">
                                <i class="fas fa-money-bill-wave"></i>
                            </div>
                        </div>
                        <div>
                            <div class="small text-gray-500">
                                {{ \Carbon\Carbon::parse($item->p_tanggal)->locale('id')->translatedFormat('d F Y') }}
                            </div>
                            <span class="font-weight-bold">{{ $item->customer->c_nama_lengkap }}</span>
                            <div class="small text-gray-600">Membayar booking {{ $item->lapangan->l_label }}</div>
                            <div class="small text-gray-500 font-italic">
                                Jam: {{ \Carbon\Carbon::parse($item->p_jam_mulai)->format('H:i') }} -
                                {{ \Carbon\Carbon::parse($item->p_jam_selesai)->format('H:i') }}
                            </div>
                        </div>
                    </a>
                @empty
                    <a class="dropdown-item text-center small text-gray-500 py-3" href="#">Tidak ada transaksi
                        baru yang dibayar</a>
                @endforelse
                <a class="dropdown-item text-center small text-gray-500 font-weight-bold"
                    href="{{ route('transaksi.booking', ['p_status' => 'DIBAYAR']) }}">
                    Tampilkan Semua Pesanan Baru
                </a>
            </div>
        </li>

        <div class="topbar-divider d-none d-sm-block"></div>

        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                    @auth
                        {{ Auth::guard('web')->user()->u_nama_lengkap }}
                    @endauth
                </span>
                <img class="img-profile rounded-circle"
                    src="{{ asset('uploads/users/' . Auth::guard('web')->user()->u_foto_profil) }}" />
            </a>
            <!-- Dropdown - User Information -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="{{ route('user.edit', Auth::guard('web')->user()->u_id) }}">
                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                    Pengaturan Profil
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="{{ route('logout') }}">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Logout
                </a>
            </div>
        </li>
    </ul>
</nav>
