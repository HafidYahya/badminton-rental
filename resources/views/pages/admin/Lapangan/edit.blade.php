@extends("layouts.admin")
@section("page-heading", "Edit Lapangan")
@section("title", "Edit Lapangan")
@section("content")
    <form
        class="form-edit-lapangan"
        method="POST"
        action="{{ route("lapangan.update", $lapangan) }}"
        enctype="multipart/form-data"
    >
        @csrf
        @method("PUT")
        @if ($lapangan->l_foto)
            <img
                src="{{ asset("uploads/lapangan/" . $lapangan->l_foto) }}"
                alt="Foto Lapangan"
                class="foto-lapangan mb-5 mx-auto d-block rounded shadow"
            />
        @endif

        <hr class="mb-5" />

        <div class="row">
            <div class="mb-3 col-lg-6 col-md-6 col-sm-12">
                <label for="label" class="form-label">Label Lapangan</label>
                <input
                    type="text"
                    class="form-control"
                    id="label"
                    name="label"
                    value="{{ old("label", $lapangan->l_label) }}"
                />
                @error("label")
                    <p class="text-danger fst-italic">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-3 col-lg-6 col-md-6 col-sm-12">
                <label for="harga" class="form-label">Harga</label>
                <input
                    type="number"
                    class="form-control"
                    id="harga"
                    name="harga"
                    placeholder="Masukan harga per jam"
                    value="{{ old("harga", $lapangan->l_harga) }}"
                />
                @error("harga")
                    <p class="text-danger fst-italic">{{ $message }}</p>
                @enderror
            </div>
        </div>
        <div class="row">
            <div class="mb-3 col-lg-6 col-md-6 col-sm-12">
                <label for="foto_lapangan" class="form-label">
                    Foto Lapangan
                </label>
                <input
                    class="form-control"
                    type="file"
                    id="foto_lapangan"
                    name="foto_lapangan"
                />
                @error("foto_lapangan")
                    <p class="text-danger fst-italic">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-3 col-lg-12 col-md-6 col-sm-12">
                <label for="deskripsi" class="form-label">Deskripsi</label>
                <textarea name="deskripsi" id="deskripsi" class="form-control">
            {{ old("deskripsi", $lapangan->l_deskripsi) }}</textarea
                >
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
    </form>
@endsection
