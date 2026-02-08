<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h4 fw-semibold mb-1">Master Status Proses</h1>
        <small class="text-muted">Urutan & warna status</small>
    </div>
    <a
        href="<?= base_url('status/create') ?>"
        data-modal-status
        data-modal-url="<?= base_url('status/create/modal') ?>"
        class="btn btn-primary"
    >Tambah Status</a>
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
                                    <a
                                        href="<?= base_url('status/' . $row['id_status'] . '/edit') ?>"
                                        data-modal-status
                                        data-modal-url="<?= base_url('status/' . $row['id_status'] . '/edit/modal') ?>"
                                        class="btn btn-xs btn-warning"
                                    >
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
<div class="modal fade modal-modern" id="modalStatus" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content"></div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const modalEl = document.getElementById('modalStatus');
        if (!modalEl || typeof bootstrap === 'undefined') return;
        const modal = new bootstrap.Modal(modalEl);

        document.querySelectorAll('[data-modal-status]').forEach(function (link) {
            link.addEventListener('click', async function (e) {
                e.preventDefault();
                const url = link.getAttribute('data-modal-url') || link.getAttribute('href');
                const fallback = link.getAttribute('href');
                const content = modalEl.querySelector('.modal-content');
                content.innerHTML = '<div class="modal-body p-4">Memuat...</div>';
                try {
                    const res = await fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
                    if (!res.ok) {
                        window.location.href = fallback;
                        return;
                    }
                    const html = await res.text();
                    content.innerHTML = html;
                    modal.show();
                } catch (err) {
                    window.location.href = fallback;
                }
            });
        });
    });
</script>
<?= $this->endSection() ?>
