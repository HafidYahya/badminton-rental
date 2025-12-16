@extends('layouts.admin')
@section('title', 'Customer')
@section('page-heading', 'Customer')
@section('content')
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">No</th>
                <th scope="col">Nama Lengkap</th>
                <th scope="col">No. HP</th>
                <th scope="col">Username</th>
                <th scope="col">Member</th>
                <th scope="col">Status</th>
                <th scope="col">Tanggal Daftar</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($customer as $cs)
                <tr>
                    <td scope="row">{{ $loop->iteration }}</td>
                    <td>{{ $cs->c_nama_lengkap }}</td>
                    <td>{{ $cs->c_no_hp }}</td>
                    <td>{{ $cs->c_username }}</td>
                    <td>
                        <div class="dropdown">
                            <a class="btn btn-sm {{ $cs->c_is_member === 'N' ? 'btn-light border-primary' : 'btn-success ' }} shadow-sm dropdown-toggle"
                                href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                {{ $cs->c_is_member === 'Y' ? 'Member' : 'Non Member' }}
                            </a>

                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item" href="{{ route('activate.member', $cs->c_id) }}">
                                        Member
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('deactivate.member', $cs->c_id) }}">
                                        Non Member
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </td>
                    <td class="fw-bold {{ $cs->c_status === 'active' ? 'text-success' : 'text-danger' }}">
                        {{ Str::ucfirst($cs->c_status) }}
                    </td>
                    <td>
                        {{ $cs->created_at->format('d F Y') }}
                    </td>
                    <td>
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-toggle="modal"
                            data-bs-target="#modalDetail{{ $cs->c_id }}">
                            <i class="fa fa-fw fa-eye"></i>
                        </button>
                        <a href="{{ route('customer.status', $cs->c_id) }}"
                            class="btn btn-sm {{ $cs->c_status === 'active' ? 'btn-danger' : 'btn-success' }}">
                            {{ $cs->c_status === 'active' ? 'Deactivate Status' : 'Activate Status' }}
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">Belum ada data user</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    @foreach ($customer as $cs)
        <!-- MODAL DETAIL UNTUK MENAMPILKAN DETAIL USER-->
        <div class="modal fade" id="modalDetail{{ $cs->c_id }}" data-bs-backdrop="static" data-bs-keyboard="false"
            tabindex="-1" aria-labelledby="modalDetail{{ $cs->c_id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">
                            Detail {{ $cs->cs_nama_lengkap }}
                        </h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="text-center mb-3">
                            <img src="{{ asset('uploads/customers/' . $cs->c_foto_profile) }}" alt="Foto Profil"
                                class="modal-profile rounded-circle shadow" />
                            <h5 class="mt-3 mb-0">
                                {{ $cs->c_nama_lengkap }}
                            </h5>
                            <small class="text-muted d-block mb-3">
                                {{ '@' . $cs->c_username }}
                            </small>
                            <div class="badge d-block p-2 {{ $cs->c_status === 'active' ? 'bg-success' : 'bg-danger' }}">
                                {{ Str::upper($cs->c_status) }}
                            </div>
                        </div>

                        <hr />

                        <div class="row mt-3">
                            <div class="col-5 text-muted">Nama Lengkap</div>
                            <div class="col-7 fw-semibold">
                                {{ $cs->c_nama_lengkap }}
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-5 text-muted">Nomor Handphone</div>
                            <div class="col-7 fw-semibold">
                                {{ $cs->c_no_hp }}
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-5 text-muted">Member</div>
                            <div class="col-7 fw-semibold">
                                <span class="badge {{ $cs->c_is_member === 'Y' ? 'text-bg-success' : 'text-bg-danger' }}">
                                    {{ $cs->c_is_member === 'Y' ? 'Member' : 'Non Member' }}
                                </span>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-5 text-muted">Alamat</div>
                            <div class="col-7 fw-semibold">
                                {{ $cs->c_alamat }}
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-5 text-muted">Tanggal Daftar</div>
                            <div class="col-7 fw-semibold">
                                {{ $cs->created_at->format('d F Y • H:i') }}
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-5 text-muted">Terakhir Update</div>
                            <div class="col-7 fw-semibold">
                                {{ $cs->updated_at->format('d F Y • H:i') }}
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
    @endforeach
    @include('sweetalert2::index')
@endsection
