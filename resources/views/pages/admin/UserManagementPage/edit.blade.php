@extends("layouts.admin")
@section("title", "Edit Pengguna")
@section("page-heading", "Edit Pengguna")
@section("content")
    <form
        class="form-edit"
        method="POST"
        action="{{ route("user.update", $user->u_id) }}"
        enctype="multipart/form-data"
    >
        @csrf
        @method("PUT")
        @if ($user->u_foto_profile)
            <img
                src="{{ asset("uploads/users/" . $user->u_foto_profile) }}"
                alt="Foto Profile"
                class="profile-edit mb-3 mx-auto d-block rounded-circle shadow"
            />
        @endif

        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input
                type="text"
                class="form-control"
                id="username"
                name="username"
                value="{{ old("username", $user->u_username) }}"
            />
            @error("username")
                <p class="text-danger fst-italic">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-3">
            <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
            <input
                type="text"
                class="form-control"
                id="nama_lengkap"
                name="nama_lengkap"
                value="{{ old("nama_lengkap", $user->u_nama_lengkap) }}"
            />
            @error("nama_lengkap")
                <p class="text-danger fst-italic">{{ $message }}</p>
            @enderror
        </div>

        <div class="row">
            <div class="mb-3 col-lg-6 col-md-6 col-sm-12">
                <label for="password" class="form-label">Password</label>
                <input
                    type="password"
                    class="form-control"
                    id="password"
                    name="password"
                    placeholder="Kosongkan jika tidak ingin diubah"
                />
                @error("password")
                    <p class="text-danger fst-italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-3 col-lg-6 col-md-6 col-sm-12">
                <label for="konfirmasi_password" class="form-label">
                    Konfirmasi Password
                </label>
                <input
                    type="password"
                    class="form-control"
                    id="konfirmasi_password"
                    name="konfirmasi_password"
                    placeholder="Kosongkan jika tidak ingin diubah"
                />
                @error("konfirmasi_password")
                    <p class="text-danger fst-italic">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="mb-3">
            <label for="foto_profile" class="form-label">Foto Profile</label>
            <input
                class="form-control"
                type="file"
                id="foto_profile"
                name="foto_profile"
            />
            @error("foto_profile")
                <p class="text-danger fst-italic">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Ubah</button>
    </form>
@endsection
