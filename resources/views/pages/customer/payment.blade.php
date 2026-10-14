<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />

    <title>PEMBAYARAN - WISMA HARAPAN</title>
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
            font-weight: 700;
            color: #ffb22c;
            margin-bottom: 0.5rem;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);
        }

        .page-header p {
            color: #666666;
            margin: 0;
        }

        .payment-panel {
            background: #fff;
            border-radius: 18px;
            border: 2px solid #ffb22c;
            padding: 1.75rem;
            box-shadow: 0 18px 45px rgba(255, 178, 44, 0.12);
            margin-bottom: 2rem;
        }

        .payment-panel .panel-header {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .payment-panel .panel-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1a1a1a;
            margin: 0;
        }

        .payment-panel .panel-subtitle {
            color: #6c757d;
            margin: 0;
        }

        .payment-panel .countdown-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1rem;
            border-radius: 999px;
            background: #1a1a1a;
            color: #ffb22c;
            font-weight: 700;
            font-size: 0.95rem;
        }

        .payment-panel .payment-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.25rem;
        }

        .payment-panel .qrcode-card,
        .payment-panel .payment-details-card {
            background: #f8f9fa;
            border-radius: 14px;
            padding: 1.5rem;
            border: 1px solid #e9ecef;
        }

        .payment-panel .qrcode-card {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 1rem;
            text-align: center;
        }

        .payment-panel .qrcode-card #qrcode {
            width: 100%;
            max-width: 320px;
        }

        .payment-panel .payment-details-card {
            display: grid;
            gap: 1rem;
        }

        .payment-panel .detail-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            padding: 0.9rem 1rem;
            border-radius: 12px;
            background: #fff;
            border: 1px solid #dee2e6;
        }

        .payment-panel .detail-row strong {
            color: #1a1a1a;
        }

        .payment-panel .payment-label {
            color: #6c757d;
            font-size: 0.95rem;
            white-space: nowrap;
        }

        .payment-panel .payment-value {
            font-size: 1rem;
            font-weight: 700;
            color: #1a1a1a;
            text-align: right;
            word-break: break-all;
        }

        .payment-panel .payment-code {
            margin: 0;
            color: #343a40;
            word-break: break-all;
            font-size: 0.95rem;
        }

        @media (max-width: 768px) {
            .payment-panel .payment-grid {
                grid-template-columns: 1fr;
            }
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

    <div class="booking-container">
        <div class="page-header">
            <h2><i class="fas fa-credit-card mr-2"></i>Pembayaran QRIS</h2>
            <p>Scan QR code berikut dan selesaikan pembayaran sebelum kadaluarsa.</p>
        </div>

        @if (!empty($paymentInfo))
            <div class="alert alert-info" role="alert">
                <i class="fas fa-info-circle mr-2"></i> {{ $paymentInfo }}
            </div>
        @endif

        @if (!empty($paymentError))
            <div class="alert alert-danger" role="alert">
                <strong>Terjadi kesalahan:</strong> {{ $paymentError }}
            </div>
        @endif

        <div class="payment-panel">
            @if (
                !empty($paymentData['payment']) &&
                    !empty($paymentData['payment']['payment_number']) &&
                    !empty($paymentData['payment']['expired_at']))
                <div class="panel-header">
                    <div>
                        <h3 class="panel-title">Bayar melalui QRIS</h3>
                        <p class="panel-subtitle">Order ID: <strong>#{{ $paymentData['payment']['order_id'] }}</strong>
                        </p>
                    </div>
                    <div class="countdown-badge" id="paymentCountdown">
                        Memuat waktu...
                    </div>
                </div>

                <div class="payment-grid">
                    <div class="qrcode-card">
                        <div id="qrcode"></div>
                    </div>
                    <div class="payment-details-card">
                        <div class="detail-row">
                            <span class="payment-label">Metode Pembayaran</span>
                            <strong
                                class="payment-value">{{ strtoupper($paymentData['payment']['payment_method']) }}</strong>
                        </div>
                        <div class="detail-row">
                            <span class="payment-label">Jumlah</span>
                            <strong
                                class="payment-value">Rp{{ number_format($paymentData['payment']['amount'], 0, ',', '.') }}</strong>
                        </div>
                        <div class="detail-row">
                            <span class="payment-label">Fee</span>
                            <strong
                                class="payment-value">Rp{{ number_format($paymentData['payment']['fee'], 0, ',', '.') }}</strong>
                        </div>
                        <div class="detail-row">
                            <span class="payment-label">Total Pembayaran</span>
                            <strong
                                class="payment-value">Rp{{ number_format($paymentData['payment']['total_payment'], 0, ',', '.') }}</strong>
                        </div>
                    </div>
                </div>
            @else
                <div class="empty-state">
                    <i class="fas fa-exclamation-circle"></i>
                    <p>Data pembayaran tidak ditemukan atau gagal memproses transaksi. Silakan kembali dan coba lagi.
                    </p>
                </div>
            @endif
        </div>
    </div>

    <a href="https://wa.me/6287882000678?text=Halo%20Admin,%20saya%20ingin%20bertanya" class="wa-float" target="_blank"
        title="Chat Admin Wisma Harapan">
        <i class="fab fa-whatsapp"></i>
    </a>
    <footer class="sticky-footer mt-5"
        style="background: linear-gradient(135deg, #1a1a1a 0%, #2c2c2c 100%); border-top: 3px solid #ffb22c;">
        <div class="container my-auto py-4">
            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                    <h5 class="fw-bold mb-2" style="color: #ffb22c;">
                        WISMA HARAPAN
                        <span style="color: #ffa500; font-style: italic;">BADMINTON</span>
                    </h5>
                    <p class="mb-0 small" style="color: #cccccc;">
                        Tempat terbaik untuk bermain badminton
                    </p>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <div class="copyright" style="color: #ffb22c;">
                        <span class="small">Copyright &copy; Muhdiatul Zannah 2025</span>
                    </div>
                    <div class="mt-2">
                        <span class="small" style="color: #cccccc;">Jl. Wisma Lantana IV No.D07-No 49, RT.006/RW.011,
                            Gembor, Kec. Periuk, Kota Tangerang, Banten 15133</span>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const payment = @json($paymentData['payment'] ?? null);
            if (!payment || !payment.payment_number || !payment.expired_at) {
                const countdownEl = document.getElementById('paymentCountdown');
                if (countdownEl) {
                    countdownEl.textContent = 'Menunggu data pembayaran...';
                }
                return;
            }

            const qrcodeElement = document.getElementById('qrcode');
            if (qrcodeElement) {
                new QRCode(qrcodeElement, {
                    text: payment.payment_number,
                    width: 280,
                    height: 280,
                    colorDark: '#2c2c2c',
                    colorLight: '#ffffff',
                    correctLevel: QRCode.CorrectLevel.H
                });
            }

            const countdownEl = document.getElementById('paymentCountdown');
            const expiryTime = Number(payment.expired_at_timestamp) || Date.parse(payment.expired_at);
            if (!countdownEl) {
                return;
            }
            if (typeof expiryTime !== 'number' || isNaN(expiryTime) || expiryTime <= 0) {
                countdownEl.textContent = 'Waktu tidak valid';
                return;
            }

            function updateCountdown() {
                const now = new Date().getTime();
                const distance = expiryTime - now;
                if (!countdownEl) {
                    return;
                }
                if (distance <= 0) {
                    countdownEl.textContent = 'Waktu habis';
                    return;
                }

                const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);
                countdownEl.textContent = `${hours}j ${minutes}m ${seconds}d`;
            }

            updateCountdown();
            setInterval(updateCountdown, 1000);

            // Auto-polling status pembayaran setiap 5 detik
            const statusUrl = '{{ route('payment.status', ['id' => $paymentData['payment']['order_id'] ?? 0]) }}';
            const riwayatUrl = '{{ route('riwayat.booking', Auth::guard('customer')->id()) }}';

            function checkStatus() {
                fetch(statusUrl)
                    .then(res => res.json())
                    .then(data => {
                        if (data.is_paid) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Pembayaran Berhasil!',
                                text: 'Terima kasih, booking Anda sudah dikonfirmasi.',
                                timer: 2500,
                                showConfirmButton: false
                            }).then(() => {
                                window.location.href = riwayatUrl;
                            });
                        }
                    })
                    .catch(() => {});
            }

            const pollingInterval = setInterval(checkStatus, 5000);
        });
    </script>

    @stack('scripts')
</body>

</html>
