<div class="modal-header bg-warning-subtle border-bottom px-4 py-3">
    <div class="d-flex align-items-center gap-3">
        <div class="bg-warning text-dark rounded-circle d-flex align-items-center justify-content-center" style="width: 38px; height: 38px;">
            <i class="bi bi-pencil-square fs-5"></i>
        </div>
        <div>
            <h5 class="modal-title fw-bold text-dark mb-0">Edit Status Proses</h5>
            <small class="text-warning-emphasis fw-medium">Perbarui Nama, Urutan & Kategori Dashboard</small>
        </div>
    </div>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
</div>
<div class="modal-body p-4">
    <form action="<?= base_url('status/' . $row['id_status']) ?>" method="post" onsubmit="handleFormSubmit(this)">
        <?= csrf_field() ?>
        <input type="hidden" name="_method" value="PUT">
        
        <div class="d-flex flex-column gap-3">
            <div class="row g-3">
                <div class="col-8">
                    <label class="form-label small fw-semibold text-secondary mb-1">Nama Status <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text bg-white text-muted"><i class="bi bi-tags"></i></span>
                        <input type="text" name="nama_status" id="nama_status" class="form-control form-control-soft" placeholder="Nama Status" value="<?= old('nama_status', $row['nama_status']) ?>" required>
                    </div>
                </div>
                <div class="col-4">
                    <label class="form-label small fw-semibold text-secondary mb-1">Urutan Alur <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text bg-white text-muted"><i class="bi bi-list-ol"></i></span>
                        <input type="number" name="urutan" id="urutan" class="form-control form-control-soft" placeholder="Urutan" value="<?= old('urutan', $row['urutan']) ?>" required>
                    </div>
                </div>
            </div>
            
            <div class="card bg-light border-0 rounded-3 p-3">
                <label for="e_kategori" class="form-label fw-bold text-dark mb-1">
                    <i class="bi bi-speedometer2 text-warning me-1"></i> Kategori Statistik Dashboard
                </label>
                <?php $currentCat = old('kategori', $row['kategori'] ?? 'proses'); ?>
                <select name="kategori" id="e_kategori" class="form-select form-select-soft mb-1" required>
                    <option value="belum_diurus" <?= $currentCat === 'belum_diurus' ? 'selected' : '' ?>>Belum Diurus / Belum Diproses (Masuk Kartu Abu-abu)</option>
                    <option value="proses" <?= $currentCat === 'proses' ? 'selected' : '' ?>>Sedang Diproses / Berjalan (Masuk Kartu Biru)</option>
                    <option value="kendala" <?= $currentCat === 'kendala' ? 'selected' : '' ?>>Kendala / Bermasalah (Masuk Kartu Merah)</option>
                    <option value="bersertifikat" <?= $currentCat === 'bersertifikat' ? 'selected' : '' ?>>Sudah Bersertifikat / Selesai (Masuk Kartu Hijau)</option>
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
                    $selected = old('warna', $row['warna']);
                    foreach ($colors as $value => $label): ?>
                        <input type="radio" class="btn-check" name="warna" id="e-c-<?= $value ?>" value="<?= $value ?>" autocomplete="off" <?= $value === $selected ? 'checked' : '' ?>>
                        <label class="btn btn-outline-<?= $value ?> rounded-pill px-3 py-1.5 fw-medium" for="e-c-<?= $value ?>" style="font-size: 0.82rem;">
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
            <button type="submit" class="btn btn-warning rounded-pill px-4 fw-semibold shadow-sm text-dark" id="btnSubmitStatus">
                <i class="bi bi-check-circle me-1"></i> Update Status
            </button>
        </div>
    </form>
</div>
