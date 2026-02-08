<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h4 fw-semibold mb-1">Edit Camat</h1>
        <small class="text-muted">Perbarui data camat.</small>
    </div>
</div>

<div class="card border-0 fancy-card">
    <div class="card-body">
        <form method="post" action="<?= base_url('master/camat/' . $row['id']) ?>">
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
                <label class="form-label">Nama Camat</label>
                <input type="text" name="nama" class="form-control" value="<?= esc($row['nama']) ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">NIP (opsional)</label>
                <input type="text" name="nip" class="form-control" value="<?= esc($row['nip'] ?? '') ?>">
            </div>
            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" name="aktif" id="aktifCamatEdit" <?= $row['aktif'] ? 'checked' : '' ?>>
                <label class="form-check-label" for="aktifCamatEdit">Aktif</label>
            </div>
            <div class="d-flex gap-2">
                <button class="btn btn-primary">Simpan</button>
                <a href="<?= base_url('master/camat') ?>" class="btn btn-light">Batal</a>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
