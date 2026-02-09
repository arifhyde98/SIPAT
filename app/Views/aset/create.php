<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<?php $errors = session('errors') ?? []; ?>
<div class="modal fade modal-modern" id="modalForm" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="modal-title">Tambah Aset Tanah</h5>
                    <small class="text-muted">Lengkapi data aset</small>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('aset') ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Kode Aset</label>
                            <input type="text" name="kode_aset" class="form-control" value="<?= old('kode_aset') ?>" required>
                        </div>
                        <div class="col-md-8">
                            <label class="form-label">Nama Aset</label>
                            <input type="text" name="nama_aset" class="form-control" value="<?= old('nama_aset') ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Peruntukan</label>
                            <input type="text" name="peruntukan" class="form-control" value="<?= old('peruntukan') ?>">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Luas (m2)</label>
                            <input type="number" step="0.01" name="luas" class="form-control" value="<?= old('luas') ?>">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Tanggal Perolehan</label>
                            <input type="date" name="tanggal_perolehan" class="form-control" value="<?= old('tanggal_perolehan') ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">OPD</label>
                            <input type="text" name="opd" class="form-control" value="<?= old('opd') ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Dasar Perolehan</label>
                            <input type="text" name="dasar_perolehan" class="form-control" value="<?= old('dasar_perolehan') ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Harga Perolehan</label>
                            <input type="number" step="0.01" name="harga_perolehan" class="form-control" value="<?= old('harga_perolehan') ?>">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Alamat</label>
                            <textarea name="alamat" class="form-control" rows="3"><?= old('alamat') ?></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Latitude</label>
                            <input type="text" name="lat" class="form-control" value="<?= old('lat') ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Longitude</label>
                            <input type="text" name="lng" class="form-control" value="<?= old('lng') ?>">
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
            window.location.href = '<?= base_url('aset') ?>';
        });
    });
</script>
<?= $this->endSection() ?>
