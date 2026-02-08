<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h4 fw-semibold mb-1">Master Kecamatan</h1>
        <small class="text-muted">Tambah dan kelola daftar kecamatan.</small>
    </div>
</div>

<div class="row g-3">
    <div class="col-lg-5">
        <div class="card border-0 fancy-card">
            <div class="card-body">
                <form method="post" action="<?= base_url('master/kecamatan') ?>">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label class="form-label">Nama Kecamatan</label>
                        <input type="text" name="nama" class="form-control" required>
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
                                <th>Nama</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($rows as $row) : ?>
                                <tr>
                                    <td><?= esc($row['id']) ?></td>
                                    <td><?= esc($row['nama']) ?></td>
                                    <td class="text-end">
                                        <a href="<?= base_url('master/kecamatan/' . $row['id'] . '/edit') ?>" class="btn btn-sm btn-outline-primary">Edit</a>
                                        <form method="post" action="<?= base_url('master/kecamatan/delete/' . $row['id']) ?>" onsubmit="return confirm('Hapus kecamatan ini?')">
                                            <?= csrf_field() ?>
                                            <button class="btn btn-sm btn-outline-danger">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
