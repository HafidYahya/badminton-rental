@extends('layouts.admin')

@section('page-heading', 'Kelola Pemesanan')

@section('title', 'Kelola Pemesanan')
@section('content')
    <form method="GET" class="booking-filter-form">
        <div class="booking-filter-field">
            <label for="status" class="form-label">
                <i class="fas fa-filter" aria-hidden="true"></i>
                Status Pesanan
            </label>
            <select name="p_status" class="form-control" id="status">
                    <option value="">-- Semua Status --</option>
                    <option value="PENDING" {{ request('p_status') == 'PENDING' ? 'selected' : '' }}>
                        PENDING
                    </option>
                    <option value="DIBAYAR" {{ request('p_status') == 'DIBAYAR' ? 'selected' : '' }}>
                        DIBAYAR
                    </option>
                    <option value="RUNNING" {{ request('p_status') == 'RUNNING' ? 'selected' : '' }}>
                        RUNNING
                    </option>
                    <option value="FINISH" {{ request('p_status') == 'FINISH' ? 'selected' : '' }}>
                        FINISH
                    </option>
                    <option value="CANCEL" {{ request('p_status') == 'CANCEL' ? 'selected' : '' }}>
                        CANCEL
                    </option>
                    <option value="EXPIRED" {{ request('p_status') == 'EXPIRED' ? 'selected' : '' }}>
                        EXPIRED
                    </option>
                </select>
        </div>
        <button type="submit" class="btn btn-primary booking-filter-submit">
            <i class="fas fa-filter" aria-hidden="true"></i>
            Filter
        </button>
    </form>
    <div class="table-responsive">
        <table class="table table-striped text-nowrap align-middle">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Nama Customer</th>
                    <th scope="col">No. Hp</th>
                    <th scope="col">Lapangan</th>
                    <th scope="col">Harga</th>
                    <th scope="col">Total Harga</th>
                    <th scope="col">Tanggal</th>
                    <th scope="col">Jam Mulai</th>
                    <th scope="col">Jam Selesai</th>
                    <th scope="col">Total Jam</th>
                    <th scope="col">Status</th>
                    <th scope="col">Alasan Cancel</th>
                    <th scope="col">Proses</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($peminjaman as $booking)
                    <tr>
                        <td scope="row">{{ $peminjaman->firstItem() + $loop->index }}</td>
                        <td class="font-weight-bold">{{ $booking->customer->c_nama_lengkap }}</td>
                        <td>{{ $booking->customer->c_no_hp }}</td>
                        <td>
                            {{ $booking->lapangan->l_label }}
                        </td>
                        <td>Rp{{ number_format($booking->p_harga_per_jam, 0, ',', '.') }}</td>
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
                            @elseif ($booking->p_status === 'DIBAYAR') text-bg-success
                            @elseif ($booking->p_status === 'RUNNING') text-bg-warning
                            @elseif ($booking->p_status === 'FINISH') text-bg-success
                            @elseif ($booking->p_status === 'EXPIRED') text-bg-danger
                            @else text-bg-danger @endif">{{ $booking->p_status }}</span>
                        </td>
                        <td>{{ $booking->p_alasan_cancel ?? '-' }}</td>
                        <td>
                            @if (in_array($booking->p_status, ['DIBAYAR', 'RUNNING']))
                                <button type="button" class="btn btn-white btn-sm btn-aksi" data-bs-toggle="modal"
                                    data-bs-target="#modalProses{{ $booking->p_id }}"
                                    aria-label="Proses pesanan {{ $booking->p_id }}" title="Proses pesanan">
                                    <i class="fa fa-fw fa-arrows-rotate"></i>
                                </button>
                            @else
                                <button type="button" class="btn btn-white btn-sm btn-aksi" disabled
                                    aria-label="Pesanan tidak dapat diproses" title="Tidak dapat diproses pada status ini">
                                    <i class="fa fa-fw fa-arrows-rotate"></i>
                                </button>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="13" class="text-center">
                            Belum ada data pemesanan
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center mt-3 gap-2">
        <p class="text-muted mb-0">
            Menampilkan {{ $peminjaman->firstItem() ?? 0 }} - {{ $peminjaman->lastItem() ?? 0 }}
            dari {{ $peminjaman->total() }} data
        </p>
        <div>{{ $peminjaman->links() }}</div>
    </div>
    @foreach ($peminjaman as $booking)
        <!-- MODAL BUKTI PEMBAYARAN-->
        <div class="modal fade" id="modalBuktiPembayaran{{ $booking->p_id }}" data-bs-backdrop="static"
            data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalBuktiTitle{{ $booking->p_id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="modalBuktiTitle{{ $booking->p_id }}">
                            BUKTI PEMBAYARAN
                        </h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="text-center mb-3">
                            <img src="{{ asset('uploads/bukti-pembayaran/' . $booking->p_bukti_pembayaran) }}"
                                alt="Foto Bukti Pembayaran" class="modal-bukti-pembayaran rounded-10 shadow" />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- MODAL PROSES-->

        <div class="modal fade" id="modalProses{{ $booking->p_id }}" data-bs-backdrop="static" data-bs-keyboard="false"
            tabindex="-1" aria-labelledby="modalProsesTitle{{ $booking->p_id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalProsesTitle{{ $booking->p_id }}">Proses Pesanan</h5>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('proses.booking', $booking->p_id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="d-flex gap-3">
                                @if ($booking->p_status === 'DIBAYAR')
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="status"
                                            id="running{{ $booking->p_id }}" value="RUNNING" checked>
                                        <label class="form-check-label" for="running{{ $booking->p_id }}">
                                            RUNNING
                                        </label>
                                    </div>
                                @elseif ($booking->p_status === 'RUNNING')
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="status"
                                            id="finish{{ $booking->p_id }}" value="FINISH" checked>
                                        <label class="form-check-label" for="finish{{ $booking->p_id }}">
                                            FINISH
                                        </label>
                                    </div>
                                @endif
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                    Close
                                </button>
                                <button type="submit" class="btn btn-warning">
                                    Proses
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    @include('sweetalert2::index')
@endsection
