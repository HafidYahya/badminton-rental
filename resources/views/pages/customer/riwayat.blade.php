<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />

    <title>BOOKING LAPANGAN - WISMA HARAPAN</title>
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
            margin: 120px auto;
        }

        .page-header {
            margin-bottom: 2rem;
        }

        .page-header h2 {
            font-size: 1.75rem;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 0.5rem;
        }

        .page-header p {
            color: #6c757d;
            margin: 0;
        }

        .table-card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }

        .table-responsive {
            padding: 0;
        }

        .table {
            margin-bottom: 0;
        }

        .table thead th {
            background: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
            color: #495057;
            font-weight: 600;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 1rem;
        }

        .table tbody td {
            padding: 1rem;
            vertical-align: middle;
            color: #495057;
        }

        .table tbody tr {
            transition: background-color 0.2s ease;
        }

        .table tbody tr:hover {
            background-color: #f8f9fa;
        }

        .badge {
            padding: 0.5rem 0.875rem;
            font-size: 0.75rem;
            font-weight: 600;
            border-radius: 6px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn-cancel {
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
            font-weight: 500;
            border-radius: 6px;
            transition: all 0.2s ease;
        }

        .btn-cancel:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(220, 53, 69, 0.3);
        }

        .empty-state {
            padding: 3rem 1rem;
            text-align: center;
        }

        .empty-state i {
            font-size: 3rem;
            color: #dee2e6;
            margin-bottom: 1rem;
        }

        .empty-state p {
            color: #6c757d;
            font-size: 1rem;
        }

        .modal-content {
            border-radius: 12px;
            border: none;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
        }

        .modal-header {
            background: #f8f9fa;
            border-bottom: 1px solid #dee2e6;
            padding: 1.25rem 1.5rem;
            border-radius: 12px 12px 0 0;
        }

        .modal-title {
            font-weight: 600;
            color: #2c3e50;
        }

        .modal-body {
            padding: 1.5rem;
        }

        .modal-footer {
            border-top: 1px solid #dee2e6;
            padding: 1rem 1.5rem;
        }

        .form-label {
            font-weight: 500;
            color: #495057;
            margin-bottom: 0.5rem;
        }

        .form-control:focus {
            border-color: #80bdff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, .25);
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

    <div class="booking-container">
        <div class="page-header">
            <h2><i class="fas fa-calendar-check mr-2"></i>Riwayat Booking Lapangan</h2>
            <p>Kelola dan pantau semua pemesanan lapangan Anda</p>
        </div>

        <div class="table-card">
            <div class="table-responsive">
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Lapangan</th>
                            <th scope="col">Total Harga</th>
                            <th scope="col">Tanggal</th>
                            <th scope="col">Jam Mulai</th>
                            <th scope="col">Jam Selesai</th>
                            <th scope="col">Total Jam</th>
                            <th scope="col">Status</th>
                            <th scope="col">Batalkan Pesanan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($peminjaman as $booking)
                            <tr>
                                <td scope="row">{{ $loop->iteration }}</td>
                                <td><strong>{{ $booking->lapangan->l_label }}</strong></td>
                                <td><strong>Rp{{ number_format($booking->p_total_harga, 0, ',', '.') }}</strong></td>
                                <td>
                                    {{ Carbon\Carbon::parse($booking->p_tanggal)->locale('id')->translatedFormat('l, d F Y') }}
                                </td>
                                <td>{{ Carbon\Carbon::parse($booking->p_jam_mulai)->locale('id')->translatedFormat('H:i') }}
                                </td>
                                <td>{{ Carbon\Carbon::parse($booking->p_jam_selesai)->locale('id')->translatedFormat('H:i') }}
                                </td>
                                <td>{{ $booking->p_total_jam }} Jam</td>
                                <td>
                                    <span
                                        class="badge 
                                        @if ($booking->p_status === 'PENDING') text-bg-secondary
                                        @elseif ($booking->p_status === 'RUNNING') text-bg-warning
                                        @elseif ($booking->p_status === 'FINISH') text-bg-success
                                        @else text-bg-danger @endif">
                                        {{ $booking->p_status }}
                                    </span>
                                </td>
                                <td>
                                    @if ($booking->p_status === 'PENDING' || $booking->p_status === 'RUNNING')
                                        <button type="button" class="btn btn-danger btn-sm btn-cancel"
                                            data-bs-toggle="modal" data-bs-target="#modalCancel{{ $booking->p_id }}">
                                            <i class="fas fa-times mr-1"></i> Cancel
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9">
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
        </div>
    </div>

    @foreach ($peminjaman as $booking)
        <!-- MODAL Cancel-->
        <div class="modal fade" id="modalCancel{{ $booking->p_id }}" data-bs-backdrop="static" data-bs-keyboard="false"
            tabindex="-1" aria-labelledby="modalCancel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="fas fa-exclamation-triangle text-warning mr-2"></i>
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

    @include('sweetalert2::index')
    @include('components.footer')
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
