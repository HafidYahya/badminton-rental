@extends('layouts.admin')

@section('title', 'Kelola Pengguna')

@section('page-heading', 'Daftar Pengguna')

@section('content')
    <div class="mb-3 d-flex flex-column flex-sm-row gap-3 justify-content-between ">
        <a href="{{ route('user.create') }}" class="btn btn-primary btn-md btn-add">
            <i class="fa fa-fw fa-plus"></i>
            Tambah Pengguna
        </a>
        <input type="search" name="searchUser" id="searchUser" placeholder="Cari Username..." class="input-search"
            autocomplete="off">
    </div>
    <div class="table-responsive">
        <table class="table text-nowrap">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Username</th>
                    <th scope="col">Nama Lengkap</th>
                    <th scope="col">Tanggal Dibuat</th>
                    <th scope="col">Terakhir Diubah</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody id="table-users">
                @forelse ($users as $user)
                    <tr>
                        <td scope="row">{{ $users->firstItem() + $loop->index }}</td>
                        <td>{{ $user->u_username }}</td>
                        <td>{{ $user->u_nama_lengkap }}</td>
                        <td>{{ $user->created_at->isoFormat('dddd DD MMM YYYY') }}</td>
                        <td>{{ $user->updated_at->isoFormat('dddd DD MMM YYYY') }}</td>
                        <td class="d-flex flex-row gap-2 justify-center">

                            <a href="{{ route('user.edit', $user->u_id) }}" class="btn btn-white btn-sm btn-aksi">
                                <i class="fa fa-fw fa-edit"></i>
                            </a>
                            <button class="btn btn-white btn-sm btn-aksi" data-bs-toggle="modal"
                                data-bs-target="#modalDelete{{ $user->u_id }}">
                                <i class="fa fa-fw fa-trash"></i> </button>
                            <button type="button" class="btn btn-white btn-sm btn-detail" data-bs-toggle="modal"
                                data-bs-target="#modalDetail{{ $user->u_id }}">
                                LihatDetail
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
                            <img src="{{ asset('uploads/users/' . $user->u_foto_profil) }}" alt="Foto Profil"
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

