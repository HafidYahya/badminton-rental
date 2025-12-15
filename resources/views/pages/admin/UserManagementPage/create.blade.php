@extends('layouts.admin')
@section('title', 'Tambah Pengguna')
@section('page-heading', 'Tambah Pengguna')
@section('content')
    <form method="POST" action="{{ route('user.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" name="username" />
            @error('username')
                <p class="text-danger fst-italic">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-3">
            <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
            <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" />
            @error('nama_lengkap')
                <p class="text-danger fst-italic">{{ $message }}</p>
            @enderror
        </div>
        <div class="row">
            <div class="mb-3 col-lg-6 col-md-6 col-sm-12">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" />
                @error('password')
                    <p class="text-danger fst-italic">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-3 col-lg-6 col-md-6 col-sm-12">
                <label for="konfirmasi_password" class="form-label">
                    Konfirmasi Password
                </label>
                <input type="password" class="form-control" id="konfirmasi_password" name="konfirmasi_password" />
                @error('konfirmasi_password')
                    <p class="text-danger fst-italic">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="mb-3">
            <label for="foto_profile" class="form-label">Foto Profile</label>
            <input class="form-control" type="file" id="foto_profile" name="foto_profile" />
            @error('foto_profile')
                <p class="text-danger fst-italic">{{ $message }}</p>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection
