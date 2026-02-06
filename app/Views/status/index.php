<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h4 fw-semibold mb-1">Master Status Proses</h1>
        <small class="text-muted">Urutan & warna status</small>
    </div>
    <a href="<?= base_url('status/create') ?>" class="btn btn-primary">Tambah Status</a>
</div>

<div class="card">
    <div class="card-body">
        <?php if (empty($status)) : ?>
            <p class="text-muted mb-0">Belum ada status.</p>
        <?php else : ?>
            <div class="table-responsive">
                <table class="table align-middle mb-0 js-datatable">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Urutan</th>
                        <th>Warna</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($status as $row) : ?>
                        <tr>
                            <td><?= esc($row['nama_status']) ?></td>
                            <td><?= esc($row['urutan']) ?></td>
                            <td><span class="badge bg-<?= esc($row['warna'] ?? 'secondary') ?>"><?= esc($row['warna'] ?? '-') ?></span></td>
                            <td class="text-end">
                                <div class="btn-group gap-1" role="group">
                                    <a href="<?= base_url('status/' . $row['id_status'] . '/edit') ?>" class="btn btn-xs btn-warning">
                                        <i class="bi bi-pencil-square me-1"></i>Edit
                                    </a>
                                    <form action="<?= base_url('status/' . $row['id_status']) ?>" method="post" class="d-inline">
                                        <?= csrf_field() ?>
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button type="submit" class="btn btn-xs btn-danger" onclick="return confirm('Hapus status ini?')">
                                            <i class="bi bi-trash3 me-1"></i>Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>
<?= $this->endSection() ?>
