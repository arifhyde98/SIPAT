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
                        <small class="text-muted">Centang desa yang ingin diperbarui.</small>
                    </div>
                    <div class="col-md-5">
                        <button class="btn btn-outline-primary w-100">Terapkan ke yang dipilih</button>
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
                                    <td><?= esc($row['nama']) ?></td>
                                    <td class="text-end">
                                        <a href="<?= base_url('master/desa/' . $row['id'] . '/edit') ?>" class="btn btn-sm btn-outline-primary">Edit</a>
                                        <form method="post" action="<?= base_url('master/desa/delete/' . $row['id']) ?>" onsubmit="return confirm('Hapus desa ini?')">
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
        checkAll.addEventListener('change', () => {
            checks.forEach(cb => { cb.checked = checkAll.checked; });
        });
    });
</script>
<?= $this->endSection() ?>
