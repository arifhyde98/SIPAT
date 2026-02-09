<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<?php $errors = session('errors') ?? []; ?>
<div class="modal fade modal-modern" id="modalForm" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="modal-title">Tambah Status</h5>
                    <small class="text-muted">Buat status proses baru</small>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('status') ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Nama Status</label>
                            <input type="text" name="nama_status" class="form-control" value="<?= old('nama_status') ?>" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Urutan</label>
                            <input type="number" name="urutan" class="form-control" value="<?= old('urutan') ?>" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Warna (Bootstrap)</label>
                            <input type="text" name="warna" class="form-control" value="<?= old('warna', 'secondary') ?>">
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
            window.location.href = '<?= base_url('status') ?>';
        });
    });
</script>
<?= $this->endSection() ?>
