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
    <div class="table-responsive table-riwayat">
        <table class="table table-striped text-nowrap">
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
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($peminjaman as $booking)
                    <tr>
                        <td scope="row">{{ $loop->iteration }}</td>
                        <td>
                            {{ $booking->lapangan->l_label }}
                        </td>
                        <td>Rp{{ number_format($booking->p_total_harga, 0, ',', '.') }}</td>
                        <td>
                            {{ Carbon\Carbon::parse($booking->p_tanggal)->locale('id')->translatedFormat('l d F Y') }}
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
                            @else text-bg-danger @endif">{{ $booking->p_status }}</span>
                        </td>
                        <td><button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                data-bs-target="#modalCancel{{ $booking->p_id }}">
                                Cancel
                            </button></td>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">
                            Belum ada data pemesanan
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @foreach ($peminjaman as $booking)
        <!-- MODAL Cancel-->
        <div class="modal fade" id="modalCancel{{ $booking->p_id }}" data-bs-backdrop="static" data-bs-keyboard="false"
            tabindex="-1" aria-labelledby="modalCancel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Konfirmasi Pembatalan</h5>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('cancel.booking', $booking->p_id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="alasanCancel" class="form-label">Alasan Cancel</label>
                                <textarea class="form-control" id="alasanCancel" rows="3" required></textarea>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                    Close
                                </button>
                                <button type="submit" class="btn btn-danger">
                                    Konfirmasi
                                </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    @include('sweetalert2::index')

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


    @stack('scripts')
</body>

</html>
