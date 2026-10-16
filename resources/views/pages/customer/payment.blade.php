<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />

    <title>PEMBAYARAN - BADMINTON RENTAL</title>
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

        .payment-page {
            width: min(100% - 2rem, 1120px);
            margin: 7.5rem auto 4rem;
            padding: 1.5rem 0;
        }

        .payment-page-header {
            margin-bottom: 1.5rem;
        }

        .payment-page-eyebrow,
        .payment-section-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: .45rem;
            margin: 0 0 .55rem;
            color: #92600d;
            font-size: .75rem;
            font-weight: 800;
            letter-spacing: .12em;
            text-transform: uppercase;
        }

        .payment-page-header h1 {
            margin: 0 0 .45rem;
            color: #202733;
            font-size: clamp(1.7rem, 3vw, 2.35rem);
            font-weight: 800;
            letter-spacing: -.04em;
        }

        .payment-page-header > p:last-child {
            max-width: 620px;
            margin: 0;
            color: #667085;
            font-size: 1rem;
        }

        .payment-panel {
            padding: clamp(1rem, 3vw, 2rem);
            border: 1px solid #e8ebef;
            border-radius: 24px;
            background: #fff;
            box-shadow: 0 24px 70px rgb(22 34 51 / 9%);
        }

        .payment-panel .panel-header {
            align-items: flex-start;
            padding-bottom: 1.35rem;
            border-bottom: 1px solid #edf0f3;
        }

        .payment-panel .panel-title {
            margin-bottom: .35rem;
            color: #202733;
            font-size: clamp(1.2rem, 2.5vw, 1.55rem);
            letter-spacing: -.025em;
        }

        .payment-panel .panel-subtitle {
            color: #667085;
            font-size: .9rem;
        }

        .payment-panel .panel-subtitle strong {
            color: #344054;
            font-variant-numeric: tabular-nums;
        }

        .payment-panel .countdown-badge {
            flex-shrink: 0;
            padding: .7rem .95rem;
            border: 1px solid #f4d48b;
            background: #fff8e8;
            color: #80540b;
            font-size: .85rem;
            font-variant-numeric: tabular-nums;
        }

        .payment-panel .payment-grid {
            grid-template-columns: minmax(0, 1.05fr) minmax(300px, .95fr);
            gap: 1.25rem;
            padding-top: 1.35rem;
        }

        .payment-panel .qrcode-card,
        .payment-panel .payment-details-card {
            border: 1px solid #e9edf2;
            border-radius: 18px;
            background: #f8fafc;
        }

        .payment-panel .qrcode-card {
            min-height: 100%;
            padding: clamp(1.1rem, 3vw, 1.75rem);
        }

        .payment-panel .qrcode-card h3,
        .payment-panel .details-heading {
            margin: 0;
            color: #202733;
            font-size: 1.05rem;
            font-weight: 750;
        }

        .payment-panel .qrcode-frame {
            display: grid;
            width: min(100%, 312px);
            min-height: 312px;
            place-items: center;
            padding: 1rem;
            border: 1px solid #edf0f3;
            border-radius: 18px;
            background: #fff;
            box-shadow: 0 10px 30px rgb(22 34 51 / 6%);
        }

        .payment-panel .qrcode-frame #qrcode {
            display: grid;
            width: 280px;
            max-width: 100%;
            place-items: center;
        }

        .payment-panel .qrcode-frame #qrcode img,
        .payment-panel .qrcode-frame #qrcode canvas {
            display: block;
            max-width: 100%;
            height: auto;
        }

        .payment-panel .qr-caption {
            max-width: 340px;
            margin: 0;
            color: #667085;
            font-size: .9rem;
            line-height: 1.6;
        }

        .payment-panel .sandbox-notice {
            max-width: 390px;
            margin: 0;
            padding: .7rem .85rem;
            border: 1px solid #f5d58d;
            border-radius: 12px;
            background: #fff8e8;
            color: #704b0c;
            font-size: .82rem;
            line-height: 1.5;
        }

        .payment-panel .payment-details-card {
            align-content: start;
            gap: .7rem;
            padding: 1.25rem;
        }

        .payment-panel .amount-summary {
            display: grid;
            gap: .35rem;
            margin-bottom: .25rem;
            padding: 1.1rem 1.15rem;
            border-radius: 14px;
            background: #202733;
            color: #fff;
        }

        .payment-panel .amount-summary span {
            color: #d0d5dd;
            font-size: .84rem;
        }

        .payment-panel .amount-summary strong {
            color: #ffd276;
            font-size: clamp(1.5rem, 3vw, 2rem);
            font-variant-numeric: tabular-nums;
            line-height: 1.2;
        }

        .payment-panel .detail-row {
            padding: .85rem .9rem;
            border-color: #e9edf2;
        }

        .payment-panel .payment-label {
            color: #667085;
            font-size: .85rem;
        }

        .payment-panel .payment-value {
            color: #202733;
            font-size: .92rem;
        }

        .payment-panel .payment-link-button {
            display: inline-flex;
            justify-content: center;
            align-items: center;
            gap: .5rem;
            min-height: 48px;
            margin-top: .35rem;
            border: 0;
            border-radius: 12px;
            background: #f3a712;
            color: #202733;
            font-weight: 750;
            text-decoration: none;
            transition: background-color .2s ease, transform .2s ease;
        }

        .payment-panel .payment-link-button:hover {
            transform: translateY(-1px);
            background: #e89b08;
            color: #202733;
        }

        .payment-panel .payment-link-button:focus-visible {
            outline: 3px solid rgb(243 167 18 / 38%);
            outline-offset: 3px;
        }

        @media (max-width: 760px) {
            .payment-page {
                width: min(100% - 1.25rem, 560px);
                margin-top: 6rem;
                padding-top: .75rem;
            }

            .payment-panel .payment-grid {
                grid-template-columns: minmax(0, 1fr);
            }

            .payment-panel .panel-header {
                align-items: flex-start;
            }

            .payment-panel .countdown-badge {
                padding: .6rem .75rem;
                font-size: .78rem;
            }

            .payment-panel .qrcode-frame {
                min-height: 0;
                aspect-ratio: 1;
            }
        }

        @media (max-width: 420px) {
            .payment-panel .panel-header {
                flex-direction: column;
            }

            .payment-panel .detail-row {
                align-items: flex-start;
                flex-direction: column;
                gap: .35rem;
            }

            .payment-panel .payment-value {
                text-align: left;
            }
        }
    </style>
