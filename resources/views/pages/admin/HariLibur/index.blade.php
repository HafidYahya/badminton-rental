@extends('layouts.admin')

@section('title', 'Hari Libur')

@section('page-heading', 'Jadwal Libur')

@section('content')

    @php
        $editHariLibur = $editHariLibur ?? null;
    @endphp

    <div class="container d-flex flex-column gap-3">
        <form action="{{ $editHariLibur ? route('hari.libur.update', $editHariLibur->hl_id) : route('hari.libur.store') }}"
            method="post" class="d-flex flex-column" id="form-hari-libur">
            @csrf

            @if ($editHariLibur)
                @method('PUT')
            @endif

            <div class="mb-3 d-flex flex-column flex-sm-row gap-3 ">
                <button type="submit" class="btn btn-primary btn-md btn-add">
                    {{ $editHariLibur ? 'Simpan Perubahan' : 'Tambahkan Hari Libur' }}
                </button>
                @if ($editHariLibur)
                    <a href="{{ route('hari.libur.index') }}" class="btn btn-secondary btn-md ">
                        Batal
                    </a>
                @endif
            </div>


            <div class="card shadow">
                <div class="card-body">
                    <div class="mb-3">
                        <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                        <input type="date" name="tanggal_mulai" class="form-control" id="tanggal_mulai"
                            placeholder="Tanggal Mulai"
                            value="{{ old('tanggal_mulai', $editHariLibur?->hl_tanggal_mulai?->format('Y-m-d')) }}"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
                        <input type="date" name="tanggal_selesai" class="form-control" id="tanggal_selesai"
                            placeholder="Tanggal Selesai"
                            value="{{ old('tanggal_selesai', $editHariLibur?->hl_tanggal_selesai?->format('Y-m-d')) }}"
                            required>
                    </div>

                    <div class="mb-3">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <textarea class="form-control" name="keterangan" id="keterangan" rows="3" required> {{ old('keterangan', $editHariLibur?->keterangan) }}</textarea>
                    </div>
                </div>
            </div>
        </form>

        <div class="card p-3">
            <h4 class="text-primary">Hari Libur Sedang Aktif</h4>

            @foreach ($hari_libur as $hl)
                <div class="card-body d-flex flex-row">
                    <div class="informasi-hari-libur">
                        <h5 class="card-title">{{ $hl->hl_tanggal_mulai->locale('id')->translatedFormat('d M Y') }} -
                            {{ $hl->hl_tanggal_selesai->locale('id')->translatedFormat('d M Y') }}</h5>
                        <p class="card-text">{{ $hl->keterangan ?? 'Tidak ada keterangan' }}</p>
                        <span class="badge text-bg-success">Sedang Aktif</span>

                    </div>
                    <div class="action-hari-libur ms-auto d-flex justify-content-center">
                        <a href="{{ route('hari.libur.index', ['edit' => $hl->hl_id]) }}" class="btn btn-lg"><i
                                class="fas fa-edit text-primary"></i></a>
                        <form action="{{ route('hari.libur.resolve', $hl->hl_id) }}" method="post">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-lg"><i
                                    class="fas fa-check-circle text-success"></i></button>
                        </form>
                    </div>
                </div>
            @endforeach

        </div>
        <div class="card p-3">
            <h4 class="text-primary">Riwayat Hari Libur</h4>

            @foreach ($riwayat_hari_libur as $riwayat_hl)
                <div class="card-body d-flex flex-row">
                    <div class="informasi-riwayat-hari-libur">
                        <h5 class="card-title">
                            {{ $riwayat_hl->hl_tanggal_mulai->locale('id')->translatedFormat('l d M Y') }}
                            -
                            {{ $riwayat_hl->hl_tanggal_selesai->locale('id')->translatedFormat('l d M Y') }}</h5>
                        <p class="card-text">{{ $riwayat_hl->keterangan ?? 'Tidak ada keterangan' }}</p>
                        <span class="badge text-bg-danger">Tidak Aktif</span>
                    </div>
                    <div class="action-hari-libur ms-auto d-flex justify-content-center">
                        <form action="{{ route('hari.libur.restore', $riwayat_hl->hl_id) }}" method="post">
                            @csrf
                            @method('PUT')

                            <button type="submit"
                                class="btn btn-lg {{ $riwayat_hl->hl_tanggal_selesai->isBefore(today()) ? 'd-none' : '' }}"><i
                                    class="fas fa-rotate text-primary"></i></button>
                        </form>

                        <form action="{{ route('hari.libur.destroy', $riwayat_hl->hl_id) }}" method="post"
                            id="form-delete">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-lg"><i class="fas fa-trash text-danger"></i></button>
                        </form>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
    @include('sweetalert2::index')
@endsection
{{-- END CONTENT --}}
@push('scripts')
    <script>
        // Ambil tanggal hari ini berdasarkan zona waktu lokal pengguna
        const hariIni = new Date();

        // Format ke YYYY-MM-DD
        const yyyy = hariIni.getFullYear();
        const mm = String(hariIni.getMonth() + 1).padStart(2, '0'); // Bulan dimulai dari 0
        const dd = String(hariIni.getDate()).padStart(2, '0');

        const tanggalFormat = `${yyyy}-${mm}-${dd}`;

        // Pasang ke atribut min pada input date
        const inputTanggal = document.querySelectorAll('#tanggal_mulai, #tanggal_selesai');
        inputTanggal.forEach(input => {
            input.min = tanggalFormat;
        })

        // Validasi tanggal selesai tidak boleh kurang <= tanggal mulai

        const inputTanggalMulai = document.getElementById('tanggal_mulai');
        const inputTanggalSelesai = document.getElementById('tanggal_selesai');
        const formHariLibur = document.getElementById('form-hari-libur');

        inputTanggalSelesai.addEventListener('input', (e) => {
            tanggalMulai = inputTanggalMulai.value;
            tanggalSelesai = inputTanggalSelesai.value;
            if (tanggalSelesai < tanggalMulai) {
                Swal.fire({
                    title: "Error",
                    text: "Tanggal selesai minimal harus lebih 1 hari dari tanggal mulai",
                    icon: "error",
                    draggable: true
                });
                inputTanggalSelesai.value = "";
            }
        });
        formHariLibur.addEventListener('submit', (e) => {
            e.preventDefault();
            tanggalMulai = inputTanggalMulai.value;
            tanggalSelesai = inputTanggalSelesai.value;
            if (tanggalSelesai < tanggalMulai) {
                Swal.fire({
                    title: "Error",
                    text: "Tanggal selesai minimal harus lebih 1 hari dari tanggal mulai",
                    icon: "error",
                    draggable: true
                });
                inputTanggalSelesai.value = "";
            } else {
                formHariLibur.submit();
            }
        });

        // Alert Delete
        const formDelete = document.getElementById('form-delete');
        formDelete.addEventListener('click', (e) => {
            e.preventDefault();
            Swal.fire({
                title: "Anda yakin ingin menghapus data ini?",
                text: 'Data akan dihapus permanen dan tidak bisa dikembalikan!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: "Hapus",
                confirmButtonColor: '#f00',
                denyButtonText: `Batal`
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    formDelete.submit();
                };
            });
        })
    </script>
@endpush
