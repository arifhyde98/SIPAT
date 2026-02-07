<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h4 fw-semibold mb-1">Edit Kepala Desa</h1>
        <small class="text-muted">Perbarui data kepala desa.</small>
    </div>
</div>

<div class="card border-0 fancy-card">
    <div class="card-body">
        <form method="post" action="<?= base_url('master/kepala-desa/' . $row['id']) ?>">
            <?= csrf_field() ?>
            <div class="mb-3">
                <label class="form-label">Desa</label>
                <select name="desa_id" class="form-select" required>
                    <option value="">- pilih -</option>
                    <?php foreach ($desaList as $desa) : ?>
                        <option value="<?= esc($desa['id']) ?>" <?= (int) $row['desa_id'] === (int) $desa['id'] ? 'selected' : '' ?>>
                            <?= esc($desa['nama']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Nama Kepala Desa</label>
                <input type="text" name="nama" class="form-control" value="<?= esc($row['nama']) ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">NIP (opsional)</label>
                <input type="text" name="nip" class="form-control" value="<?= esc($row['nip'] ?? '') ?>">
            </div>
            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" name="aktif" id="aktifKepalaEdit" <?= $row['aktif'] ? 'checked' : '' ?>>
                <label class="form-check-label" for="aktifKepalaEdit">Aktif</label>
            </div>
            <div class="d-flex gap-2">
                <button class="btn btn-primary">Simpan</button>
                <a href="<?= base_url('master/kepala-desa') ?>" class="btn btn-light">Batal</a>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