</head>

<body>
    {{-- CONTENT --}}
    @include('components.navbar-customer-after-login')

    <main class="booking-container payment-page">
        <header class="page-header payment-page-header">
            <p class="payment-page-eyebrow"><i class="fas fa-lock" aria-hidden="true"></i>Pembayaran aman</p>
            <h1>Pembayaran QRIS</h1>
            <p>Scan QR code berikut dan selesaikan pembayaran sebelum kadaluarsa.</p>
        </header>

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

        <section class="payment-panel" aria-label="Detail pembayaran">
            @if (
                !empty($paymentData['payment']) &&
                    (!empty($paymentData['payment']['qr_string']) || !empty($paymentData['payment']['payment_link']) || !empty($paymentData['payment']['va_number']))
            )
                <div class="panel-header">
                    <div>
                        <p class="payment-section-eyebrow">Langkah terakhir</p>
                        <h2 class="panel-title">Bayar melalui {{ strtoupper($paymentData['payment']['payment_method']) }}</h2>
                        <p class="panel-subtitle">Order ID: <strong>#{{ $paymentData['payment']['order_id'] }}</strong>
                        </p>
                    </div>
                    <div class="countdown-badge" id="paymentCountdown">
                        <i class="far fa-clock" aria-hidden="true"></i>
                        <span aria-live="polite">{{ !empty($paymentData['payment']['expired_at']) ? 'Memuat waktu...' : 'Masa berlaku tidak tersedia' }}</span>
                    </div>
                </div>

                <div class="payment-grid">
                    @if (!empty($paymentData['payment']['qr_string']))
                        <div class="qrcode-card">
                            <h3>Pindai kode QRIS</h3>
                            @if (($paymentData['payment']['is_sandbox'] ?? false) && str_contains($paymentData['payment']['qr_string'], 'placeholder'))
                                <p class="sandbox-notice"><strong>Mode sandbox:</strong> QR ini simulasi untuk pengujian tampilan dan tidak dapat digunakan untuk pembayaran sungguhan.</p>
                            @endif
                            <div class="qrcode-frame"><div id="qrcode"></div></div>
                            <p class="qr-caption">Buka aplikasi pembayaran yang mendukung QRIS, lalu arahkan kamera ke kode ini.</p>
                        </div>
                    @endif
                    <div class="payment-details-card">
                        <h3 class="details-heading">Ringkasan pembayaran</h3>
                        <div class="amount-summary">
                            <span>Total yang perlu dibayar</span>
                            <strong>Rp{{ number_format($paymentData['payment']['total_payment'], 0, ',', '.') }}</strong>
                        </div>
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
                        @if (!empty($paymentData['payment']['va_number']))
                            <div class="detail-row">
                                <span class="payment-label">Nomor Virtual Account</span>
                                <strong class="payment-value">{{ $paymentData['payment']['va_number'] }}</strong>
                            </div>
                        @endif
                        @if (!empty($paymentData['payment']['payment_link']))
                            <a href="{{ $paymentData['payment']['payment_link'] }}" class="payment-link-button"
                                target="_blank" rel="noopener noreferrer">
                                <i class="fas fa-arrow-up-right-from-square" aria-hidden="true"></i>Lanjutkan Pembayaran
                            </a>
                        @endif
                    </div>
                </div>
            @else
                <div class="empty-state">
                    <i class="fas fa-exclamation-circle"></i>
                    <p>Data pembayaran belum tersedia atau transaksi gagal diproses. Coba muat ulang untuk mencoba kembali.</p>
                    <a href="{{ route('payment', ['id' => $paymentData['payment']['booking_id'] ?? request()->route('id')]) }}"
                        class="btn btn-primary mt-2">
                        <i class="fas fa-redo-alt mr-1" aria-hidden="true"></i> Coba Lagi
                    </a>
                </div>
            @endif
        </section>
    </main>

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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const payment = @json($paymentData['payment'] ?? null);
            const countdownEl = document.getElementById('paymentCountdown');
            const countdownLabel = countdownEl?.querySelector('[aria-live="polite"]') || countdownEl;
            if (!payment || (!payment.qr_string && !payment.payment_link && !payment.va_number)) {
                if (countdownLabel) {
                    countdownLabel.textContent = 'Menunggu data pembayaran...';
                }
                return;
            }

            const qrcodeElement = document.getElementById('qrcode');
            if (qrcodeElement && (payment.qr_string || payment.payment_number)) {
                new QRCode(qrcodeElement, {
                    text: payment.qr_string || payment.payment_number,
                    width: 280,
                    height: 280,
                    colorDark: '#2c2c2c',
                    colorLight: '#ffffff',
                    correctLevel: QRCode.CorrectLevel.H
                });
            }

            const expiryTime = Number(payment.expired_at_timestamp) || Date.parse(payment.expired_at);
            if (countdownLabel && Number.isFinite(expiryTime) && expiryTime > 0) {
                function updateCountdown() {
                    const distance = expiryTime - Date.now();
                    if (distance <= 0) {
                        countdownLabel.textContent = 'Waktu habis';
                        return;
                    }

                    const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    const seconds = Math.floor((distance % (1000 * 60)) / 1000);
                    countdownLabel.textContent = `${hours}j ${minutes}m ${seconds}d`;
                }

                updateCountdown();
                setInterval(updateCountdown, 1000);
            }

            // Auto-polling status pembayaran setiap 5 detik
            const statusUrl = '{{ route('payment.status', ['id' => $paymentData['payment']['booking_id'] ?? 0]) }}';
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
                        } else if (data.order_status === 'canceled') {
                            window.location.href = riwayatUrl;
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
