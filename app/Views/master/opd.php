<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-start mb-4 flex-wrap gap-2">
    <div>
        <div style="font-size:0.75rem;color:#94a3b8;margin-bottom:4px;">
            <a href="<?= base_url('dashboard') ?>" style="color:#94a3b8;text-decoration:none;">Dashboard</a>
            <span class="mx-1">›</span> Master Data <span class="mx-1">›</span> OPD
        </div>
        <h1 class="h4 fw-bold text-dark mb-1">Master OPD</h1>
        <small class="text-muted">Tambah dan kelola daftar OPD yang digunakan dalam sistem.</small>
    </div>
</div>

<div class="row g-3">
    <div class="col-lg-5">
        <div class="card border-0 fancy-card h-100">
            <div class="card-body p-4">
                <h6 class="fw-bold text-dark mb-3 d-flex align-items-center gap-2">
                    <i class="bi bi-buildings text-primary"></i> Tambah OPD Baru
                </h6>
                <form method="post" action="<?= base_url('master/opd') ?>">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label class="form-label">Nama OPD</label>
                        <input type="text" name="nama" class="form-control" placeholder="Contoh: Dinas Pendidikan" required>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" name="aktif" id="aktifOpd" value="1" checked>
                        <label class="form-check-label" for="aktifOpd">Aktif</label>
                    </div>
                    <button class="btn btn-primary w-100">
                        <i class="bi bi-save2 me-1"></i> Simpan OPD
                    </button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-7">
        <div class="card border-0 fancy-card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table align-middle mb-0 table-premium">
                        <thead>
                            <tr>
                                <th style="padding:14px 20px;">ID</th>
                                <th style="padding:14px 20px;">Nama OPD</th>
                                <th style="padding:14px 20px;">Status</th>
                                <th style="padding:14px 20px;"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($rows as $row) : ?>
                                <tr>
                                    <td style="padding:12px 20px;" class="text-muted fw-medium" style="font-size:0.8rem;"><?= esc($row['id']) ?></td>
                                    <td style="padding:12px 20px;" class="fw-semibold text-dark"><?= esc($row['nama']) ?></td>
                                    <td style="padding:12px 20px;">
                                        <span class="badge rounded-pill text-bg-<?= !empty($row['aktif']) ? 'success' : 'secondary' ?>" style="font-size:0.72rem;">
                                            <?= !empty($row['aktif']) ? 'Aktif' : 'Nonaktif' ?>
                                        </span>
                                    </td>
                                    <td style="padding:12px 20px;" class="text-end">
                                        <a href="<?= base_url('master/opd/' . $row['id'] . '/edit') ?>" class="btn btn-sm btn-outline-primary me-1">
                                            <i class="bi bi-pencil me-1"></i>Edit
                                        </a>
                                        <form method="post" action="<?= base_url('master/opd/delete/' . $row['id']) ?>" data-confirm="Hapus OPD ini?" class="d-inline">
                                            <?= csrf_field() ?>
                                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash me-1"></i>Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            <?php if (empty($rows)) : ?>
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4">
                                        <i class="bi bi-inbox d-block mb-2" style="font-size:1.5rem;opacity:0.4;"></i>
                                        Belum ada data OPD.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
