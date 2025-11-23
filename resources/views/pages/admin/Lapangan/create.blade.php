@extends("layouts.admin")
@section("page-heading", "Tambah Lapangan")
@section("title", "Tambah Lapangan")
@section("content")
    <form
        method="POST"
        action="{{ route("lapangan.store") }}"
        enctype="multipart/form-data"
    >
        @csrf
        <div class="row">
            <div class="mb-3 col-lg-6 col-md-6 col-sm-12">
                <label for="label" class="form-label">Label Lapangan</label>
                <input
                    type="text"
                    class="form-control"
                    id="label"
                    name="label"
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
                <textarea
                    name="deskripsi"
                    id="deskripsi"
                    class="form-control"
                    rows="6"
                ></textarea>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection
