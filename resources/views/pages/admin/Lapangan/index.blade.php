@extends('layouts.admin')

@section('page-heading', 'Kelola Lapangan')

@section('title', 'Kelola Lapangan')

@section('content')
    <div class="mb-3 d-flex flex-column flex-sm-row gap-3 justify-content-between align-items-sm-end">
        <a href="{{ route('lapangan.create') }}" class="btn btn-primary btn-md btn-add">
            <i class="fa fa-fw fa-plus" aria-hidden="true"></i>
            Tambah Lapangan
        </a>

        <form method="GET" class="lapangan-filter-form">
            <div class="lapangan-filter-field">
                <label for="status" class="form-label">
                    <i class="fas fa-filter" aria-hidden="true"></i>
                    Filter Status
                </label>
                <select name="l_status" class="form-control" id="status">
                    <option value="">Semua Status</option>
                    <option value="active" {{ request('l_status') == 'active' ? 'selected' : '' }}>Aktif</option>
                    <option value="inactive" {{ request('l_status') == 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary lapangan-filter-submit">
                <i class="fas fa-filter" aria-hidden="true"></i>
                Filter
            </button>
        </form>
    </div>

    <div class="table-responsive">
        <table class="table table-striped text-nowrap">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Lapangan</th>
                    <th scope="col">Harga / Jam</th>
                    <th scope="col">Status</th>
                    <th scope="col">Ubah Status</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($lapangan as $lp)
                    <tr>
                        <td>{{ $lapangan->firstItem() + $loop->index }}</td>
                        <td class="font-weight-bold">{{ $lp->l_label }}</td>
                        <td>{{ 'Rp. ' . number_format($lp->l_harga, '0', ',', '.') }}</td>
                        <td class="font-weight-bold {{ $lp->l_status === 'active' ? 'text-success' : 'text-danger' }}">
                            {{ $lp->l_status === 'active' ? 'Aktif' : 'Tidak Aktif' }}
                        </td>
                        <td>
                            <a href="{{ route('lapangan.status', $lp->l_id) }}"
                                class="btn btn-sm {{ $lp->l_status === 'active' ? 'btn-danger' : 'btn-success' }}">
                                {{ $lp->l_status === 'active' ? 'Nonaktifkan' : 'Aktifkan' }}
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('lapangan.edit', $lp->l_id) }}" class="btn btn-white btn-sm btn-aksi"
                                aria-label="Edit {{ $lp->l_label }}" title="Edit">
                                <i class="fa fa-fw fa-edit" aria-hidden="true"></i>
                            </a>
                            <button type="button" class="btn btn-white btn-sm btn-aksi"
                                data-bs-toggle="modal" data-bs-target="#modalDelete{{ $lp->l_id }}"
                                aria-label="Hapus {{ $lp->l_label }}" title="Hapus">
                                <i class="fa fa-fw fa-trash" aria-hidden="true"></i>
                            </button>
                            <button type="button" class="btn btn-white btn-sm btn-detail"
                                data-bs-toggle="modal" data-bs-target="#modalDetail{{ $lp->l_id }}"
                                aria-label="Lihat detail {{ $lp->l_label }}">
                                LihatDetail
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">Belum ada data lapangan</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center mt-3 gap-2">
        <p class="text-muted mb-0">
            Menampilkan {{ $lapangan->firstItem() ?? 0 }} - {{ $lapangan->lastItem() ?? 0 }}
            dari {{ $lapangan->total() }} data
        </p>
        <div>{{ $lapangan->links() }}</div>
    </div>
    @foreach ($lapangan as $lp)
        <!-- MODAL DETAIL UNTUK MENAMPILKAN DETAIL Lapangan-->
        <div class="modal fade" id="modalDetail{{ $lp->l_id }}" data-bs-backdrop="static" data-bs-keyboard="false"
            tabindex="-1" aria-labelledby="modalDetailTitle{{ $lp->l_id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="modalDetailTitle{{ $lp->l_id }}">
                            DETAIL LAPANGAN
                        </h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="text-center mb-3">
                            <img src="{{ asset('uploads/lapangan/' . $lp->l_foto) }}" alt="Foto {{ $lp->l_label }}"
                                class="modal-lapangan lapangan-detail-image shadow-sm" />
                            <h5 class="mt-3 mb-3">{{ $lp->l_label }}</h5>
                            <div class="badge d-block p-2 {{ $lp->l_status === 'active' ? 'bg-success' : 'bg-danger' }}">
                                {{ $lp->l_status === 'active' ? 'AKTIF' : 'TIDAK AKTIF' }}
                            </div>
                        </div>

                        <hr />

                        <div class="row mt-3">
                            <div class="col-5 text-muted">Harga Per Jam</div>
                            <div class="col-7 fw-semibold">
                                {{ 'Rp. ' . number_format($lp->l_harga, '0', ',', '.') }}
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col-5 text-muted">Tanggal Dibuat</div>
                            <div class="col-7 fw-semibold">
                                {{ $lp->created_at->format('d M Y • H:i') }}
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col-5 text-muted">Terakhir Update</div>
                            <div class="col-7 fw-semibold">
                                {{ $lp->updated_at->format('d M Y • H:i') }}
                            </div>
                        </div>

                        <hr />
                        <h5 class="mt-3 mb-3 text-center">DESKRIPSI</h5>
                        <div class="lapangan-detail-description">
                            {!! $lp->l_deskripsi !!}
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

        <!-- MODAL HAPUS UNTUK MENAMPILKAN KONFIRMASI HAPUS-->

        <div class="modal fade" id="modalDelete{{ $lp->l_id }}" data-bs-backdrop="static" data-bs-keyboard="false"
            tabindex="-1" aria-labelledby="modalDeleteTitle{{ $lp->l_id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalDeleteTitle{{ $lp->l_id }}">Konfirmasi</h5>
                    </div>
                    <div class="modal-body">
                        <p>
                            Apakah anda yakin ingin menghapus
                            {{ $lp->l_label }}
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            Close
                        </button>
                        <form action="{{ route('lapangan.destroy', $lp->l_id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn lapangan-confirm-delete">
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    @include('sweetalert2::index')
@endsection

@push('scripts')
    <script>
        // Auto close alert dalam 3 detik
        setTimeout(() => {
            const alertBox = document.getElementById('alertBox');
            if (alertBox) {
                alertBox.style.transition = 'opacity 0.5s';
                alertBox.style.opacity = '0';

                // setelah fade out, remove dari DOM
                setTimeout(() => alertBox.remove(), 500);
            }
        }, 2000); // 3000 ms = 3 detik
    </script>
@endpush
