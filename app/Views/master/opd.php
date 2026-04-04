<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h4 fw-semibold mb-1">Master OPD</h1>
        <small class="text-muted">Tambah dan kelola daftar OPD.</small>
    </div>
</div>

<div class="row g-3">
    <div class="col-lg-5">
        <div class="card border-0 fancy-card">
            <div class="card-body">
                <form method="post" action="<?= base_url('master/opd') ?>">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label class="form-label">Nama OPD</label>
                        <input type="text" name="nama" class="form-control" required>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" name="aktif" id="aktifOpd" value="1" checked>
                        <label class="form-check-label" for="aktifOpd">Aktif</label>
                    </div>
                    <button class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-7">
        <div class="card border-0 fancy-card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table align-middle mb-0 table-premium">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama OPD</th>
                                <th>Status</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($rows as $row) : ?>
                                <tr>
                                    <td><?= esc($row['id']) ?></td>
                                    <td><?= esc($row['nama']) ?></td>
                                    <td>
                                        <span class="badge text-bg-<?= !empty($row['aktif']) ? 'success' : 'secondary' ?>">
                                            <?= !empty($row['aktif']) ? 'Aktif' : 'Nonaktif' ?>
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <a href="<?= base_url('master/opd/' . $row['id'] . '/edit') ?>" class="btn btn-sm btn-outline-primary">Edit</a>
                                        <form method="post" action="<?= base_url('master/opd/delete/' . $row['id']) ?>" data-confirm="Hapus OPD ini?">
                                            <?= csrf_field() ?>
                                            <button class="btn btn-sm btn-outline-danger">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            <?php if (empty($rows)) : ?>
                                <tr>
                                    <td colspan="4" class="text-center text-muted">Belum ada data OPD.</td>
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
