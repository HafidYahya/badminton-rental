@extends("layouts.admin")
@section("page-heading", "Tambah Lapangan")
@section("title", "Tambah Lapangan")
@section("content")
    {{-- Modern Header --}}
    <div class="mb-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a
                        href="{{ route("dashboard") }}"
                        class="text-decoration-none"
                    >
                        <i class="fas fa-home me-1"></i>
                        Dashboard
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a
                        href="{{ route("lapangan.index") }}"
                        class="text-decoration-none"
                    >
                        Lapangan
                    </a>
                </li>
                <li class="breadcrumb-item active">Tambah Baru</li>
            </ol>
        </nav>
    </div>

    {{-- Modern Form Card --}}
    <div class="row">
        <div class="col-lg-10 col-xl-9 mx-auto">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-4">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary bg-opacity-10 rounded p-3 me-3">
                            <i
                                class="fas fa-plus-circle fa-2x text-primary"
                            ></i>
                        </div>
                        <div>
                            <h4 class="mb-1 fw-bold">Tambah Lapangan Baru</h4>
                            <p class="text-muted mb-0 small">
                                Lengkapi informasi lapangan badminton
                            </p>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4">
                    <form
                        method="POST"
                        action="{{ route("lapangan.store") }}"
                        enctype="multipart/form-data"
                    >
                        @csrf

                        {{-- Label & Harga Section --}}
                        <div class="row g-4 mb-4">
                            <div class="col-md-6">
                                <label
                                    for="label"
                                    class="form-label fw-semibold"
                                >
                                    <i class="fas fa-tag me-2 text-primary"></i>
                                    Label Lapangan
                                    <span class="text-danger">*</span>
                                </label>
                                <input
                                    type="text"
                                    class="form-control form-control-lg @error("label") is-invalid @enderror"
                                    id="label"
                                    name="label"
                                    placeholder="Contoh: Lapangan A"
                                    value="{{ old("label") }}"
                                />
                                @error("label")
                                    <div
                                        class="invalid-feedback d-flex align-items-center"
                                    >
                                        <i
                                            class="fas fa-exclamation-circle me-2"
                                        ></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label
                                    for="harga"
                                    class="form-label fw-semibold"
                                >
                                    <i
                                        class="fas fa-money-bill-wave me-2 text-success"
                                    ></i>
                                    Harga per Jam
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text bg-light">
                                        Rp
                                    </span>
                                    <input
                                        type="number"
                                        class="form-control @error("harga") is-invalid @enderror"
                                        id="harga"
                                        name="harga"
                                        placeholder="50000"
                                        value="{{ old("harga") }}"
                                    />
                                    @error("harga")
                                        <div
                                            class="invalid-feedback d-flex align-items-center"
                                        >
                                            <i
                                                class="fas fa-exclamation-circle me-2"
                                            ></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <small class="text-muted">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Masukkan harga dalam Rupiah
                                </small>
                            </div>
                        </div>

                        {{-- Foto Section --}}
                        <div class="mb-4">
                            <label
                                for="foto_lapangan"
                                class="form-label fw-semibold"
                            >
                                <i class="fas fa-image me-2 text-info"></i>
                                Foto Lapangan
                                <span class="text-danger">*</span>
                            </label>

                            <div class="card border-2 border-dashed bg-light">
                                <div class="card-body text-center p-4">
                                    <div id="imagePreview" class="mb-3 d-none">
                                        <img
                                            id="preview"
                                            src=""
                                            alt="Preview"
                                            class="img-fluid rounded shadow-sm"
                                            style="max-height: 300px"
                                        />
                                        <button
                                            type="button"
                                            class="btn btn-sm btn-danger mt-2"
                                            onclick="removeImage()"
                                        >
                                            <i class="fas fa-times me-1"></i>
                                            Hapus
                                        </button>
                                    </div>

                                    <div id="uploadPlaceholder">
                                        <i
                                            class="fas fa-cloud-upload-alt fa-3x text-muted mb-3"
                                        ></i>
                                        <h6 class="text-muted">
                                            Klik atau drag foto ke sini
                                        </h6>
                                        <p class="small text-muted mb-3">
                                            Format: JPG, PNG, JPEG (Max 2MB)
                                        </p>
                                    </div>

                                    <input
                                        class="form-control @error("foto_lapangan") is-invalid @enderror"
                                        type="file"
                                        id="foto_lapangan"
                                        name="foto_lapangan"
                                        accept="image/*"
                                        onchange="previewImage(event)"
                                        style="display: none"
                                    />

                                    <button
                                        type="button"
                                        class="btn btn-outline-primary"
                                        onclick="document.getElementById('foto_lapangan').click()"
                                    >
                                        <i class="fas fa-folder-open me-2"></i>
                                        Pilih Foto
                                    </button>
                                </div>
                            </div>

                            @error("foto_lapangan")
                                <div class="text-danger small mt-2">
                                    <i
                                        class="fas fa-exclamation-circle me-1"
                                    ></i>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Deskripsi Section --}}
                        <div class="mb-4">
                            <label
                                for="deskripsi"
                                class="form-label fw-semibold"
                            >
                                <i
                                    class="fas fa-align-left me-2 text-secondary"
                                ></i>
                                Deskripsi Lapangan
                            </label>
                            <textarea
                                name="deskripsi"
                                id="deskripsi"
                                class="form-control @error("deskripsi") is-invalid @enderror"
                                rows="6"
                                placeholder="Masukkan deskripsi detail tentang lapangan..."
                            >
{{ old("deskripsi") }}</textarea
                            >
                            @error("deskripsi")
                                <div
                                    class="invalid-feedback d-flex align-items-center"
                                >
                                    <i
                                        class="fas fa-exclamation-circle me-2"
                                    ></i>
                                    {{ $message }}
                                </div>
                            @enderror

                            <small class="text-muted">
                                <i class="fas fa-info-circle me-1"></i>
                                Anda bisa menggunakan formatting text untuk
                                deskripsi
                            </small>
                        </div>

                        {{-- Action Buttons --}}
                        <div
                            class="d-flex gap-2 justify-content-end pt-3 border-top"
                        >
                            <a
                                href="{{ route("lapangan.index") }}"
                                class="btn btn-light px-4"
                            >
                                <i class="fas fa-times me-2"></i>
                                Batal
                            </a>
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="fas fa-save me-2"></i>
                                Simpan Lapangan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push("scripts")
    <script>
        // Image Preview Function
        function previewImage(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    document.getElementById('preview').src = e.target.result;
                    document
                        .getElementById('imagePreview')
                        .classList.remove('d-none');
                    document
                        .getElementById('uploadPlaceholder')
                        .classList.add('d-none');
                };
                reader.readAsDataURL(file);
            }
        }

        // Remove Image Function
        function removeImage() {
            document.getElementById('foto_lapangan').value = '';
            document.getElementById('imagePreview').classList.add('d-none');
            document
                .getElementById('uploadPlaceholder')
                .classList.remove('d-none');
        }

        // Drag and Drop Support
        const dropArea = document.querySelector('.border-dashed');

        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach((eventName) => {
            dropArea.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        ['dragenter', 'dragover'].forEach((eventName) => {
            dropArea.addEventListener(eventName, () => {
                dropArea.classList.add(
                    'border-primary',
                    'bg-primary',
                    'bg-opacity-10',
                );
            });
        });

        ['dragleave', 'drop'].forEach((eventName) => {
            dropArea.addEventListener(eventName, () => {
                dropArea.classList.remove(
                    'border-primary',
                    'bg-primary',
                    'bg-opacity-10',
                );
            });
        });

        dropArea.addEventListener('drop', (e) => {
            const dt = e.dataTransfer;
            const files = dt.files;
            document.getElementById('foto_lapangan').files = files;
            previewImage({ target: { files: files } });
        });
    </script>
@endpush
