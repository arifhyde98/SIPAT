<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<style>
    .card-hover {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .card-hover:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.08) !important;
    }
    .btn-light-primary {
        background: rgba(59, 130, 246, 0.1);
        color: #2563eb;
        border: none;
    }
    .btn-light-primary:hover {
        background: rgba(59, 130, 246, 0.2);
        color: #1d4ed8;
    }
    .btn-light-danger {
        background: rgba(239, 68, 68, 0.1);
        color: #dc2626;
        border: none;
    }
    .btn-light-danger:hover {
        background: rgba(239, 68, 68, 0.2);
        color: #b91c1c;
    }
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

<?php if (session()->getFlashdata('success')) : ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle me-2"></i>
        <strong>Berhasil!</strong> <?= esc(session()->getFlashdata('success')) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

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

<div class="d-flex justify-content-between align-items-end mb-4">
    <div class="d-flex align-items-center gap-3">
        <div class="bg-white p-3 rounded-4 shadow-sm d-flex align-items-center justify-content-center" style="width: 64px; height: 64px;">
            <i class="bi bi-geo-alt text-primary fs-2"></i>
        </div>
        <div>
            <h1 class="h3 fw-bold text-dark mb-1">Master Desa</h1>
            <p class="text-muted mb-0">Tambah dan kelola daftar desa/kelurahan.</p>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm rounded-4 card-hover h-100">
            <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0">
                <h5 class="card-title fw-bold text-primary mb-0"><i class="bi bi-plus-circle me-2"></i>Form Input</h5>
            </div>
            <div class="card-body p-4">
                <form method="post" action="<?= base_url('master/desa') ?>" id="formDesaBaru">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label for="kecamatanId" class="form-label">Kecamatan</label>
                        <select id="kecamatanId" name="kecamatan_id" class="form-select" required>
                            <option value="">- Pilih Kecamatan -</option>
                            <?php foreach ($kecamatanList ?? [] as $kecamatan) : ?>
                                <option value="<?= esc($kecamatan['id']) ?>" <?= old('kecamatan_id') == $kecamatan['id'] ? 'selected' : '' ?>>
                                    <?= esc($kecamatan['nama']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <?php if (isset($errors['kecamatan_id'])) : ?>
                            <div class="invalid-feedback"><?= esc($errors['kecamatan_id']) ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="mb-3">
                        <label for="jenisId" class="form-label">Jenis Wilayah</label>
                        <select id="jenisId" name="jenis" class="form-select" required>
                            <option value="">- Pilih Jenis -</option>
                            <option value="Desa" <?= old('jenis') === 'Desa' ? 'selected' : '' ?>>Desa</option>
                            <option value="Kelurahan" <?= old('jenis') === 'Kelurahan' ? 'selected' : '' ?>>Kelurahan</option>
                        </select>
                        <?php if (isset($errors['jenis'])) : ?>
                            <div class="invalid-feedback"><?= esc($errors['jenis']) ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="mb-4">
                        <label for="namaId" class="form-label">Nama Desa/Kelurahan</label>
                        <input type="text" id="namaId" name="nama" class="form-control" placeholder="Contoh: Kabonga Kecil" value="<?= esc(old('nama') ?? '') ?>" required>
                        <?php if (isset($errors['nama'])) : ?>
                            <div class="invalid-feedback"><?= esc($errors['nama']) ?></div>
                        <?php endif; ?>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold rounded-3">
                        <i class="bi bi-save me-2"></i>Simpan Data
                    </button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4 card-hover h-100">
            <div class="card-body p-4">
                <!-- Bulk Action & Filter -->
                <div class="bg-light rounded-3 p-3 mb-4">
                    <form method="post" action="<?= base_url('master/desa/bulk-kecamatan') ?>" id="bulkDesaForm" class="row g-2 align-items-end">
                        <?= csrf_field() ?>
                        <div class="col-md-6">
                            <label for="bulkKecamatanId" class="form-label mb-1">Update Kecamatan (Bulk)</label>
                            <select id="bulkKecamatanId" name="kecamatan_id" class="form-select form-select-sm" required>
                                <option value="">- Pilih Target -</option>
                                <?php foreach ($kecamatanList ?? [] as $kecamatan) : ?>
                                    <option value="<?= esc($kecamatan['id']) ?>"><?= esc($kecamatan['nama']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-primary btn-sm w-100" id="bulkDesaSubmit" disabled>
                                <i class="bi bi-check2-all me-1"></i>Terapkan ke <span id="bulkDesaCount" class="badge bg-white text-primary ms-1">0</span> item
                            </button>
                        </div>
                    </form>
                </div>

                <form method="get" class="row g-2 align-items-end mb-4">
                    <div class="col-md-4">
                        <label for="filterKecamatan" class="form-label mb-1">Filter Kecamatan</label>
                        <select id="filterKecamatan" name="kecamatan_id" class="form-select form-select-sm">
                            <option value="">- Semua -</option>
                            <?php foreach ($kecamatanList ?? [] as $kecamatan) : ?>
                                <option value="<?= esc($kecamatan['id']) ?>" <?= ((string) ($filters['kecamatan_id'] ?? '') === (string) $kecamatan['id']) ? 'selected' : '' ?>>
                                    <?= esc($kecamatan['nama']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="filterJenis" class="form-label mb-1">Jenis</label>
                        <select id="filterJenis" name="jenis" class="form-select form-select-sm">
                            <option value="">- Semua -</option>
                            <option value="Desa" <?= ($filters['jenis'] ?? '') === 'Desa' ? 'selected' : '' ?>>Desa</option>
                            <option value="Kelurahan" <?= ($filters['jenis'] ?? '') === 'Kelurahan' ? 'selected' : '' ?>>Kelurahan</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="filterSearch" class="form-label mb-1">Cari</label>
                        <input type="text" id="filterSearch" name="q" class="form-control form-control-sm" placeholder="Nama..." value="<?= esc($filters['q'] ?? '') ?>">
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-outline-secondary btn-sm w-100">
                            <i class="bi bi-search me-1"></i> Cari
                        </button>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table align-middle mb-0 table-hover">
                        <thead class="bg-light">
                            <tr>
                                <th width="40" class="text-center">
                                    <input type="checkbox" id="desaCheckAll" class="form-check-input">
                                </th>
                                <th>ID</th>
                                <th>Kecamatan</th>
                                <th>Jenis</th>
                                <th>Nama Wilayah</th>
                                <th class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($rows)) : ?>
                                <?php foreach ($rows as $row) : ?>
                                    <tr>
                                        <td class="text-center">
                                            <input type="checkbox" name="ids[]" value="<?= esc($row['id']) ?>" form="bulkDesaForm" class="form-check-input desa-check">
                                        </td>
                                        <td class="text-muted small"><?= esc($row['id']) ?></td>
                                        <td><span class="fw-medium text-dark"><?= esc($row['kecamatan_nama'] ?? '-') ?></span></td>
                                        <td>
                                            <?php if (($row['jenis'] ?? '') === 'Kelurahan') : ?>
                                                <span class="badge bg-warning-subtle text-warning border border-warning-subtle rounded-pill">Kelurahan</span>
                                            <?php else : ?>
                                                <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill">Desa</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="fw-bold text-primary-emphasis"><?= esc($row['nama']) ?></td>
                                        <td class="text-end">
                                            <div class="btn-group">
                                                <a href="<?= base_url('master/desa/' . $row['id'] . '/edit') ?>" class="btn btn-sm btn-light-primary rounded-start-pill ps-3 pe-2" title="Edit Desa">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>
                                                <form method="post" action="<?= base_url('master/desa/delete/' . $row['id']) ?>" data-confirm="Yakinkah ingin menghapus desa '<?= esc($row['nama']) ?>'?" class="d-inline">
                                                    <?= csrf_field() ?>
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <button type="submit" class="btn btn-sm btn-light-danger rounded-end-pill ps-2 pe-3" title="Hapus Desa">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">
                                        <i class="bi bi-inbox fs-1 d-block mb-2 opacity-25"></i>
                                        <div class="fw-semibold">Belum ada data desa/kelurahan</div>
                                        <small>Tambahkan desa/kelurahan baru melalui form di sebelah kiri</small>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Element references
        const checkAll = document.getElementById('desaCheckAll');
        const checks = Array.from(document.querySelectorAll('.desa-check'));
        const bulkForm = document.getElementById('bulkDesaForm');
        const bulkSubmit = document.getElementById('bulkDesaSubmit');
        const bulkCount = document.getElementById('bulkDesaCount');
        const bulkSelect = bulkForm ? bulkForm.querySelector('select[name="kecamatan_id"]') : null;

        // Function to update bulk action state
        const updateBulkState = () => {
            const selected = checks.filter(cb => cb.checked).length;
            if (bulkCount) bulkCount.textContent = selected.toString();
            if (bulkSubmit) {
                const hasTarget = bulkSelect && bulkSelect.value;
                bulkSubmit.disabled = selected === 0 || !hasTarget;
            }
        };

        // Select all functionality
        if (checkAll) {
            checkAll.addEventListener('change', () => {
                checks.forEach(cb => { cb.checked = checkAll.checked; });
                updateBulkState();
            });
        }

        // Individual checkbox listeners
        checks.forEach(cb => {
            cb.addEventListener('change', () => {
                // Update "check all" state
                if (checkAll) {
                    const allChecked = checks.every(c => c.checked);
                    const someChecked = checks.some(c => c.checked);
                    checkAll.checked = allChecked;
                    checkAll.indeterminate = someChecked && !allChecked;
                }
                updateBulkState();
            });
        });

        // Bulk select listener
        if (bulkSelect) {
            bulkSelect.addEventListener('change', updateBulkState);
        }

        // Form submission handler
        if (bulkForm) {
            bulkForm.addEventListener('submit', function(e) {
                const selected = checks.filter(cb => cb.checked).length;
                if (selected === 0) {
                    e.preventDefault();
                    alert('Pilih minimal 1 desa untuk diupdate!');
                    return false;
                }
                if (!bulkSelect || !bulkSelect.value) {
                    e.preventDefault();
                    alert('Pilih kecamatan tujuan!');
                    return false;
                }
                // Show loading state
                bulkSubmit.disabled = true;
                const originalHtml = bulkSubmit.innerHTML;
                bulkSubmit.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Memproses...';
                
                setTimeout(() => {
                    bulkSubmit.innerHTML = originalHtml;
                    bulkSubmit.disabled = false;
                }, 3000);
            });
        }

        // Initial state
        updateBulkState();
    });
</script>
<?= $this->endSection() ?>
