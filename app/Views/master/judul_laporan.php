<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h4 fw-semibold mb-1">Master Judul Laporan</h1>
        <small class="text-muted">Kelola daftar judul laporan yang bisa dipilih di halaman laporan.</small>
    </div>
</div>

<div class="row g-3">
    <div class="col-lg-5">
        <div class="card border-0 fancy-card">
            <div class="card-body">
                <form method="post" action="<?= base_url('master/judul-laporan') ?>">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label class="form-label">Judul Laporan</label>
                        <input type="text" name="judul" class="form-control" placeholder="Contoh: Laporan Aset Tanah Sudah Bersertifikat" required>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" name="aktif" id="aktifJudul" value="1" checked>
                        <label class="form-check-label" for="aktifJudul">Aktif</label>
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
                                <th>Judul</th>
                                <th>Status</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($rows as $row) : ?>
                                <tr>
                                    <td><?= esc($row['id']) ?></td>
                                    <td><?= esc($row['judul']) ?></td>
                                    <td>
                                        <span class="badge text-bg-<?= !empty($row['aktif']) ? 'success' : 'secondary' ?>">
                                            <?= !empty($row['aktif']) ? 'Aktif' : 'Nonaktif' ?>
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <a href="<?= base_url('master/judul-laporan/' . $row['id'] . '/edit') ?>" class="btn btn-sm btn-outline-primary">Edit</a>
                                        <form method="post" action="<?= base_url('master/judul-laporan/delete/' . $row['id']) ?>" data-confirm="Hapus judul laporan ini?">
                                            <?= csrf_field() ?>
                                            <button class="btn btn-sm btn-outline-danger">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            <?php if (empty($rows)) : ?>
                                <tr>
                                    <td colspan="4" class="text-center text-muted">Belum ada judul laporan.</td>
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
