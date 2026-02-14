<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mt-4 mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= esc($title) ?></h1>
        <button type="button" class="btn btn-primary rounded-pill" data-bs-toggle="modal" data-bs-target="#modalAdd">
            <i class="bi bi-plus-lg me-1"></i> Tambah Item
        </button>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 5%;">No</th>
                            <th>Label Ceklist</th>
                            <th style="width: 15%;">Status</th>
                            <th style="width: 15%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($items)): ?>
                            <tr>
                                <td colspan="4" class="text-center text-muted py-3">Belum ada data item pengamanan.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($items as $i => $item) : ?>
                                <tr>
                                    <td><?= $i + 1 ?></td>
                                    <td><?= esc($item['label']) ?></td>
                                    <td>
                                        <?php if ($item['is_active']): ?>
                                            <span class="badge bg-success rounded-pill">Aktif</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary rounded-pill">Non-Aktif</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary rounded-pill btn-edit"
                                            data-id="<?= $item['id'] ?>"
                                            data-label="<?= esc($item['label']) ?>"
                                            data-active="<?= $item['is_active'] ?>"
                                            data-bs-toggle="modal" data-bs-target="#modalEdit">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                        <form action="<?= base_url('master/pengamanan/delete/' . $item['id']) ?>" method="post" class="d-inline" onsubmit="return confirm('Yakin hapus item ini? Data checklist pada aset yang sudah ada akan ikut terhapus.');">
                                            <?= csrf_field() ?>
                                            <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill">
                                                <i class="bi bi-trash3"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Add -->
<div class="modal fade" id="modalAdd" tabindex="-1">
    <div class="modal-dialog">
        <form action="<?= base_url('master/pengamanan') ?>" method="post">
            <?= csrf_field() ?>
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Item</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Label Ceklist</label>
                        <input type="text" name="label" class="form-control" required placeholder="Contoh: Pagar Keliling">
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="is_active" id="addActive" value="1" checked>
                        <label class="form-check-label" for="addActive">Aktif</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary rounded-pill">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="modalEdit" tabindex="-1">
    <div class="modal-dialog">
        <form id="formEdit" action="" method="post">
            <?= csrf_field() ?>
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Item</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Label Ceklist</label>
                        <input type="text" name="label" id="editLabel" class="form-control" required>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="is_active" id="editActive" value="1">
                        <label class="form-check-label" for="editActive">Aktif</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary rounded-pill">Update</button>
                </div>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const editBtns = document.querySelectorAll('.btn-edit');
        const formEdit = document.getElementById('formEdit');
        const editLabel = document.getElementById('editLabel');
        const editActive = document.getElementById('editActive');

        editBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.dataset.id;
                const label = this.dataset.label;
                const active = this.dataset.active;

                formEdit.action = '<?= base_url('master/pengamanan') ?>/' + id;
                editLabel.value = label;
                editActive.checked = active == 1;
            });
        });
    });
</script>
<?= $this->endSection() ?>