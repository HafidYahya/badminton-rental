<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />

    <title>BOOKING LAPANGAN - BADMINTON RENTAL</title>
    {{-- GOOGLE FONT --}}
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet" />

    <link href="{{ asset('templates/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css" />
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet" />

    <!-- Custom styles for this template-->
    <link href="{{ asset('templates/css/sb-admin-2.min.css') }}" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Custome CSS --}}
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="{{ asset('fontawesome/css/all.min.css') }}" />

    <style>
        .booking-container {
            padding: 2rem 1rem;
            max-width: 1400px;
            margin: 3rem auto 4rem;
        }

        .page-header {
            margin-bottom: 2rem;
        }

        .page-header h2 {
            font-size: 1.75rem;
            font-weight: 700;
            color: #ffb22c;
            margin-bottom: 0.5rem;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);
        }

        .page-header p {
            color: #666666;
            margin: 0;
        }

        .table-card {
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 8px 30px rgba(255, 178, 44, 0.2);
            overflow: hidden;
            border: 2px solid #ffb22c;
        }

        .table-responsive {
            padding: 0;
        }

        .table {
            margin-bottom: 0;
        }

        .table thead th {
            background: linear-gradient(135deg, #2c2c2c 0%, #1a1a1a 100%);
            border-bottom: 3px solid #ffb22c;
            color: #ffb22c;
            font-weight: 700;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 1rem;
        }

        .table tbody td {
            padding: 1rem;
            vertical-align: middle;
            color: #2c2c2c;
            border-bottom: 1px solid #f0f0f0;
        }

        .table tbody tr {
            transition: all 0.3s ease;
        }

        .badge {
            padding: 0.5rem 0.875rem;
            font-size: 0.75rem;
            font-weight: 700;
            border-radius: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .text-bg-secondary {
            background: linear-gradient(135deg, #6c757d 0%, #5a6268 100%);
            color: white;
        }

        .text-bg-warning {
            background: linear-gradient(135deg, #ffb22c 0%, #ffa500 100%);
            color: #1a1a1a;
        }

        .text-bg-success {
            background: linear-gradient(135deg, #28a745 0%, #218838 100%);
            color: white;
        }

        .text-bg-danger {
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
            color: white;
        }

        .btn-cancel {
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
            border: 2px solid #dc3545;
            color: white;
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
            font-weight: 600;
            border-radius: 8px;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn-cancel:hover {
            background: linear-gradient(135deg, #c82333 0%, #bd2130 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(220, 53, 69, 0.4);
            color: white;
        }

        .empty-state {
            padding: 3rem 1rem;
            text-align: center;
        }

        .empty-state i {
            font-size: 3rem;
            color: #ffb22c;
            margin-bottom: 1rem;
        }

        .empty-state p {
            color: #666666;
            font-size: 1rem;
            font-weight: 500;
        }

        .modal-content {
            border-radius: 15px;
            border: 2px solid #ffb22c;
            box-shadow: 0 10px 40px rgba(255, 178, 44, 0.3);
        }

        .modal-header {
            background: linear-gradient(135deg, #2c2c2c 0%, #1a1a1a 100%);
            border-bottom: 3px solid #ffb22c;
            padding: 1.25rem 1.5rem;
            border-radius: 15px 15px 0 0;
        }

        .modal-title {
            font-weight: 700;
            color: #ffb22c;
        }

        .modal-body {
            padding: 1.5rem;
            background: #ffffff;
        }

        .modal-footer {
            border-top: 2px solid #ffb22c;
            padding: 1rem 1.5rem;
            background: #f8f9fa;
        }

        .form-label {
            font-weight: 600;
            color: #2c2c2c;
            margin-bottom: 0.5rem;
        }

        .form-control:focus {
            border-color: #ffb22c;
            box-shadow: 0 0 0 0.2rem rgba(255, 178, 44, 0.25);
        }

        .btn-secondary {
            background: linear-gradient(135deg, #6c757d 0%, #5a6268 100%);
            border: 2px solid #6c757d;
            color: white;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-secondary:hover {
            background: linear-gradient(135deg, #5a6268 0%, #545b62 100%);
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(108, 117, 125, 0.4);
            color: white;
        }

        .btn-danger {
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
            border: 2px solid #dc3545;
            color: white;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-danger:hover {
            background: linear-gradient(135deg, #c82333 0%, #bd2130 100%);
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(220, 53, 69, 0.4);
            color: white;
        }

        .btn-close {
            filter: brightness(0) invert(1);
        }

        @media (max-width: 768px) {
            .booking-container {
                padding: 1rem 0.5rem;
            }

            .page-header h2 {
                font-size: 1.5rem;
            }

            .table thead th,
            .table tbody td {
                padding: 0.75rem 0.5rem;
                font-size: 0.875rem;
            }
        }
    </style>
</head>

<body>
    {{-- CONTENT --}}
    @include('components.navbar-customer-after-login')

    <main class="booking-container booking-history-page">
        <header class="page-header booking-history-header">
            <p class="booking-history-eyebrow">AKUN CUSTOMER</p>
            <h1><i class="fas fa-calendar-check me-2" aria-hidden="true"></i>Riwayat Booking</h1>
            <p>Kelola dan pantau status pemesanan lapangan Anda.</p>
        </header>

        <section class="table-card" aria-label="Daftar pemesanan">
            <div class="table-responsive">
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Lapangan</th>
                            <th scope="col">Metode</th>
                            <th scope="col">Total Harga</th>
                            <th scope="col">Total Bayar</th>
                            <th scope="col">Tanggal</th>
                            <th scope="col">Jam Mulai</th>
                            <th scope="col">Jam Selesai</th>
                            <th scope="col">Expired At</th>
                            <th scope="col">Status</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($peminjaman as $booking)
                            <tr>
                                <td scope="row">{{ $peminjaman->firstItem() + $loop->index }}</td>
                                <td><strong>{{ $booking->lapangan->l_label }}</strong></td>
                                <td>{{ strtoupper($booking->latestOrder?->payment_method ?? '-') }}</td>
                                <td><strong class="booking-history-amount">
                                        Rp{{ number_format($booking->p_total_harga, 0, ',', '.') }}</strong>
                                </td>
                                <td><strong class="booking-history-total">
                                        Rp{{ number_format($booking->latestOrder?->total_payment ?? $booking->p_total_harga, 0, ',', '.') }}</strong>
                                </td>
                                <td>
                                    {{ Carbon\Carbon::parse($booking->p_tanggal)->locale('id')->translatedFormat('l, d F Y') }}
                                </td>
                                <td>{{ Carbon\Carbon::parse($booking->p_jam_mulai)->locale('id')->translatedFormat('H:i') }}
                                </td>
                                <td>{{ Carbon\Carbon::parse($booking->p_jam_selesai)->locale('id')->translatedFormat('H:i') }}
                                </td>
                                <td>
                                    @if ($booking->latestOrder?->expires_at)
                                        {{ Carbon\Carbon::parse($booking->latestOrder->expires_at)->locale('id')->translatedFormat('l, d F Y H:i') }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    <span
                                        class="badge 
                                        @if ($booking->p_status === 'PENDING') text-bg-secondary
                                        @elseif ($booking->p_status === 'DIBAYAR') text-bg-success
                                        @elseif ($booking->p_status === 'RUNNING') text-bg-warning
                                        @elseif ($booking->p_status === 'FINISH') text-bg-success
                                        @elseif ($booking->p_status === 'EXPIRED') text-bg-danger
                                        @else text-bg-danger @endif">
                                        {{ $booking->p_status }}
                                    </span>
                                </td>
                                <td>
                                    @if (in_array($booking->p_status, ['PENDING', 'RUNNING']))
                                        <a href="{{ route('payment', ['id' => $booking->p_id]) }}"
                                            class="btn btn-primary btn-sm">
                                            <i class="fas fa-credit-card mr-1"></i> Bayar
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="11">
                                    <div class="empty-state">
                                        <i class="fas fa-clipboard-list"></i>
                                        <p>Belum ada data pemesanan</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{-- Pagination di sini --}}
            @if ($peminjaman->hasPages())
                <div class="pagination-wrapper booking-history-pagination">
                    <div class="row align-items-center">
                        <div class="col-md-6 mb-3 mb-md-0 text-center text-md-start">
                            <p class="mb-0 small">
                                Menampilkan <strong>{{ $peminjaman->firstItem() ?? 0 }}</strong>
                                sampai <strong>{{ $peminjaman->lastItem() ?? 0 }}</strong>
                                dari <strong>{{ $peminjaman->total() }}</strong> pemesanan
                            </p>
                        </div>
                        <div class="col-md-6 d-flex justify-content-center justify-content-md-end">
                            {{ $peminjaman->links() }}
                        </div>
                    </div>
                </div>
            @endif
        </section>
    </main>

    @foreach ($peminjaman as $booking)
        <!-- MODAL Cancel-->
        <div class="modal fade booking-cancel-modal" id="modalCancel{{ $booking->p_id }}" data-bs-backdrop="static" data-bs-keyboard="false"
            tabindex="-1" aria-labelledby="modalCancel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="fas fa-exclamation-triangle mr-2" style="color: #ffa500;"></i>
                            Konfirmasi Pembatalan
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('cancel.booking', $booking->p_id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="alasanCancel{{ $booking->p_id }}" class="form-label">
                                    Alasan Pembatalan <span class="text-danger">*</span>
                                </label>
                                <textarea class="form-control" id="alasanCancel{{ $booking->p_id }}" name="alasan_cancel" rows="4" required
                                    placeholder="Mohon berikan alasan pembatalan booking..."></textarea>
                                <small class="text-muted">Minimal 10 karakter</small>
                                @error('alasan_cancel')
                                    <p class="text-danger fst-italic">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                <i class="fas fa-times mr-1"></i> Batal
                            </button>
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-check mr-1"></i> Konfirmasi Pembatalan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
    <footer class="sticky-footer customer-footer mt-5">
        <div class="container my-auto py-4">
            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                    <h5 class="customer-footer-brand fw-bold mb-2">
                        BADMINTON RENTAL
                        <span class="customer-footer-accent">BADMINTON</span>
                    </h5>
                    <p class="customer-footer-description mb-0 small">
                        Tempat terbaik untuk bermain badminton
                    </p>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <div class="copyright customer-footer-copyright">
                        <span class="small">Copyright &copy; Hafid Yahya {{ date('Y') }}</span>
                    </div>
                    <div class="mt-2">
                        <span class="customer-footer-details small">Layanan peminjaman lapangan badminton.
                            Aplikasi pemesanan dan pengelolaan lapangan.</span>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    @include('sweetalert2::index')
    {{-- END CONTENT --}}

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('templates/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('templates/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('templates/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('templates/js/sb-admin-2.min.js') }}"></script>
    <script src="{{ asset('tinymce/js/tinymce/tinymce.min.js') }}"></script>

    @stack('scripts')
</body>

</html>
