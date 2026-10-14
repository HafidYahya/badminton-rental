@extends('layouts.admin')
@section('page-heading', 'Edit Lapangan')
@section('title', 'Edit Lapangan')
@section('content')
    {{-- Breadcrumb --}}
    <div class="mb-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}" class="text-decoration-none">
                        <i class="fas fa-home me-1"></i>Dashboard
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('lapangan.index') }}" class="text-decoration-none">
                        Lapangan
                    </a>
                </li>
                <li class="breadcrumb-item active">
                    Edit {{ $lapangan->l_label }}
                </li>
            </ol>
        </nav>
    </div>

    {{-- Form Card --}}
    <div class="row">
        <div class="col-lg-10 col-xl-9 mx-auto">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold">Edit Lapangan</h5>
                </div>

                <div class="card-body p-4">
                    {{-- Current Photo Preview --}}
                    @if ($lapangan->l_foto)
                        <div class="alert alert-light border mb-4">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <img src="{{ asset('uploads/lapangan/' . $lapangan->l_foto) }}" alt="Foto Lapangan"
                                        class="rounded" style="width: 80px; height: 80px; object-fit: cover;" />
                                </div>
                                <div class="col">
                                    <h6 class="mb-1">Foto Saat Ini</h6>
                                    <p class="mb-0 text-muted small">
                                        Upload foto baru untuk mengubah gambar ini
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif

                    <form class="form-edit-lapangan" method="POST" action="{{ route('lapangan.update', $lapangan) }}"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        {{-- Label & Harga --}}
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="label" class="form-label">
                                    Label Lapangan <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control @error('label') is-invalid @enderror"
                                    id="label" name="label" value="{{ old('label', $lapangan->l_label) }}"
                                    placeholder="Contoh: Lapangan A" />
                                @error('label')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="harga" class="form-label">
                                    Harga per Jam <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" class="form-control @error('harga') is-invalid @enderror"
                                        id="harga" name="harga" placeholder="50000"
                                        value="{{ old('harga', $lapangan->l_harga) }}" />
                                    @error('harga')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Foto --}}
                        <div class="mb-3">
                            <label for="foto_lapangan" class="form-label">
                                Update Foto Lapangan
                            </label>

                            <div class="card border-2 border-dashed">
                                <div class="card-body text-center p-4">
                                    <div id="imagePreview" class="mb-3 d-none">
                                        <img id="preview" src="" alt="Preview" class="img-fluid rounded"
                                            style="max-height: 250px" />
                                        <div class="mt-2">
                                            <button type="button" class="btn btn-sm btn-danger" onclick="removeImage()">
                                                <i class="fas fa-times me-1"></i>Hapus
                                            </button>
                                        </div>
                                    </div>

                                    <div id="uploadPlaceholder">
                                        <i class="fas fa-cloud-upload-alt fa-3x text-muted mb-2"></i>
                                        <p class="text-muted mb-2">Klik untuk pilih foto baru</p>
                                        <small class="text-muted d-block mb-1">JPG, PNG, JPEG (Max 2MB)</small>
                                        <small class="text-warning">Kosongkan jika tidak ingin mengubah foto</small>
                                    </div>

                                    <input class="form-control @error('foto_lapangan') is-invalid @enderror" type="file"
                                        id="foto_lapangan" name="foto_lapangan" accept="image/*"
                                        onchange="previewImage(event)" style="display: none" />

                                    <button type="button" class="btn btn-outline-primary btn-sm mt-2"
                                        onclick="document.getElementById('foto_lapangan').click()">
                                        <i class="fas fa-folder-open me-1"></i>Pilih Foto Baru
                                    </button>
                                </div>
                            </div>

                            @error('foto_lapangan')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Deskripsi --}}
                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi Lapangan</label>
                            <textarea name="deskripsi" id="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" rows="5"
                                placeholder="Masukkan deskripsi lapangan...">{{ old('deskripsi', $lapangan->l_deskripsi) }}</textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Metadata Info --}}
                        <div class="alert alert-light border mb-4">
                            <div class="row small">
                                <div class="col-md-6 mb-2 mb-md-0">
                                    <strong>Dibuat:</strong>
                                    {{ $lapangan->created_at->format('d M Y, H:i') }}
                                </div>
                                <div class="col-md-6">
                                    <strong>Update Terakhir:</strong>
                                    {{ $lapangan->updated_at->format('d M Y, H:i') }}
                                </div>
                            </div>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="d-flex gap-2 justify-content-end pt-3 border-top">
                            <a href="{{ route('lapangan.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-1"></i>Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i>Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Status Toggle Card --}}
            <div class="card shadow-sm mt-3">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-1">Status Lapangan</h6>
                            <p class="mb-0 text-muted small">
                                Status saat ini:
                                <span
                                    class="badge {{ $lapangan->l_status === 'active' ? 'bg-success' : 'bg-danger' }} ms-1">
                                    {{ Str::ucfirst($lapangan->l_status) }}
                                </span>
                            </p>
                        </div>
                        <a href="{{ route('lapangan.status', $lapangan->l_id) }}"
                            class="btn btn-sm {{ $lapangan->l_status === 'active' ? 'btn-warning' : 'btn-success' }}">
                            <i class="fas fa-power-off me-1"></i>
                            {{ $lapangan->l_status === 'active' ? 'Nonaktifkan' : 'Aktifkan' }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Image Preview Function
        function previewImage(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
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
            previewImage({
                target: {
                    files: files
                }
            });
        });
    </script>
@endpush
