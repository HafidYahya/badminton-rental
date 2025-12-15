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


<body>
    {{-- CONTENT --}}
    @include('components.navbar-customer-after-login')
    <div class="main-section-peminjaman">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                    <div class="card booking-card shadow-lg">
                        <div class="card-body">
                            <img class="img-fluid rounded shadow-sm"
                                src="{{ asset('uploads/lapangan/' . $lapangan->l_foto) }}" alt="Foto Lapangan">
                        </div>
                    </div>

                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                    <h2 class="booking-lapangan-title">{{ $lapangan->l_label }}</h2>
                    <h5 class="mb-3">
                        Harga/Jam :
                        <span class="booking-lapangan-price">Rp
                            {{ number_format($lapangan->l_harga, 0, ',', '.') }}</span>
                    </h5>
                    <div class="card booking-card shadow-lg">
                        <div class="card-header booking-card-header">
                            <h5 class="mb-0"><i class="fas fa-align-left mr-2"></i>Deskripsi</h5>
                        </div>
                        <div class="card-body">{!! $lapangan->l_deskripsi !!}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- BOOKING FORM SECTION --}}
    <div class="booking-form-section">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card booking-card shadow-lg">
                        <div class="card-header booking-card-header">
                            <h5 class="mb-0"><i class="fas fa-calendar-check mr-2"></i>Form Pemesanan</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('booking.store') }}" method="POST" id="bookingForm"
                                enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="customer_id"
                                    value="{{ Auth::guard('customer')->user()->c_id }}">
                                <input type="hidden" name="lapangan_id" value="{{ $lapangan->l_id }}">
                                <input type="hidden" name="harga_per_jam" value="{{ $lapangan->l_harga }}">


                                {{-- Pilih Tanggal --}}
                                <div class="form-group">
                                    <label for="tanggal_booking"><strong class="booking-label-strong">Pilih
                                            Tanggal</strong></label>
                                    <input type="date" class="form-control booking-form-control-date"
                                        id="tanggal_booking" name="tanggal_booking" min="{{ date('Y-m-d') }}" required>
                                </div>

                                {{-- Pilih Jam --}}
                                <div class="form-group">
                                    <label><strong class="booking-label-strong">Pilih Jam</strong></label>
                                    <small class="text-muted d-block mb-3">Klik pada jam yang ingin Anda booking (dapat
                                        memilih lebih dari satu)</small>

                                    <div class="row booking-jam-container" id="jamContainer">
                                        @for ($i = 0; $i < 24; $i++)
                                            @php
                                                $jamMulai = str_pad($i, 2, '0', STR_PAD_LEFT) . ':00';
                                                $jamSelesai = str_pad($i + 1, 2, '0', STR_PAD_LEFT) . ':00';
                                            @endphp
                                            <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                                                <div class="booking-jam-item disabled rounded p-3 text-center"
                                                    data-jam="{{ $jamMulai }}"
                                                    data-jam-selesai="{{ $jamSelesai }}">
                                                    <i class="far fa-clock mr-1"></i>
                                                    {{ $jamMulai }} - {{ $jamSelesai }}
                                                </div>
                                            </div>
                                        @endfor
                                    </div>

                                    {{-- Hidden inputs untuk menyimpan jam yang dipilih --}}
                                    <input type="hidden" name="jam_booking[]" id="jamBookingInput">
                                </div>

                                {{-- Ringkasan Booking --}}
                                <div class="form-group d-none   ">
                                    <div class="alert booking-alert-info" id="ringkasanBooking" style="display: none;">
                                        <h6><i class="fas fa-info-circle booking-info-icon mr-2"></i>Ringkasan Pemesanan
                                        </h6>
                                        <p class="mb-1"><i class="far fa-calendar booking-info-icon mr-2"></i>Tanggal:
                                            <span id="ringkasanTanggal">-</span>
                                        </p>
                                        <p class="mb-1"><i class="far fa-clock booking-info-icon mr-2"></i>Jam: <span
                                                id="ringkasanJam">-</span></p>
                                        <p class="mb-1"><i
                                                class="fas fa-hourglass-half booking-info-icon mr-2"></i>Total Durasi:
                                            <span id="ringkasanDurasi">0</span> Jam
                                        </p>
                                        <p class="mb-0"><i
                                                class="fas fa-money-bill-wave booking-info-icon mr-2"></i>Total Harga:
                                            <strong>Rp <span id="ringkasanHarga">0</span></strong>
                                        </p>
                                    </div>
                                </div>

                                {{-- Upload Bukti Pembayaran --}}
                                <div class="form-group">
                                    <label for="bukti_pembayaran"><strong class="booking-label-strong">Kirim Bukti
                                            Pembayaran</strong></label>
                                    <input type="file" class="form-control booking-form-control-date"
                                        id="bukti_pembayaran" name="bukti_pembayaran" required>
                                    @error('bukti_pembayaran')
                                        <div class="invalid-feedback d-flex align-items-center">
                                            <i class="fas fa-exclamation-circle me-2"></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                {{-- Button Submit --}}
                                <div class="form-group mb-0">
                                    <button type="submit" class="btn booking-btn-primary btn-block btn-lg disabled"
                                        id="btnSubmit">
                                        <i class="fas fa-check mr-2"></i>Konfirmasi Pemesanan
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('sweetalert2::index')
    @include('components.footer')
    {{-- END CONTENT --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('templates/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('templates/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('templates/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('templates/js/sb-admin-2.min.js') }}"></script>
    {{-- TYNYMCE --}}
    <script src="{{ asset('tinymce/js/tinymce/tinymce.min.js') }}"></script>
    {{-- SWEET alert --}}
    @if ($errors->has('bukti_pembayaran'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Upload Gagal',
                    text: '{{ $errors->first('bukti_pembayaran') }}',
                    confirmButtonText: 'OK'
                });
            });
        </script>
    @endif


    {{-- CUSTOME JS --}}
    <script>
        const hargaPerJam = {{ $lapangan->l_harga }}; // Ambil harga dari database

        let selectedJam = [];

        // Format tanggal ke: 12 Dec 2025
        function formatTanggal(tgl) {
            const dateObj = new Date(tgl);
            return dateObj.toLocaleDateString("id-ID", {
                day: "2-digit",
                month: "short",
                year: "numeric"
            });
        }

        // Enable jam setelah tanggal dipilih
        $('#tanggal_booking').on('change', function() {
            const tanggal = $(this).val();
            const lapanganId = {{ $lapangan->l_id }};

            // Reset state
            selectedJam = [];
            $('input[name="jam_booking[]"]').remove();

            $('.booking-jam-item')
                .removeClass('disabled selected booked')
                .css('pointer-events', 'auto');

            $('#ringkasanBooking').hide();

            // Format tanggal ringkasan
            $('#ringkasanTanggal').text(formatTanggal(tanggal));

            // Enable tombol submit
            $('#btnSubmit').removeClass('disabled');

            // 🔥 AJAX cek database
            $.ajax({
                url: "{{ route('booking.check-jam') }}",
                method: "GET",
                data: {
                    tanggal: tanggal,
                    lapangan_id: lapanganId
                },
                success: function(res) {

                    // 1 Reset semua jam
                    $('.booking-jam-item')
                        .addClass('disabled')
                        .removeClass('selected booked')
                        .css('pointer-events', 'none');

                    // Reset pilihan
                    selectedJam = [];
                    $('input[name="jam_booking[]"]').remove();

                    // 2 Jika hari libur
                    if (res.libur) {
                        Swal.fire({
                            icon: 'info',
                            title: 'Libur',
                            text: 'Lapangan tidak beroperasi di tanggal ini'
                        });
                        return;
                    }

                    const jamBuka = res.jam_buka; // contoh: "08:00"
                    const jamTutup = res.jam_tutup; // contoh: "22:00"
                    const jamTerbooking = res.jam_terbooking;

                    // 3 Enable jam sesuai jam operasional
                    $('.booking-jam-item').each(function() {
                        const jam = $(this).data('jam');

                        if (jam >= jamBuka && jam < jamTutup) {
                            $(this)
                                .removeClass('disabled')
                                .css('pointer-events', 'auto');
                        }

                        // 4 Disable jika sudah dibooking
                        if (jamTerbooking.includes(jam)) {
                            $(this)
                                .addClass('disabled booked')
                                .css('pointer-events', 'none');
                        }
                    });
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Gagal memuat jam booking'
                    });
                }
            });
        });


        // Klik jam booking
        $('.booking-jam-item').on('click', function() {
            if ($(this).hasClass('disabled')) return;

            const jam = $(this).data('jam');
            $(this).toggleClass('selected');

            if (selectedJam.includes(jam)) {
                selectedJam = selectedJam.filter(j => j !== jam);
            } else {
                selectedJam.push(jam);
            }

            updateHiddenInputs();
            updateRingkasan();
        });

        // Generate hidden input jam
        function updateHiddenInputs() {
            $('input[name="jam_booking[]"]').remove();

            selectedJam.forEach(j => {
                $('#bookingForm').append(
                    $('<input>', {
                        type: 'hidden',
                        name: 'jam_booking[]',
                        value: j
                    })
                );
            });
        }

        // Update ringkasan di halaman
        function updateRingkasan() {
            const tanggal = $('#tanggal_booking').val();

            if (!tanggal || selectedJam.length === 0) {
                $('#ringkasanBooking').hide();
                return;
            }

            selectedJam.sort();

            const jamText = selectedJam.map(jam => {
                const nextHour = String(parseInt(jam.split(':')[0]) + 1).padStart(2, '0') + ':00';
                return `${jam} - ${nextHour}`;
            }).join(', ');

            const durasi = selectedJam.length;
            const totalHarga = durasi * hargaPerJam;

            $('#ringkasanJam').text(jamText);
            $('#ringkasanDurasi').text(durasi);
            $('#ringkasanHarga').text(totalHarga.toLocaleString('id-ID'));
            $('#ringkasanBooking').show();
        }

        // Submit form → SweetAlert konfirmasi
        $('#bookingForm').on('submit', function(e) {
            e.preventDefault();

            if (selectedJam.length === 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Tidak Ada Jam',
                    text: 'Pilih minimal 1 jam untuk booking.',
                    confirmButtonText: 'OK'
                });
                return false; // Stop submit
            }
            const tanggal = $('#ringkasanTanggal').text();
            const jam = $('#ringkasanJam').text();
            const durasi = $('#ringkasanDurasi').text();
            const harga = $('#ringkasanHarga').text();

            Swal.fire({
                title: "Konfirmasi Pemesanan",
                html: `
                <div style="text-align:left;">
                    <p><i class="far fa-calendar mr-2"></i><strong>Tanggal:</strong> ${tanggal}</p>
                    <p><i class="far fa-clock mr-2"></i><strong>Jam:</strong> ${jam}</p>
                    <p><i class="fas fa-hourglass-half mr-2"></i><strong>Durasi:</strong> ${durasi} Jam</p>
                    <p><i class="fas fa-money-bill-wave mr-2"></i><strong>Total Harga:</strong> Rp ${harga}</p>
                </div>
            `,
                icon: "info",
                showCancelButton: true,
                confirmButtonText: "Ya, pesan sekarang!",
                cancelButtonText: "Batal"
            }).then((result) => {
                if (result.isConfirmed) {
                    e.target.submit();
                }
            });
        });
    </script>

    @stack('scripts')
</body>

</html>
