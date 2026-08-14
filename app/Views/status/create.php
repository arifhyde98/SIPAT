<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<?php $errors = session('errors') ?? []; ?>
<div class="modal fade modal-modern" id="modalForm" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-bottom-0 pb-0">
                <div>
                    <h5 class="modal-title fw-bold">Tambah Status</h5>
                    <small class="text-muted">Buat status proses baru</small>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('status') ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="d-flex flex-column gap-3">
                        <div class="form-floating">
                            <input type="text" name="nama_status" id="nama_status" class="form-control" placeholder="Nama Status" value="<?= old('nama_status') ?>" required>
                            <label for="nama_status">Nama Status</label>
                        </div>
                        
                        <div class="row g-3">
                            <div class="col-6">
                                <div class="form-floating">
                                    <input type="number" name="urutan" id="urutan" class="form-control" placeholder="Urutan" value="<?= old('urutan') ?>" required>
                                    <label for="urutan">Urutan</label>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-floating">
                                    <select name="warna" id="warna" class="form-select">
                                        <?php 
                                        $colors = [
                                            'primary' => 'Biru (Primary)',
                                            'secondary' => 'Abu-abu (Secondary)',
                                            'success' => 'Hijau (Success)',
                                            'danger' => 'Merah (Danger)',
                                            'warning' => 'Kuning (Warning)',
                                            'info' => 'Cyan (Info)',
                                            'dark' => 'Hitam (Dark)'
                                        ];
                                        $selected = old('warna', 'secondary');
                                        foreach ($colors as $value => $label): ?>
                                            <option value="<?= $value ?>" <?= $value === $selected ? 'selected' : '' ?>>
                                                <?= $label ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <label for="warna">Warna</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-4 pt-3 border-top d-flex justify-content-end gap-2">
                        <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">
                            Batal
                        </button>
                        <button type="submit" class="btn btn-primary rounded-pill px-4 fw-semibold shadow-sm">
                            <i class="bi bi-save2 me-2"></i>Simpan
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
