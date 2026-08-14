<div class="modal-header bg-warning-subtle border-bottom px-4 py-3">
    <div class="d-flex align-items-center gap-3">
        <div class="bg-warning text-dark rounded-circle d-flex align-items-center justify-content-center" style="width: 38px; height: 38px;">
            <i class="bi bi-pencil-square fs-5"></i>
        </div>
        <div>
            <h5 class="modal-title fw-bold text-dark mb-0">Edit Akun Pengguna</h5>
            <small class="text-warning-emphasis fw-medium">Perbarui Hak Akses, OPD & Password</small>
        </div>
    </div>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
</div>
<div class="modal-body p-4">
    <form action="<?= base_url('users/' . $user['id_user']) ?>" method="post" onsubmit="handleFormSubmit(this)">
        <?= csrf_field() ?>
        <input type="hidden" name="_method" value="PUT">
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label small fw-semibold text-secondary mb-1">Nama Lengkap <span class="text-danger">*</span></label>
                <div class="input-group">
                    <span class="input-group-text bg-white text-muted"><i class="bi bi-person"></i></span>
                    <input type="text" name="nama" class="form-control form-control-soft" value="<?= old('nama', $user['nama']) ?>" required>
                </div>
            </div>
            <div class="col-md-6">
                <label class="form-label small fw-semibold text-secondary mb-1">Alamat Email <span class="text-danger">*</span></label>
                <div class="input-group">
                    <span class="input-group-text bg-white text-muted"><i class="bi bi-envelope"></i></span>
                    <input type="email" name="email" class="form-control form-control-soft" value="<?= old('email', $user['email']) ?>" required>
                </div>
            </div>
            <div class="col-md-6">
                <label class="form-label small fw-semibold text-secondary mb-1">Role / Hak Akses <span class="text-danger">*</span></label>
                <div class="input-group">
                    <span class="input-group-text bg-white text-muted"><i class="bi bi-shield-lock"></i></span>
                    <select name="role" class="form-select form-select-soft" required>
                        <?php
                            $roles = ['Admin', 'Pengelola Aset', 'Petugas Lapangan', 'Pimpinan'];
                            $current = old('role', $user['role']);
                        ?>
                        <?php foreach ($roles as $role) : ?>
                            <option value="<?= esc($role) ?>" <?= $current === $role ? 'selected' : '' ?>><?= esc($role) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <label class="form-label small fw-semibold text-secondary mb-1">OPD Instansi</label>
                <div class="input-group">
                    <span class="input-group-text bg-white text-muted"><i class="bi bi-building"></i></span>
                    <input type="text" name="opd" class="form-control form-control-soft" value="<?= old('opd', $user['opd']) ?>">
                </div>
            </div>
            <div class="col-12">
                <label class="form-label small fw-semibold text-secondary mb-1">Password Baru (Biarkan kosong jika tidak diubah)</label>
                <div class="input-group">
                    <span class="input-group-text bg-white text-muted"><i class="bi bi-key"></i></span>
                    <input type="password" name="password" class="form-control form-control-soft" placeholder="Kosongkan jika password tidak diganti">
                </div>
            </div>
        </div>

        <div class="mt-4 pt-3 border-top d-flex justify-content-end gap-2">
            <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">
                Batal
            </button>
            <button type="submit" class="btn btn-warning rounded-pill px-4 fw-semibold shadow-sm text-dark" id="btnSubmitUser">
                <i class="bi bi-check-circle me-1"></i> Update User
            </button>
        </div>
    </form>
</div>
