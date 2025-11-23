@extends("layouts.admin")

@section("page-heading", "Kelola Lapangan")

@section("title", "Kelola Lapangan")

@section("content")
    {{-- ALERT --}}
    @if (session()->has("create-success") || session()->has("delete-success") || session("edit-success"))
        <div
            id="alertBox"
            class="alert alert-warning position-absolute top-80 start-50 translate-middle"
            role="alert"
        >
            {{ session("create-success") ?? (session("delete-success") ?? session("edit-success")) }}
        </div>
    @endif

    <div class="mb-3">
        <a
            href="{{ route("lapangan.create") }}"
            class="btn btn-primary btn-md"
        >
            <i class="fa fa-fw fa-plus"></i>
            Tambah Lapangan
        </a>
    </div>
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">No</th>
                <th scope="col">Label</th>
                <th scope="col">Harga</th>
                <th scope="col">Status</th>
                <th scope="col">Ubah Status</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($lapangan as $lp)
                <tr>
                    <td scope="row">{{ $loop->iteration }}</td>
                    <td>{{ $lp->l_label }}</td>
                    <td>
                        {{ "Rp. " . number_format($lp->l_harga, "0", ",", ".") }}
                    </td>
                    <td
                        class="fw-bold {{ $lp->l_status === "active" ? "text-success" : "text-danger" }}"
                    >
                        {{ Str::ucfirst($lp->l_status) }}
                    </td>
                    <td>
                        <a
                            href="{{ route("lapangan.status", $lp->l_id) }}"
                            class="btn btn-sm {{ $lp->l_status === "active" ? "btn-danger" : "btn-success" }}"
                        >
                            {{ $lp->l_status === "active" ? "Deactivate" : "Activate" }}
                        </a>
                    </td>
                    <td>
                        <button
                            type="button"
                            class="btn btn-secondary btn-sm"
                            data-bs-toggle="modal"
                            data-bs-target="#modalDetail{{ $lp->l_id }}"
                        >
                            <i class="fa fa-fw fa-eye"></i>
                        </button>
                        <a
                            href="{{ route("lapangan.edit", $lp->l_id) }}"
                            class="btn btn-success btn-sm"
                        >
                            <i class="fa fa-fw fa-edit"></i>
                            Edit
                        </a>
                        <button
                            class="btn btn-danger btn-sm"
                            data-bs-toggle="modal"
                            data-bs-target="#modalDelete{{ $lp->l_id }}"
                        >
                            <i class="fa fa-fw fa-trash"></i>
                            Hapus
                        </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">
                        Belum ada data lapangan
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
    @foreach ($lapangan as $lp)
        <!-- MODAL DETAIL UNTUK MENAMPILKAN DETAIL Lapangan-->
        <div
            class="modal fade"
            id="modalDetail{{ $lp->l_id }}"
            data-bs-backdrop="static"
            data-bs-keyboard="false"
            tabindex="-1"
            aria-labelledby="modalDetail"
            aria-hidden="true"
        >
            <div
                class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
            >
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">
                            DETAIL LAPANGAN
                        </h1>
                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Close"
                        ></button>
                    </div>
                    <div class="modal-body">
                        <div class="text-center mb-3">
                            <img
                                src="{{ asset("uploads/lapangan/" . $lp->l_foto) }}"
                                alt="Foto Lapangan"
                                class="modal-lapangan rounded-10 shadow"
                            />
                            <h5 class="mt-3 mb-3">{{ $lp->l_label }}</h5>
                            <div
                                class="badge d-block p-2 {{ $lp->l_status === "active" ? "bg-success" : "bg-danger" }}"
                            >
                                {{ Str::upper($lp->l_status) }}
                            </div>
                        </div>

                        <hr />

                        <div class="row mt-3">
                            <div class="col-5 text-muted">Harga Per Jam</div>
                            <div class="col-7 fw-semibold">
                                {{ "Rp. " . number_format($lp->l_harga, "0", ",", ".") }}
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col-5 text-muted">Tanggal Dibuat</div>
                            <div class="col-7 fw-semibold">
                                {{ $lp->created_at->format("d M Y • H:i") }}
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col-5 text-muted">Terakhir Update</div>
                            <div class="col-7 fw-semibold">
                                {{ $lp->updated_at->format("d M Y • H:i") }}
                            </div>
                        </div>

                        <hr />
                        <h5 class="mt-3 mb-3 text-center">DESKIPSI</h5>
                        <div class="row mt-2">
                            <div colspan="2">
                                {!! $lp->l_deskripsi !!}
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button
                            type="button"
                            class="btn btn-secondary"
                            data-bs-dismiss="modal"
                        >
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- MODAL HAPUS UNTUK MENAMPILKAN KONFIRMASI HAPUS-->

        <div
            class="modal fade"
            id="modalDelete{{ $lp->l_id }}"
            data-bs-backdrop="static"
            data-bs-keyboard="false"
            tabindex="-1"
            aria-labelledby="modalDelete"
            aria-hidden="true"
        >
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Konfirmasi</h5>
                    </div>
                    <div class="modal-body">
                        <p>
                            Apakah anda yakin ingin menghapus
                            {{ $lp->l_label }}
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button
                            type="button"
                            class="btn btn-secondary"
                            data-bs-dismiss="modal"
                        >
                            Close
                        </button>
                        <form
                            action="{{ route("lapangan.destroy", $lp->l_id) }}"
                            method="POST"
                        >
                            @csrf
                            @method("DELETE")
                            <button type="submit" class="btn btn-danger">
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection

@push("scripts")
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
