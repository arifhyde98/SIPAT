<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h4 fw-semibold mb-1">Edit OPD</h1>
        <small class="text-muted">Perbarui data OPD.</small>
    </div>
</div>

<div class="card border-0 fancy-card">
    <div class="card-body">
        <form method="post" action="<?= base_url('master/opd/' . $row['id']) ?>">
            <?= csrf_field() ?>
            <div class="mb-3">
                <label class="form-label">Nama OPD</label>
                <input type="text" name="nama" class="form-control" value="<?= esc($row['nama']) ?>" required>
            </div>
            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" name="aktif" id="aktifOpdEdit" value="1" <?= !empty($row['aktif']) ? 'checked' : '' ?>>
                <label class="form-check-label" for="aktifOpdEdit">Aktif</label>
            </div>
            <div class="d-flex gap-2">
                <button class="btn btn-primary">Simpan Perubahan</button>
                <a href="<?= base_url('master/opd') ?>" class="btn btn-outline-secondary">Kembali</a>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
