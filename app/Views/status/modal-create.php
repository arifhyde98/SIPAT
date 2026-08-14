<div class="modal-header bg-primary-subtle border-bottom px-4 py-3">
    <div class="d-flex align-items-center gap-3">
        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 38px; height: 38px;">
            <i class="bi bi-tag-fill fs-5"></i>
        </div>
        <div>
            <h5 class="modal-title fw-bold text-dark mb-0">Tambah Status Proses</h5>
            <small class="text-primary fw-medium">Kelola Alur & Kategori Dashboard</small>
        </div>
    </div>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
</div>
<div class="modal-body p-4">
    <form action="<?= base_url('status') ?>" method="post" onsubmit="handleFormSubmit(this)">
        <?= csrf_field() ?>
        <div class="d-flex flex-column gap-3">
            <div class="row g-3">
                <div class="col-8">
                    <label class="form-label small fw-semibold text-secondary mb-1">Nama Status <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text bg-white text-muted"><i class="bi bi-tags"></i></span>
                        <input type="text" name="nama_status" id="nama_status" class="form-control form-control-soft" placeholder="Contoh: Proses Pengukuran BPN" value="<?= old('nama_status') ?>" required>
                    </div>
                </div>
                <div class="col-4">
                    <label class="form-label small fw-semibold text-secondary mb-1">Urutan Alur <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text bg-white text-muted"><i class="bi bi-list-ol"></i></span>
                        <input type="number" name="urutan" id="urutan" class="form-control form-control-soft" placeholder="1" value="<?= old('urutan') ?>" required>
                    </div>
                </div>
            </div>
            
            <div class="card bg-light border-0 rounded-3 p-3">
                <label for="kategori" class="form-label fw-bold text-dark mb-1">
                    <i class="bi bi-speedometer2 text-primary me-1"></i> Kategori Statistik Dashboard
                </label>
                <select name="kategori" id="kategori" class="form-select form-select-soft mb-1" required>
                    <option value="belum_diurus" <?= old('kategori') === 'belum_diurus' ? 'selected' : '' ?>>Belum Diurus / Belum Diproses (Masuk Kartu Abu-abu)</option>
                    <option value="proses" <?= old('kategori', 'proses') === 'proses' ? 'selected' : '' ?>>Sedang Diproses / Berjalan (Masuk Kartu Biru)</option>
                    <option value="kendala" <?= old('kategori') === 'kendala' ? 'selected' : '' ?>>Kendala / Bermasalah (Masuk Kartu Merah)</option>
                    <option value="bersertifikat" <?= old('kategori') === 'bersertifikat' ? 'selected' : '' ?>>Sudah Bersertifikat / Selesai (Masuk Kartu Hijau)</option>
                </select>
                <span class="form-text text-muted" style="font-size: 0.78rem;">Mengontrol secara langsung ke kartu mana status ini dihitung di Dashboard.</span>
            </div>
            
            <div>
                <label class="form-label fw-bold text-dark mb-2">Visual Warna Badge</label>
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
                        <label class="btn btn-outline-<?= $value ?> rounded-pill px-3 py-1.5 fw-medium" for="c-<?= $value ?>" style="font-size: 0.82rem;">
                            <i class="bi bi-circle-fill me-1"></i> <?= $label ?>
                        </label>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        
        <div class="mt-4 pt-3 border-top d-flex justify-content-end gap-2">
            <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">
                Batal
            </button>
            <button type="submit" class="btn btn-primary rounded-pill px-4 fw-semibold shadow-sm" id="btnSubmitStatus">
                <i class="bi bi-save2 me-1"></i> Simpan Status
            </button>
        </div>
    </form>
</div>
