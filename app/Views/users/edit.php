<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<?php $errors = session('errors') ?? []; ?>
<div class="modal fade modal-modern" id="modalForm" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="modal-title">Edit User</h5>
                    <small class="text-muted">Perbarui data user</small>
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
                                <?php $role = old('role', $user['role']); ?>
                                <option value="Admin" <?= $role === 'Admin' ? 'selected' : '' ?>>Admin</option>
                                <option value="Pengelola Aset" <?= $role === 'Pengelola Aset' ? 'selected' : '' ?>>Pengelola Aset</option>
                                <option value="Petugas Lapangan" <?= $role === 'Petugas Lapangan' ? 'selected' : '' ?>>Petugas Lapangan</option>
                                <option value="Pimpinan" <?= $role === 'Pimpinan' ? 'selected' : '' ?>>Pimpinan</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">OPD</label>
                            <input type="text" name="opd" class="form-control" value="<?= old('opd', $user['opd']) ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Password (kosongkan jika tidak diubah)</label>
                            <input type="password" name="password" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer px-0">
                        <button type="submit" class="btn btn-primary rounded-pill">
                            <i class="bi bi-save2 me-1"></i>Update
                        </button>
                        <button type="button" class="btn btn-outline-secondary rounded-pill" data-bs-dismiss="modal">
                            <i class="bi bi-x-circle me-1"></i>Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const modalEl = document.getElementById('modalForm');
        if (!modalEl || typeof bootstrap === 'undefined') return;
        const modal = new bootstrap.Modal(modalEl, { backdrop: 'static' });
        modal.show();
        modalEl.addEventListener('hidden.bs.modal', function () {
            window.location.href = '<?= base_url('users') ?>';
        });
    });
</script>
<?= $this->endSection() ?>
