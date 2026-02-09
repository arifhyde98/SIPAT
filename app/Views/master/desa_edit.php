<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h4 fw-semibold mb-1">Edit Desa</h1>
        <small class="text-muted">Perbarui nama desa/kelurahan.</small>
    </div>
</div>

<div class="card border-0 fancy-card">
    <div class="card-body">
        <form method="post" action="<?= base_url('master/desa/' . $row['id']) ?>">
            <?= csrf_field() ?>
            <div class="mb-3">
                <label class="form-label">Kecamatan</label>
                <select name="kecamatan_id" class="form-select" required>
                    <option value="">- pilih kecamatan -</option>
                    <?php foreach ($kecamatanList ?? [] as $kecamatan) : ?>
                        <option value="<?= esc($kecamatan['id']) ?>" <?= (int) $row['kecamatan_id'] === (int) $kecamatan['id'] ? 'selected' : '' ?>>
                            <?= esc($kecamatan['nama']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Jenis</label>
                <?php $jenis = $row['jenis'] ?? 'Kelurahan'; ?>
                <select name="jenis" class="form-select" required>
                    <option value="Desa" <?= $jenis === 'Desa' ? 'selected' : '' ?>>Desa</option>
                    <option value="Kelurahan" <?= $jenis === 'Kelurahan' ? 'selected' : '' ?>>Kelurahan</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Nama Desa/Kelurahan</label>
                <input type="text" name="nama" class="form-control" value="<?= esc($row['nama']) ?>" required>
            </div>
            <div class="d-flex gap-2">
                <button class="btn btn-primary">Simpan</button>
                <a href="<?= base_url('master/desa') ?>" class="btn btn-light">Batal</a>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
