<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<?php $errors = session('errors') ?? []; ?>
<div class="modal fade modal-modern" id="modalForm" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="modal-title">Tambah User</h5>
                    <small class="text-muted">Buat akun baru</small>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <?php if (!empty($errors)) : ?>
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            <?php foreach ($errors as $error) : ?>
                                <li><?= esc($error) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
                <form action="<?= base_url('users') ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Nama</label>
                            <input type="text" name="nama" class="form-control" value="<?= old('nama') ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" value="<?= old('email') ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Role</label>
                            <select name="role" class="form-select" required>
                                <option value="Admin">Admin</option>
                                <option value="Pengelola Aset">Pengelola Aset</option>
                                <option value="Petugas Lapangan">Petugas Lapangan</option>
                                <option value="Pimpinan">Pimpinan</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">OPD</label>
                            <input type="text" name="opd" class="form-control" value="<?= old('opd') ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" required>
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
