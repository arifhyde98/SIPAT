<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<style>
    .form-label {
        font-weight: 600;
        font-size: 0.85rem;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.025em;
    }
    .form-control.is-invalid, 
    .form-select.is-invalid {
        border-color: #dc2626;
    }
    .invalid-feedback {
        display: block;
        color: #dc2626;
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }
</style>

<?php if (session()->getFlashdata('errors')) : ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-triangle me-2"></i>
        <strong>Error!</strong>
        <ul class="mb-0 mt-2">
            <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                <li><?= esc($error) ?></li>
            <?php endforeach; ?>
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div class="d-flex align-items-center gap-3">
        <a href="<?= base_url('master/desa') ?>" class="text-muted" style="text-decoration: none;">
            <i class="bi bi-arrow-left fs-5"></i>
        </a>
        <div>
            <h1 class="h4 fw-semibold mb-1">Edit Desa/Kelurahan</h1>
            <small class="text-muted">Perbarui data desa/kelurahan: <strong><?= esc($row['nama']) ?></strong></small>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">
                <form method="post" action="<?= base_url('master/desa/' . $row['id']) ?>" id="formEditDesa">
                    <?= csrf_field() ?>
                    <input type="hidden" name="_method" value="PUT">
                    
                    <div class="mb-3">
                        <label for="kecamatanEditId" class="form-label">Kecamatan</label>
                        <select id="kecamatanEditId" name="kecamatan_id" class="form-select" required>
                            <option value="">- Pilih Kecamatan -</option>
                            <?php foreach ($kecamatanList ?? [] as $kecamatan) : ?>
                                <option value="<?= esc($kecamatan['id']) ?>" <?= (int) $row['kecamatan_id'] === (int) $kecamatan['id'] ? 'selected' : '' ?>>
                                    <?= esc($kecamatan['nama']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="jenisEditId" class="form-label">Jenis Wilayah</label>
                        <?php $jenis = $row['jenis'] ?? 'Desa'; ?>
                        <select id="jenisEditId" name="jenis" class="form-select" required>
                            <option value="Desa" <?= $jenis === 'Desa' ? 'selected' : '' ?>>Desa</option>
                            <option value="Kelurahan" <?= $jenis === 'Kelurahan' ? 'selected' : '' ?>>Kelurahan</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="namaEditId" class="form-label">Nama Desa/Kelurahan</label>
                        <input type="text" id="namaEditId" name="nama" class="form-control" value="<?= esc($row['nama']) ?>" placeholder="Contoh: Kabonga Kecil" required>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary" id="submitBtn">
                            <i class="bi bi-save me-2"></i>Simpan Perubahan
                        </button>
                        <a href="<?= base_url('master/desa') ?>" class="btn btn-outline-secondary">
                            <i class="bi bi-x-lg me-2"></i>Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm rounded-4 bg-light">
            <div class="card-body p-4">
                <h6 class="fw-semibold mb-3">Informasi Data</h6>
                <div class="small">
                    <div class="mb-3">
                        <span class="text-muted">ID Desa:</span>
                        <br>
                        <span class="badge bg-secondary"><?= esc($row['id']) ?></span>
                    </div>
                    <div class="mb-3">
                        <span class="text-muted">Dibuat:</span>
                        <br>
                        <span class="text-dark-emphasis"><?= $row['created_at'] ? date('d M Y H:i', strtotime($row['created_at'])) : '-' ?></span>
                    </div>
                    <div class="mb-3">
                        <span class="text-muted">Diperbarui:</span>
                        <br>
                        <span class="text-dark-emphasis"><?= $row['updated_at'] ? date('d M Y H:i', strtotime($row['updated_at'])) : '-' ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('formEditDesa');
        const submitBtn = document.getElementById('submitBtn');

        if (form) {
            form.addEventListener('submit', function() {
                // Set loading state
                submitBtn.disabled = true;
                const originalHtml = submitBtn.innerHTML;
                submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Menyimpan...';
                
                // Reset after timeout for fallback
                setTimeout(() => {
                    submitBtn.innerHTML = originalHtml;
                    submitBtn.disabled = false;
                }, 3000);
            });
        }
    });
</script>
<?= $this->endSection() ?>
