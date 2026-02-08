<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h4 fw-semibold mb-1">Edit Kecamatan</h1>
        <small class="text-muted">Perbarui nama kecamatan.</small>
    </div>
</div>

<div class="card border-0 fancy-card">
    <div class="card-body">
        <form method="post" action="<?= base_url('master/kecamatan/' . $row['id']) ?>">
            <?= csrf_field() ?>
            <div class="mb-3">
                <label class="form-label">Nama Kecamatan</label>
                <input type="text" name="nama" class="form-control" value="<?= esc($row['nama']) ?>" required>
            </div>
            <div class="d-flex gap-2">
                <button class="btn btn-primary">Simpan</button>
                <a href="<?= base_url('master/kecamatan') ?>" class="btn btn-light">Batal</a>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
