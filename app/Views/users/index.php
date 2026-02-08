<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h4 fw-semibold mb-1">Manajemen User</h1>
        <small class="text-muted">Kelola akun dan peran</small>
    </div>
    <a
        href="<?= base_url('users/create') ?>"
        data-modal-user
        data-modal-url="<?= base_url('users/create/modal') ?>"
        class="btn btn-primary"
    >Tambah User</a>
</div>

<div class="card">
    <div class="card-body">
        <?php if (empty($users)) : ?>
            <p class="text-muted mb-0">Belum ada user.</p>
        <?php else : ?>
            <div class="table-responsive">
                <table class="table align-middle mb-0 js-datatable">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>OPD</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user) : ?>
                        <tr>
                            <td><?= esc($user['nama']) ?></td>
                            <td><?= esc($user['email']) ?></td>
                            <td><?= esc($user['role']) ?></td>
                            <td><?= esc($user['opd'] ?? '-') ?></td>
                            <td class="text-end">
                                <div class="btn-group gap-1" role="group">
                                    <a
                                        href="<?= base_url('users/' . $user['id_user'] . '/edit') ?>"
                                        data-modal-user
                                        data-modal-url="<?= base_url('users/' . $user['id_user'] . '/edit/modal') ?>"
                                        class="btn btn-xs btn-warning"
                                    >
                                        <i class="bi bi-pencil-square me-1"></i>Edit
                                    </a>
                                    <form action="<?= base_url('users/' . $user['id_user']) ?>" method="post" class="d-inline">
                                        <?= csrf_field() ?>
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button type="submit" class="btn btn-xs btn-danger" onclick="return confirm('Hapus user ini?')">
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
<div class="modal fade modal-modern" id="modalUser" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content"></div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const modalEl = document.getElementById('modalUser');
        if (!modalEl || typeof bootstrap === 'undefined') return;
        const modal = new bootstrap.Modal(modalEl);

        document.querySelectorAll('[data-modal-user]').forEach(function (link) {
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
