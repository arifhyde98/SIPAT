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
        <div class="d-flex flex-column gap-4">
            <div class="row g-3">
                <div class="col-8">
                    <div class="form-floating">
                        <input type="text" name="nama_status" id="nama_status" class="form-control" placeholder="Nama Status" value="<?= old('nama_status') ?>" required>
                        <label for="nama_status">Nama Status</label>
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-floating">
                        <input type="number" name="urutan" id="urutan" class="form-control" placeholder="Urutan" value="<?= old('urutan') ?>" required>
                        <label for="urutan">Urutan</label>
                    </div>
                </div>
            </div>
            
            <div>
                <label class="form-label fw-semibold mb-2">Pilih Visual Warna</label>
                <div class="d-flex flex-wrap gap-2">
                    <?php 
                    $colors = [
                        'primary'   => 'Biru',
                        'secondary' => 'Abu-abu',
                        'success'   => 'Hijau',
                        'danger'    => 'Merah',
                        'warning'   => 'Kuning',
                        'info'      => 'Cyan',
                        'dark'      => 'Hitam'
                    ];
                    $selected = old('warna', 'secondary');
                    foreach ($colors as $value => $label): ?>
                        <input type="radio" class="btn-check" name="warna" id="c-<?= $value ?>" value="<?= $value ?>" autocomplete="off" <?= $value === $selected ? 'checked' : '' ?>>
                        <label class="btn btn-outline-<?= $value ?> rounded-pill px-3 py-1 fw-medium" for="c-<?= $value ?>">
                            <i class="bi bi-circle-fill small me-1"></i> <?= $label ?>
                        </label>
                    <?php endforeach; ?>
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
