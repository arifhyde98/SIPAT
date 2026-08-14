<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<?php $errors = session('errors') ?? []; ?>
<div class="modal fade modal-modern" id="modalForm" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <!-- Modal Header Edit -->
            <div class="modal-header bg-warning-subtle border-bottom px-4 py-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="bg-warning text-dark rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                        <i class="bi bi-pencil-square fs-5"></i>
                    </div>
                    <div>
                        <h5 class="modal-title fw-bold text-dark mb-0">Edit Data Aset Tanah</h5>
                        <small class="text-warning-emphasis fw-medium">Perbarui rincian data & lokasi geospasial</small>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body p-4">
                <?php if (!empty($errors)): ?>
                    <div class="alert alert-danger rounded-3 p-3 mb-3">
                        <ul class="mb-0 ps-3">
                            <?php foreach ((array)$errors as $error): ?>
                                <li><?= esc($error) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form action="<?= base_url('aset/' . $aset['id_aset']) . (!empty($queryString) ? '?' . $queryString : '') ?>" method="post" id="formEditAset" onsubmit="handleFormSubmit(this)">
                    <?= csrf_field() ?>
                    <input type="hidden" name="_method" value="PUT">
                    
                    <!-- Section 1: Informasi Utama -->
                    <div class="card bg-light border-0 rounded-3 p-3 mb-3">
                        <h6 class="fw-bold text-dark mb-3">
                            <i class="bi bi-card-heading text-warning me-2"></i>1. Identitas & Pemilik Aset
                        </h6>
                        <div class="row g-3">
                            <div class="col-md-5">
                                <label class="form-label small fw-semibold text-secondary">Kode Aset (NIBAR) <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white text-muted"><i class="bi bi-hash"></i></span>
                                    <input type="text" name="kode_aset" class="form-control form-control-soft" placeholder="Contoh: 12.01.02.01.001" value="<?= old('kode_aset', $aset['kode_aset']) ?>" required>
                                </div>
                            </div>
                            <div class="col-md-7">
                                <label class="form-label small fw-semibold text-secondary">Nama Aset Tanah <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white text-muted"><i class="bi bi-geo"></i></span>
                                    <input type="text" name="nama_aset" class="form-control form-control-soft" placeholder="Nama aset tanah..." value="<?= old('nama_aset', $aset['nama_aset']) ?>" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold text-secondary">OPD Pengelola</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white text-muted"><i class="bi bi-building"></i></span>
                                    <select name="opd" class="form-select form-select-soft">
                                        <option value="">- Pilih OPD -</option>
                                        <?php foreach (($opdList ?? []) as $opd) : ?>
                                            <option value="<?= esc($opd) ?>" <?= old('opd', $aset['opd']) === $opd ? 'selected' : '' ?>><?= esc($opd) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold text-secondary">Peruntukan / Penggunaan</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white text-muted"><i class="bi bi-signpost-split"></i></span>
                                    <input type="text" name="peruntukan" class="form-control form-control-soft" placeholder="Contoh: Kantor Kecamatan / Lapangan" value="<?= old('peruntukan', $aset['peruntukan']) ?>">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Section 2: Legalitas & Nilai -->
                    <div class="card bg-light border-0 rounded-3 p-3 mb-3">
                        <h6 class="fw-bold text-dark mb-3">
                            <i class="bi bi-file-earmark-spreadsheet text-success me-2"></i>2. Legalitas, Luas & Nilai Perolehan
                        </h6>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label small fw-semibold text-secondary">Luas Tanah (m²)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white text-muted"><i class="bi bi-aspect-ratio"></i></span>
                                    <input type="number" step="0.01" name="luas" class="form-control form-control-soft" placeholder="0.00" value="<?= old('luas', $aset['luas']) ?>">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-semibold text-secondary">Tanggal Perolehan</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white text-muted"><i class="bi bi-calendar-event"></i></span>
                                    <input type="date" name="tanggal_perolehan" class="form-control form-control-soft" value="<?= old('tanggal_perolehan', $aset['tanggal_perolehan']) ?>">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-semibold text-secondary">Harga Perolehan (Rp)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white text-muted">Rp</span>
                                    <input type="number" step="0.01" name="harga_perolehan" class="form-control form-control-soft" placeholder="0" value="<?= old('harga_perolehan', $aset['harga_perolehan']) ?>">
                                </div>
                            </div>
                            <div class="col-12">
                                <label class="form-label small fw-semibold text-secondary">Dasar Perolehan / Dokumen Awal</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white text-muted"><i class="bi bi-journal-text"></i></span>
                                    <input type="text" name="dasar_perolehan" class="form-control form-control-soft" placeholder="Contoh: Hibah / Pembelian APBD / SK Bupati..." value="<?= old('dasar_perolehan', $aset['dasar_perolehan']) ?>">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Section 3: Geospasial & Alamat -->
                    <div class="card bg-light border-0 rounded-3 p-3 mb-3">
                        <h6 class="fw-bold text-dark mb-3">
                            <i class="bi bi-geo-alt-fill text-danger me-2"></i>3. Lokasi Geospasial & Catatan
                        </h6>
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label small fw-semibold text-secondary">Alamat Lengkap</label>
                                <textarea name="alamat" class="form-control form-control-soft" rows="2" placeholder="Jalan, Desa/Kelurahan, Kecamatan..."><?= old('alamat', $aset['alamat']) ?></textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold text-secondary">Latitude (Koordinat Y)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white text-muted"><i class="bi bi-pin-map"></i></span>
                                    <input type="text" name="lat" class="form-control form-control-soft" placeholder="-0.xxxxxx" value="<?= old('lat', $aset['lat']) ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold text-secondary">Longitude (Koordinat X)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white text-muted"><i class="bi bi-pin-map"></i></span>
                                    <input type="text" name="lng" class="form-control form-control-soft" placeholder="119.xxxxxx" value="<?= old('lng', $aset['lng']) ?>">
                                </div>
                            </div>
                            <div class="col-12">
                                <label class="form-label small fw-semibold text-secondary">Keterangan Tambahan</label>
                                <textarea name="keterangan" class="form-control form-control-soft" rows="2" placeholder="Catatan fisik tanah, batas-batas, atau kondisi saat ini..."><?= old('keterangan', $aset['keterangan'] ?? '') ?></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Footer -->
                    <div class="d-flex justify-content-end gap-2 pt-2 border-top">
                        <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">
                            <i class="bi bi-x-lg me-1"></i> Batal
                        </button>
                        <button type="submit" class="btn btn-warning rounded-pill px-4 fw-semibold shadow-sm text-dark" id="btnSubmitForm">
                            <i class="bi bi-check-circle me-1"></i> Perbarui Data Aset
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
            window.location.href = '<?= base_url('aset') . (!empty($queryString) ? '?' . $queryString : '') ?>';
        });
    });

    function handleFormSubmit(form) {
        const btn = form.querySelector('#btnSubmitForm');
        if (btn) {
            btn.disabled = true;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Memperbarui...';
        }
    }
</script>
<?= $this->endSection() ?>