@push('scripts')
    <script>
        const searchInput = document.getElementById('searchUser');
        const tableUsers = document.getElementById('table-users');
        const editUserUrl = @json(route('user.edit', ['user' => '__USER_ID__']));
        const deleteUserUrl = @json(route('user.destroy', ['user' => '__USER_ID__']));
        const csrfToken = @json(csrf_token());

        function createElement(tag, className, text) {
            const element = document.createElement(tag);
            if (className) element.className = className;
            if (text !== undefined) element.textContent = text;
            return element;
        }

        function createUserModals(user) {
            const detailModalId = `search-user-detail-${user.u_id}`;
            const deleteModalId = `search-user-delete-${user.u_id}`;
            const detailModal = createElement('div', 'modal fade search-user-modal');
            detailModal.id = detailModalId;
            detailModal.tabIndex = -1;
            detailModal.setAttribute('aria-hidden', 'true');

            const detailDialog = createElement('div', 'modal-dialog modal-dialog-centered modal-dialog-scrollable');
            const detailContent = createElement('div', 'modal-content');
            const detailHeader = createElement('div', 'modal-header');
            detailHeader.appendChild(createElement('h5', 'modal-title', `Detail ${user.u_nama_lengkap}`));
            const detailClose = createElement('button', 'btn-close');
            detailClose.type = 'button';
            detailClose.setAttribute('data-bs-dismiss', 'modal');
            detailClose.setAttribute('aria-label', 'Close');
            detailHeader.appendChild(detailClose);

            const detailBody = createElement('div', 'modal-body');
            const profile = createElement('div', 'text-center mb-3');
            const photo = createElement('img', 'modal-profile rounded-circle shadow');
            photo.src = @json(asset('uploads/users')) + '/' + encodeURIComponent(user.u_foto_profil ||
                'undraw_profile.svg');
            photo.alt = 'Foto Profil';
            profile.appendChild(photo);
            profile.appendChild(createElement('h5', 'mt-3 mb-0', user.u_nama_lengkap));
            profile.appendChild(createElement('small', 'text-muted d-block', `@${user.u_username}`));
            detailBody.appendChild(profile);
            detailBody.appendChild(createElement('hr'));

            [
                ['Nama Lengkap', user.u_nama_lengkap],
                ['Username', user.u_username],
                ['Tanggal Dibuat', new Date(user.created_at).toLocaleString('id-ID')],
                ['Terakhir Update', new Date(user.updated_at).toLocaleString('id-ID')]
            ].forEach(([label, value]) => {
                const line = createElement('div', 'row mt-2');
                line.appendChild(createElement('div', 'col-5 text-muted', label));
                line.appendChild(createElement('div', 'col-7 fw-semibold', value));
                detailBody.appendChild(line);
            });

            const detailFooter = createElement('div', 'modal-footer');
            const detailFooterClose = createElement('button', 'btn btn-secondary', 'Close');
            detailFooterClose.type = 'button';
            detailFooterClose.setAttribute('data-bs-dismiss', 'modal');
            detailFooter.appendChild(detailFooterClose);
            detailContent.append(detailHeader, detailBody, detailFooter);
            detailDialog.appendChild(detailContent);
            detailModal.appendChild(detailDialog);

            const deleteModal = createElement('div', 'modal fade search-user-modal');
            deleteModal.id = deleteModalId;
            deleteModal.tabIndex = -1;
            deleteModal.setAttribute('aria-hidden', 'true');
            const deleteDialog = createElement('div', 'modal-dialog');
            const deleteContent = createElement('div', 'modal-content');
            const deleteHeader = createElement('div', 'modal-header');
            deleteHeader.appendChild(createElement('h5', 'modal-title', 'Konfirmasi'));
            const deleteBody = createElement('div', 'modal-body');
            deleteBody.appendChild(createElement('p', '',
                `Apakah anda yakin ingin menghapus pengguna dengan username ${user.u_username}?`));
            const deleteFooter = createElement('div', 'modal-footer');
            const cancelDelete = createElement('button', 'btn btn-secondary', 'Close');
            cancelDelete.type = 'button';
            cancelDelete.setAttribute('data-bs-dismiss', 'modal');
            const deleteForm = document.createElement('form');
            deleteForm.method = 'POST';
            deleteForm.action = deleteUserUrl.replace('__USER_ID__', encodeURIComponent(user.u_id));
            const tokenField = document.createElement('input');
            tokenField.type = 'hidden';
            tokenField.name = '_token';
            tokenField.value = csrfToken;
            const methodField = document.createElement('input');
            methodField.type = 'hidden';
            methodField.name = '_method';
            methodField.value = 'DELETE';
            const confirmDelete = createElement('button', 'btn btn-danger', 'Hapus');
            confirmDelete.type = 'submit';
            deleteForm.append(tokenField, methodField, confirmDelete);
            deleteFooter.append(cancelDelete, deleteForm);
            deleteContent.append(deleteHeader, deleteBody, deleteFooter);
            deleteDialog.appendChild(deleteContent);
            deleteModal.appendChild(deleteDialog);

            document.body.append(detailModal, deleteModal);
            return {
                detailModalId,
                deleteModalId
            };
        }

        let timer;

        searchInput.addEventListener('input', () => {
            clearTimeout(timer);

            const keyword = searchInput.value.trim();

            timer = setTimeout(async () => {
                try {
                    const response = await fetch(
                        `{{ route('users.search') }}?search=${encodeURIComponent(keyword)}`
                    );
                    if (!response.ok) {
                        throw new Error('Gagal mengambil data');
                    }

                    const users = await response.json();
                    tableUsers.replaceChildren();
                    document.querySelectorAll('.search-user-modal').forEach(modal => modal.remove());

                    if (users.length === 0) {
                        const row = document.createElement('tr');
                        const cell = document.createElement('td');
                        cell.colSpan = 6;
                        cell.className = 'text-center';
                        cell.textContent = 'Data tidak ditemukan';
                        row.appendChild(cell);
                        tableUsers.appendChild(row);
                        return;
                    }

                    users.forEach((user, index) => {
                        const row = document.createElement('tr');
                        const values = [
                            index + 1,
                            user.u_username,
                            user.u_nama_lengkap,
                            new Date(user.created_at).toLocaleDateString('id-ID', {
                                weekday: 'long',
                                day: '2-digit',
                                month: 'short',
                                year: 'numeric'
                            }),
                            new Date(user.updated_at).toLocaleDateString('id-ID', {
                                weekday: 'long',
                                day: '2-digit',
                                month: 'short',
                                year: 'numeric'
                            })
                        ];

                        values.forEach(value => {
                            const cell = document.createElement('td');
                            cell.textContent = value ?? '';
                            row.appendChild(cell);
                        });

                        const actionCell = document.createElement('td');
                        const editLink = document.createElement('a');
                        editLink.href = editUserUrl.replace('__USER_ID__', encodeURIComponent(
                            user.u_id));
                        editLink.className = 'btn btn-white btn-sm btn-aksi';
                        editLink.innerHTML = '<i class="fa fa-fw fa-edit"></i>';
                        editLink.setAttribute('aria-label', `Edit ${user.u_username}`);
                        actionCell.appendChild(editLink);

                        const modalIds = createUserModals(user);
                        const deleteButton = createElement('button',
                            'btn btn-white btn-sm btn-aksi');
                        deleteButton.type = 'button';
                        deleteButton.innerHTML = '<i class="fa fa-fw fa-trash"></i>';
                        deleteButton.setAttribute('aria-label', `Hapus ${user.u_username}`);
                        deleteButton.setAttribute('data-bs-toggle', 'modal');
                        deleteButton.setAttribute('data-bs-target',
                            `#${modalIds.deleteModalId}`);
                        actionCell.appendChild(deleteButton);

                        const detailButton = createElement('button',
                            'btn btn-white btn-sm btn-detail', 'LihatDetail');
                        detailButton.type = 'button';
                        detailButton.setAttribute('data-bs-toggle', 'modal');
                        detailButton.setAttribute('data-bs-target',
                            `#${modalIds.detailModalId}`);
                        actionCell.appendChild(detailButton);

                        actionCell.className = 'd-flex flex-row gap-2 justify-center';
                        row.appendChild(actionCell);
                        tableUsers.appendChild(row);
                    });
                } catch (error) {
                    console.error(error);
                }
            }, 300);
        });
    </script>
@endpush
