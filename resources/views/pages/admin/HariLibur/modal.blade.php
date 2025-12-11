<div class="modal fade" id="hariLiburModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Tambah Hari Libur</h5>
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>
            </div>

            <form id="hariLiburForm">
                @csrf
                <input type="hidden" name="id" id="hariLiburId" />

                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Tanggal Mulai</label>
                        <input
                            type="date"
                            name="hl_tanggal_mulai"
                            class="form-control"
                            required
                        />
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tanggal Selesai</label>
                        <input
                            type="date"
                            name="hl_tanggal_selesai"
                            class="form-control"
                            required
                        />
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Keterangan</label>
                        <textarea
                            name="keterangan"
                            class="form-control"
                            rows="3"
                            placeholder="Keterangan"
                            required
                        ></textarea>
                    </div>
                </div>

                <div class="modal-footer">
                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal"
                    >
                        Tutup
                    </button>
                    <button
                        type="button"
                        class="btn btn-danger"
                        id="btnDelete"
                        style="display: none"
                    >
                        Hapus
                    </button>
                    <button type="submit" class="btn btn-primary">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
