<div class="modal-header bg-primary-subtle border-bottom px-4 py-3">
    <div class="d-flex align-items-center gap-3">
        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 38px; height: 38px;">
            <i class="bi bi-person-plus-fill fs-5"></i>
        </div>
        <div>
            <h5 class="modal-title fw-bold text-dark mb-0">Tambah Akun Pengguna Baru</h5>
            <small class="text-primary fw-medium">Kelola Hak Akses & Pengguna Sistem</small>
        </div>
    </div>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
</div>
<div class="modal-body p-4">
    <form action="<?= base_url('users') ?>" method="post" onsubmit="handleFormSubmit(this)">
        <?= csrf_field() ?>
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label small fw-semibold text-secondary mb-1">Nama Lengkap <span class="text-danger">*</span></label>
                <div class="input-group">
                    <span class="input-group-text bg-white text-muted"><i class="bi bi-person"></i></span>
                    <input type="text" name="nama" class="form-control form-control-soft" placeholder="Nama lengkap..." value="<?= old('nama') ?>" required>
                </div>
            </div>
            <div class="col-md-6">
                <label class="form-label small fw-semibold text-secondary mb-1">Alamat Email <span class="text-danger">*</span></label>
                <div class="input-group">
                    <span class="input-group-text bg-white text-muted"><i class="bi bi-envelope"></i></span>
                    <input type="email" name="email" class="form-control form-control-soft" placeholder="email@domain.com" value="<?= old('email') ?>" required>
                </div>
            </div>
            <div class="col-md-6">
                <label class="form-label small fw-semibold text-secondary mb-1">Role / Hak Akses <span class="text-danger">*</span></label>
                <div class="input-group">
                    <span class="input-group-text bg-white text-muted"><i class="bi bi-shield-lock"></i></span>
                    <select name="role" class="form-select form-select-soft" required>
                        <option value="Admin" <?= old('role') === 'Admin' ? 'selected' : '' ?>>Admin (Akses Penuh)</option>
                        <option value="Pengelola Aset" <?= old('role', 'Pengelola Aset') === 'Pengelola Aset' ? 'selected' : '' ?>>Pengelola Aset (Input & Edit)</option>
                        <option value="Petugas Lapangan" <?= old('role') === 'Petugas Lapangan' ? 'selected' : '' ?>>Petugas Lapangan (Update Status & Dokumen)</option>
                        <option value="Pimpinan" <?= old('role') === 'Pimpinan' ? 'selected' : '' ?>>Pimpinan (Read Only / Monitoring)</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <label class="form-label small fw-semibold text-secondary mb-1">OPD Instansi</label>
                <div class="input-group">
                    <span class="input-group-text bg-white text-muted"><i class="bi bi-building"></i></span>
                    <input type="text" name="opd" class="form-control form-control-soft" placeholder="Nama OPD..." value="<?= old('opd') ?>">
                </div>
            </div>
            <div class="col-12">
                <label class="form-label small fw-semibold text-secondary mb-1">Password Akses <span class="text-danger">*</span></label>
                <div class="input-group">
                    <span class="input-group-text bg-white text-muted"><i class="bi bi-key"></i></span>
                    <input type="password" name="password" class="form-control form-control-soft" placeholder="Minimal 6 karakter" required>
                </div>
            </div>
        </div>

        <div class="mt-4 pt-3 border-top d-flex justify-content-end gap-2">
            <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">
                Batal
            </button>
            <button type="submit" class="btn btn-primary rounded-pill px-4 fw-semibold shadow-sm" id="btnSubmitUser">
                <i class="bi bi-save2 me-1"></i> Simpan User
            </button>
        </div>
    </form>
</div>
