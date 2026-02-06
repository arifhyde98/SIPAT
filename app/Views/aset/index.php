<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<style>
    .aset-hero {
        background: linear-gradient(135deg, rgba(13, 110, 253, 0.22), rgba(13, 110, 253, 0.06));
        border: 1px solid rgba(13, 110, 253, 0.2);
        border-radius: 16px;
        padding: 16px 18px;
    }
    .aset-card {
        border: 0;
        box-shadow: 0 10px 24px rgba(15, 23, 42, 0.08);
        border-radius: 16px;
    }
    .aset-card .card-body {
        padding: 18px;
    }
    .aset-table thead th {
        background: rgba(13, 110, 253, 0.06);
        border-bottom: 1px solid rgba(13, 110, 253, 0.15);
        color: #0f2a4f;
        font-weight: 700;
        font-size: 0.78rem;
        text-transform: uppercase;
        letter-spacing: 0.04em;
    }
    .aset-table tbody tr:hover {
        background: rgba(13, 110, 253, 0.03);
    }
    .aset-toolbar .btn {
        border-radius: 10px;
    }
    .aset-filter .form-control,
    .aset-filter .form-select {
        border-radius: 10px;
    }
    .aset-badge-soft {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 0.2rem 0.6rem;
        border-radius: 999px;
        background: rgba(13, 110, 253, 0.2);
        color: #084298;
        font-weight: 600;
        font-size: 0.75rem;
    }
</style>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div class="aset-hero">
        <div class="d-flex align-items-center gap-2 mb-1">
            <span class="aset-badge-soft">
                <i class="bi bi-buildings"></i>
                SIPAT
            </span>
        </div>
        <h1 class="h5 fw-semibold mb-1">Daftar Aset</h1>
        <small class="text-muted">Monitoring status pensertifikatan</small>
    </div>
    <?php if (in_array(session()->get('user_role'), ['Admin', 'Pengelola Aset'], true)) : ?>
        <div class="d-flex gap-2 aset-toolbar">
            <a href="<?= base_url('aset/export/print') ?>" class="btn btn-outline-secondary" target="_blank" rel="noopener">Print / PDF</a>
            <a href="<?= base_url('aset/export/csv') ?>" class="btn btn-outline-success">Export CSV</a>
            <a href="<?= base_url('aset/import') ?>" class="btn btn-outline-primary">Import Aset</a>
            <a href="<?= base_url('aset/create') ?>" class="btn btn-primary">Tambah Aset</a>
        </div>
    <?php endif; ?>
</div>

<div class="card aset-card mb-4">
    <div class="card-body">
        <form method="get" class="row g-2 align-items-end aset-filter">
        <div class="col-md-3">
            <label class="form-label">OPD</label>
            <select name="opd" class="form-select">
                <option value="">Semua OPD</option>
                <?php foreach ($opdList as $opd) : ?>
                    <option value="<?= esc($opd) ?>" <?= ($filters['opd'] === $opd) ? 'selected' : '' ?>><?= esc($opd) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label">Status</label>
            <select name="status" class="form-select">
                <option value="">Semua Status</option>
                <?php foreach ($statusList as $status) : ?>
                    <option value="<?= esc($status['id_status']) ?>" <?= ($filters['status'] == $status['id_status']) ? 'selected' : '' ?>>
                        <?= esc($status['nama_status']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label">Tanggal Perolehan</label>
            <input type="date" name="tanggal_perolehan" class="form-control" value="<?= esc($filters['tanggal_perolehan'] ?? '') ?>">
        </div>
        <div class="col-md-3">
            <label class="form-label">Cari</label>
            <input type="text" name="q" class="form-control" placeholder="Kode/Nama/OPD" value="<?= esc($filters['q'] ?? '') ?>">
        </div>
        <div class="col-md-3">
            <button class="btn btn-outline-secondary w-100" type="submit">Filter</button>
        </div>
        </form>
    </div>
</div>

<div class="card aset-card">
    <div class="card-body">
        <?php if (empty($data)) : ?>
            <p class="text-muted mb-0">Belum ada data aset.</p>
        <?php else : ?>
            <div class="table-responsive">
                <table class="table align-middle mb-0 table-premium aset-table">
                <thead>
                    <tr>
                        <th class="d-none">Kode</th>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Penggunaan</th>
                        <th>OPD</th>
                        <th>Luas</th>
                        <th>Harga Perolehan</th>
                        <th>Status Saat Ini</th>
                        <th>Durasi (hari)</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; ?>
                    <?php foreach ($data as $row) : ?>
                        <tr>
                            <td class="d-none"><?= esc($row['kode_aset']) ?></td>
                            <td><?= $no++ ?></td>
                            <td><?= esc($row['nama_aset']) ?></td>
                            <td><?= esc($row['peruntukan'] ?? '-') ?></td>
                            <td><?= esc($row['opd'] ?? '-') ?></td>
                            <td><?= esc($row['luas']) ?></td>
                            <td>
                                <?php if (!empty($row['harga_perolehan'])) : ?>
                                    <?= esc(number_format((float) $row['harga_perolehan'], 2, '.', ',')) ?>
                                <?php else : ?>
                                    -
                                <?php endif; ?>
                            </td>
                            <td><span class="badge bg-<?= esc($row['warna_status']) ?>"><?= esc($row['status_terkini']) ?></span></td>
                            <td><?= esc($row['durasi_hari']) ?></td>
                            <td class="text-end">
                                <div class="btn-group gap-1" role="group">
                                    <a href="<?= base_url('aset/' . $row['id_aset']) ?>" class="btn btn-xs btn-primary">
                                        <i class="bi bi-eye me-1"></i>Detail
                                    </a>
                                    <?php if (in_array(session()->get('user_role'), ['Admin', 'Pengelola Aset'], true)) : ?>
                                        <a href="<?= base_url('aset/' . $row['id_aset'] . '/edit') ?>" class="btn btn-xs btn-warning">
                                            <i class="bi bi-pencil-square me-1"></i>Edit
                                        </a>
                                        <form action="<?= base_url('aset/' . $row['id_aset']) ?>" method="post" class="d-inline">
                                            <?= csrf_field() ?>
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button type="submit" class="btn btn-xs btn-danger" onclick="return confirm('Hapus aset ini?')">
                                                <i class="bi bi-trash3 me-1"></i>Hapus
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                </table>
            </div>
            <?php if (isset($pager)) : ?>
                <div class="d-flex justify-content-center mt-3">
                    <?= $pager->links('aset', 'bootstrap_full') ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>
<?= $this->endSection() ?>
