<div class="modal-header">
    <div>
        <h5 class="modal-title">Edit User</h5>
        <small class="text-muted">Perbarui akun</small>
    </div>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
</div>
<div class="modal-body">
    <form action="<?= base_url('users/' . $user['id_user']) ?>" method="post">
        <?= csrf_field() ?>
        <input type="hidden" name="_method" value="PUT">
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Nama</label>
                <input type="text" name="nama" class="form-control" value="<?= old('nama', $user['nama']) ?>" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="<?= old('email', $user['email']) ?>" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Role</label>
                <select name="role" class="form-select" required>
                    <?php
                        $roles = ['Admin', 'Pengelola Aset', 'Petugas Lapangan', 'Pimpinan'];
                        $current = old('role', $user['role']);
                    ?>
                    <?php foreach ($roles as $role) : ?>
                        <option value="<?= esc($role) ?>" <?= $current === $role ? 'selected' : '' ?>><?= esc($role) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">OPD</label>
                <input type="text" name="opd" class="form-control" value="<?= old('opd', $user['opd']) ?>">
            </div>
            <div class="col-md-6">
                <label class="form-label">Password (opsional)</label>
                <input type="password" name="password" class="form-control">
            </div>
        </div>
        <div class="modal-footer px-0">
            <button type="submit" class="btn btn-primary rounded-pill">
                <i class="bi bi-save2 me-1"></i>Simpan
            </button>
            <button type="button" class="btn btn-outline-secondary rounded-pill" data-bs-dismiss="modal">
                <i class="bi bi-x-circle me-1"></i>Batal
            </button>
        </div>
    </form>
</div>
