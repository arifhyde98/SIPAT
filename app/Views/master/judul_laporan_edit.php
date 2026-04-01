<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h4 fw-semibold mb-1">Edit Judul Laporan</h1>
        <small class="text-muted">Perbarui data judul laporan.</small>
    </div>
</div>

<div class="card border-0 fancy-card">
    <div class="card-body">
        <form method="post" action="<?= base_url('master/judul-laporan/' . $row['id']) ?>">
            <?= csrf_field() ?>
            <div class="mb-3">
                <label class="form-label">Judul Laporan</label>
                <input type="text" name="judul" class="form-control" value="<?= esc($row['judul']) ?>" required>
            </div>
            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" name="aktif" id="aktifJudulEdit" value="1" <?= !empty($row['aktif']) ? 'checked' : '' ?>>
                <label class="form-check-label" for="aktifJudulEdit">Aktif</label>
            </div>
            <div class="d-flex gap-2">
                <button class="btn btn-primary">Simpan Perubahan</button>
                <a href="<?= base_url('master/judul-laporan') ?>" class="btn btn-outline-secondary">Kembali</a>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
