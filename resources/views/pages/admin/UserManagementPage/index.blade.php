@extends('layouts.admin')

@section('title', 'Kelola Pengguna')

@section('page-heading', 'Daftar Pengguna')

@section('content')
    <div class="mb-3">
        <a href="{{ route('user.create') }}" class="btn btn-primary btn-md">
            <i class="fa fa-fw fa-plus"></i>
            Tambah Pengguna
        </a>
    </div>
    <div class="table-responsive">
        <table class="table table-striped text-nowrap">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Username</th>
                    <th scope="col">Nama Lengkap</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                    <tr>
                        <td scope="row">{{ $users->firstItem() + $loop->index }}</td>
                        <td>{{ $user->u_username }}</td>
                        <td>{{ $user->u_nama_lengkap }}</td>
                        <td>
                            <button type="button" class="btn btn-secondary btn-sm" data-bs-toggle="modal"
                                data-bs-target="#modalDetail{{ $user->u_id }}">
                                <i class="fa fa-fw fa-eye"></i>
                            </button>
                            <a href="{{ route('user.edit', $user->u_id) }}" class="btn btn-success btn-sm">
                                <i class="fa fa-fw fa-edit"></i>
                                Edit
                            </a>
                            <button class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                data-bs-target="#modalDelete{{ $user->u_id }}">
                                <i class="fa fa-fw fa-trash"></i>
                                Hapus
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">
                            Belum ada data user
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-between align-items-center mt-3">
        <div>
            <p class="text-muted mb-0">
                Menampilkan {{ $users->firstItem() ?? 0 }} - {{ $users->lastItem() ?? 0 }}
                dari {{ $users->total() }} data
            </p>
        </div>
        <div>
            {{ $users->links() }}
        </div>
    </div>
    @foreach ($users as $user)
        <!-- MODAL DETAIL UNTUK MENAMPILKAN DETAIL USER-->
        <div class="modal fade" id="modalDetail{{ $user->u_id }}" data-bs-backdrop="static" data-bs-keyboard="false"
            tabindex="-1" aria-labelledby="modalDetail{{ $user->u_id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">
                            Detail {{ $user->u_nama_lengkap }}
                        </h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="text-center mb-3">
                            <img src="{{ asset('uploads/users/' . $user->u_foto_profile) }}" alt="Foto Profil"
                                class="modal-profile rounded-circle shadow" />
                            <h5 class="mt-3 mb-0">
                                {{ $user->u_nama_lengkap }}
                            </h5>
                            <small class="text-muted d-block">
                                {{ '@' . $user->u_username }}
                            </small>
                        </div>

                        <hr />

                        <div class="row mt-3">
                            <div class="col-5 text-muted">Nama Lengkap</div>
                            <div class="col-7 fw-semibold">
                                {{ $user->u_nama_lengkap }}
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col-5 text-muted">Username</div>
                            <div class="col-7 fw-semibold">
                                {{ $user->u_username }}
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col-5 text-muted">Tanggal Dibuat</div>
                            <div class="col-7 fw-semibold">
                                {{ $user->created_at->format('d M Y • H:i') }}
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col-5 text-muted">Terakhir Update</div>
                            <div class="col-7 fw-semibold">
                                {{ $user->updated_at->format('d M Y • H:i') }}
                            </div>
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
        <div class="modal fade" id="modalDelete{{ $user->u_id }}" data-bs-backdrop="static" data-bs-keyboard="false"
            tabindex="-1" aria-labelledby="modalDelete{{ $user->u_id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Konfirmasi</h5>
                    </div>
                    <div class="modal-body">
                        <p>
                            Apakah anda yakin ingin menghapus pengguna dengan
                            username {{ $user->u_username }}.
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            Close
                        </button>
                        <form action="{{ route('user.destroy', $user->u_id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
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
