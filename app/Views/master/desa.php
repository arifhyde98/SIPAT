<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h4 fw-semibold mb-1">Master Desa</h1>
        <small class="text-muted">Tambah dan kelola daftar desa/kelurahan.</small>
    </div>
</div>

<div class="row g-3">
    <div class="col-lg-5">
        <div class="card border-0 fancy-card">
            <div class="card-body">
                <form method="post" action="<?= base_url('master/desa') ?>">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label class="form-label">Kecamatan</label>
                        <select name="kecamatan_id" class="form-select" required>
                            <option value="">- pilih kecamatan -</option>
                            <?php foreach ($kecamatanList ?? [] as $kecamatan) : ?>
                                <option value="<?= esc($kecamatan['id']) ?>"><?= esc($kecamatan['nama']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jenis</label>
                        <select name="jenis" class="form-select" required>
                            <option value="">- pilih jenis -</option>
                            <option value="Desa">Desa</option>
                            <option value="Kelurahan">Kelurahan</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Desa/Kelurahan</label>
                        <input type="text" name="nama" class="form-control" required>
                    </div>
                    <button class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-7">
        <div class="card border-0 fancy-card">
            <div class="card-body">
                <form method="post" action="<?= base_url('master/desa/bulk-kecamatan') ?>" id="bulkDesaForm" class="row g-2 align-items-end mb-3">
                    <?= csrf_field() ?>
                    <div class="col-md-7">
                        <label class="form-label">Kecamatan (Bulk)</label>
                        <select name="kecamatan_id" class="form-select" required>
                            <option value="">- pilih kecamatan -</option>
                            <?php foreach ($kecamatanList ?? [] as $kecamatan) : ?>
                                <option value="<?= esc($kecamatan['id']) ?>"><?= esc($kecamatan['nama']) ?></option>
                            <?php endforeach; ?>
                        </select>
                        <small class="text-muted">Centang desa yang ingin diperbarui. Dipilih: <span id="bulkDesaCount">0</span></small>
                    </div>
                    <div class="col-md-5">
                        <button class="btn btn-outline-primary w-100" id="bulkDesaSubmit">Terapkan ke yang dipilih</button>
                    </div>
                </form>
                <form method="get" class="row g-2 align-items-end mb-3">
                    <div class="col-md-4">
                        <label class="form-label">Filter Kecamatan</label>
                        <select name="kecamatan_id" class="form-select">
                            <option value="">- semua kecamatan -</option>
                            <?php foreach ($kecamatanList ?? [] as $kecamatan) : ?>
                                <option value="<?= esc($kecamatan['id']) ?>" <?= ((string) ($filters['kecamatan_id'] ?? '') === (string) $kecamatan['id']) ? 'selected' : '' ?>>
                                    <?= esc($kecamatan['nama']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Filter Jenis</label>
                        <select name="jenis" class="form-select">
                            <option value="">- semua jenis -</option>
                            <option value="Desa" <?= ($filters['jenis'] ?? '') === 'Desa' ? 'selected' : '' ?>>Desa</option>
                            <option value="Kelurahan" <?= ($filters['jenis'] ?? '') === 'Kelurahan' ? 'selected' : '' ?>>Kelurahan</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Cari</label>
                        <input type="text" name="q" class="form-control" placeholder="Nama/Kecamatan" value="<?= esc($filters['q'] ?? '') ?>">
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-outline-secondary w-100">Filter</button>
                    </div>
                </form>
                <div class="table-responsive">
                    <table class="table align-middle mb-0 table-premium">
                        <thead>
                            <tr>
                                <th>
                                    <input type="checkbox" id="desaCheckAll" class="form-check-input">
                                </th>
                                <th>ID</th>
                                <th>Kecamatan</th>
                                <th>Jenis</th>
                                <th>Nama</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($rows as $row) : ?>
                                <tr>
                                    <td>
                                        <input type="checkbox" name="ids[]" value="<?= esc($row['id']) ?>" form="bulkDesaForm" class="form-check-input desa-check">
                                    </td>
                                    <td><?= esc($row['id']) ?></td>
                                    <td><?= esc($row['kecamatan_nama'] ?? '-') ?></td>
                                    <td><?= esc($row['jenis'] ?? '-') ?></td>
                                    <td><?= esc($row['nama']) ?></td>
                                    <td class="text-end">
                                        <a href="<?= base_url('master/desa/' . $row['id'] . '/edit') ?>" class="btn btn-sm btn-outline-primary">Edit</a>
                                        <form method="post" action="<?= base_url('master/desa/delete/' . $row['id']) ?>" data-confirm="Hapus desa ini?">
                                            <?= csrf_field() ?>
                                            <button class="btn btn-sm btn-outline-danger">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
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
        const checkAll = document.getElementById('desaCheckAll');
        if (!checkAll) return;
        const checks = Array.from(document.querySelectorAll('.desa-check'));
        const bulkForm = document.getElementById('bulkDesaForm');
        const bulkSubmit = document.getElementById('bulkDesaSubmit');
        const bulkCount = document.getElementById('bulkDesaCount');
        const bulkSelect = bulkForm ? bulkForm.querySelector('select[name="kecamatan_id"]') : null;

        const updateBulkState = () => {
            const selected = checks.filter(cb => cb.checked).length;
            if (bulkCount) bulkCount.textContent = selected.toString();
            if (bulkSubmit) {
                const hasTarget = bulkSelect && bulkSelect.value;
                bulkSubmit.disabled = selected === 0 || !hasTarget;
            }
        };

        checkAll.addEventListener('change', () => {
            checks.forEach(cb => { cb.checked = checkAll.checked; });
            updateBulkState();
        });

        checks.forEach(cb => cb.addEventListener('change', updateBulkState));
        if (bulkSelect) bulkSelect.addEventListener('change', updateBulkState);
        updateBulkState();
    });
</script>
<?= $this->endSection() ?>
