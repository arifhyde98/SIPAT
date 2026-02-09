<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h4 fw-semibold mb-1">Import Aset</h1>
        <small class="text-muted">Upload file CSV untuk input data kolektif</small>
    </div>
    <a href="<?= base_url('aset') ?>" class="btn btn-outline-secondary">Kembali</a>
</div>

<div class="card">
    <div class="card-body">
        <p class="mb-2">Unduh template (CSV):</p>
        <a href="<?= base_url('template-import-aset.csv') ?>" class="btn btn-sm btn-outline-primary mb-3">Download Template</a>
        <div class="small text-muted mb-3">
            Opsional kolom status proses: <code>status_proses</code>, <code>tgl_mulai</code>, <code>tgl_selesai</code>, <code>keterangan</code>.
            Nilai <code>status_proses</code> harus sama dengan nama status di Master Status.
        </div>

        <form action="<?= base_url('aset/import') ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <div class="mb-3">
                <label class="form-label">File CSV / Excel (.xlsx)</label>
                <input type="file" name="file" class="form-control" accept=".csv,.xlsx" required>
            </div>
            <button type="submit" class="btn btn-primary">Proses Import</button>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
