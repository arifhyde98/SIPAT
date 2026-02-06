<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<?php $errors = session('errors') ?? []; ?>
<div class="modal fade modal-modern" id="modalForm" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="modal-title">Edit Status</h5>
                    <small class="text-muted">Perbarui status proses</small>
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
                <form action="<?= base_url('status/' . $row['id_status']) ?>" method="post">
                    <?= csrf_field() ?>
                    <input type="hidden" name="_method" value="PUT">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Nama Status</label>
                            <input type="text" name="nama_status" class="form-control" value="<?= old('nama_status', $row['nama_status']) ?>" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Urutan</label>
                            <input type="number" name="urutan" class="form-control" value="<?= old('urutan', $row['urutan']) ?>" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Warna (Bootstrap)</label>
                            <input type="text" name="warna" class="form-control" value="<?= old('warna', $row['warna']) ?>">
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
            window.location.href = '<?= base_url('status') ?>';
        });
    });
</script>
<?= $this->endSection() ?>
