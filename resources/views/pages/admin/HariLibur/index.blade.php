@extends("layouts.admin")

@section("title", "Hari Libur")
@section("page-heading", "Kelola Hari Libur")

@section("content")
    <div id="calendar"></div>
    @include("pages.admin.HariLibur.modal")
@endsection

@push("scripts")
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let calendar;
            let currentEvent = null;
            const modalElement = document.getElementById('hariLiburModal');

            // Inisialisasi Calendar
            calendar = new FullCalendar.Calendar(
                document.getElementById('calendar'),
                {
                    initialView: 'dayGridMonth',
                    headerToolbar: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth,dayGridWeek',
                    },
                    events: '/hari-libur/data',
                    selectable: true,
                    selectMirror: true,

                    select(info) {
                        openModal(
                            'add',
                            info.startStr,
                            adjustEndDate(info.endStr),
                        );
                        calendar.unselect();
                    },

                    eventClick(info) {
                        currentEvent = info.event;
                        openModal(
                            'edit',
                            info.event.startStr,
                            adjustEndDate(info.event.endStr),
                            info.event,
                        );
                    },
                },
            );

            calendar.render();

            function adjustEndDate(endStr) {
                const date = new Date(endStr);
                date.setDate(date.getDate() - 1);
                return date.toISOString().split('T')[0];
            }

            function openModal(mode, start, end, event = null) {
                const form = document.getElementById('hariLiburForm');
                const modalTitle = document.getElementById('modalTitle');
                const btnDelete = document.getElementById('btnDelete');

                form.reset();

                if (mode === 'add') {
                    modalTitle.textContent = 'Tambah Hari Libur';
                    btnDelete.style.display = 'none';
                    document.getElementById('hariLiburId').value = '';
                } else {
                    modalTitle.textContent = 'Edit Hari Libur';
                    btnDelete.style.display = 'inline-block';

                    if (event) {
                        document.getElementById('hariLiburId').value =
                            event.id || '';
                        document.querySelector('[name=keterangan]').value =
                            event.title || '';
                    }
                }

                document.querySelector('[name=hl_tanggal_mulai]').value = start;
                document.querySelector('[name=hl_tanggal_selesai]').value = end;

                // Gunakan jQuery Bootstrap modal (lebih compatible)
                $('#hariLiburModal').modal('show');
            }

            // Handle close modal
            $('#hariLiburModal').on('hidden.bs.modal', function () {
                calendar.unselect();
                currentEvent = null;
            });

            // Manual close button handlers
            $('.btn-close, [data-bs-dismiss="modal"]').on('click', function () {
                $('#hariLiburModal').modal('hide');
            });

            // Handle submit form
            document
                .getElementById('hariLiburForm')
                .addEventListener('submit', function (e) {
                    e.preventDefault();

                    const formData = new FormData(this);
                    const id = document.getElementById('hariLiburId').value;
                    const url = id ? `/hari-libur/${id}` : '/hari-libur';
                    const method = id ? 'PUT' : 'POST';

                    const data = {};
                    formData.forEach((value, key) => {
                        if (key !== '_token') data[key] = value;
                    });

                    fetch(url, {
                        method: method,
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN':
                                document.querySelector('[name=_token]').value,
                        },
                        body: JSON.stringify(data),
                    })
                        .then((response) => {
                            const contentType =
                                response.headers.get('content-type');
                            if (
                                !contentType ||
                                !contentType.includes('application/json')
                            ) {
                                return response.text().then((text) => {
                                    console.error('Response HTML:', text);
                                    throw new Error(
                                        'Server mengembalikan HTML. Periksa console untuk detail error.',
                                    );
                                });
                            }

                            if (!response.ok) {
                                return response.json().then((err) => {
                                    throw new Error(
                                        err.message ||
                                            'Terjadi kesalahan pada server',
                                    );
                                });
                            }

                            return response.json();
                        })
                        .then((result) => {
                            if (result.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil!',
                                    text:
                                        result.message ||
                                        'Data berhasil disimpan',
                                    timer: 2000,
                                    showConfirmButton: false,
                                });

                                $('#hariLiburModal').modal('hide');
                                calendar.refetchEvents();
                            } else {
                                throw new Error(
                                    result.message || 'Terjadi kesalahan',
                                );
                            }
                        })
                        .catch((error) => {
                            console.error('Error detail:', error);
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal!',
                                text: error.message,
                            });
                        });
                });

            // Handle delete
            document
                .getElementById('btnDelete')
                .addEventListener('click', function () {
                    const id = document.getElementById('hariLiburId').value;

                    if (!id) return;

                    Swal.fire({
                        title: 'Hapus data ini?',
                        text: 'Data yang dihapus tidak dapat dikembalikan!',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, Hapus!',
                        cancelButtonText: 'Batal',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            fetch(`/hari-libur/${id}`, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN':
                                        document.querySelector('[name=_token]')
                                            .value,
                                    'Content-Type': 'application/json',
                                },
                            })
                                .then((response) => {
                                    const contentType =
                                        response.headers.get('content-type');
                                    if (
                                        !contentType ||
                                        !contentType.includes(
                                            'application/json',
                                        )
                                    ) {
                                        return response.text().then((text) => {
                                            console.error(
                                                'Response HTML:',
                                                text,
                                            );
                                            throw new Error(
                                                'Server mengembalikan HTML. Periksa console untuk detail error.',
                                            );
                                        });
                                    }
                                    return response.json();
                                })
                                .then((result) => {
                                    if (result.success) {
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Terhapus!',
                                            text: 'Data berhasil dihapus',
                                            timer: 2000,
                                            showConfirmButton: false,
                                        });

                                        $('#hariLiburModal').modal('hide');
                                        calendar.refetchEvents();
                                    } else {
                                        throw new Error(
                                            result.message ||
                                                'Gagal menghapus data',
                                        );
                                    }
                                })
                                .catch((error) => {
                                    console.error('Error detail:', error);
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Gagal!',
                                        text:
                                            error.message ||
                                            'Gagal menghapus data',
                                    });
                                });
                        }
                    });
                });
        });
    </script>
@endpush
