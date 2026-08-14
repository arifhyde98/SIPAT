<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h4 fw-bold text-dark mb-1">
            <i class="bi bi-building text-warning me-2"></i> Edit Master OPD
        </h1>
        <small class="text-muted">Perbarui data Organisasi Perangkat Daerah</small>
    </div>
    <a href="<?= base_url('master/opd') ?>" class="btn btn-outline-secondary rounded-pill">
        <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar OPD
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="card-header bg-warning-subtle border-bottom px-4 py-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="bg-warning text-dark rounded-circle d-flex align-items-center justify-content-center" style="width: 38px; height: 38px;">
                        <i class="bi bi-pencil-square fs-5"></i>
                    </div>
                    <div>
                        <h5 class="modal-title fw-bold text-dark mb-0">Form Edit OPD</h5>
                        <small class="text-warning-emphasis fw-medium">Ubah nama & status aktif OPD</small>
                    </div>
                </div>
            </div>
            <div class="card-body p-4">
                <form method="post" action="<?= base_url('master/opd/' . $row['id']) ?>">
                    <?= csrf_field() ?>
                    <div class="mb-4">
                        <label class="form-label small fw-semibold text-secondary mb-1">Nama OPD <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-white text-muted"><i class="bi bi-building"></i></span>
                            <input type="text" name="nama" class="form-control form-control-soft" value="<?= esc($row['nama']) ?>" placeholder="Nama OPD..." required>
                        </div>
                    </div>
                    <div class="form-check form-switch mb-4 p-3 bg-light rounded-3">
                        <input class="form-check-input me-2" type="checkbox" name="aktif" id="aktifOpdEdit" value="1" <?= !empty($row['aktif']) ? 'checked' : '' ?>>
                        <label class="form-check-label fw-semibold text-dark" for="aktifOpdEdit">Status Aktif OPD</label>
                        <small class="text-muted d-block mt-1">Jika dinonaktifkan, OPD ini tidak akan muncul pada pilihan filter.</small>
                    </div>
                    <div class="d-flex justify-content-end gap-2 border-top pt-3">
                        <a href="<?= base_url('master/opd') ?>" class="btn btn-light rounded-pill px-4">Batal</a>
                        <button type="submit" class="btn btn-warning rounded-pill px-4 fw-semibold text-dark shadow-sm">
                            <i class="bi bi-check-circle me-1"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
