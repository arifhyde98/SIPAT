<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 fw-bold text-dark mb-1">
            <i class="bi bi-people text-primary me-2"></i> Manajemen User & Hak Akses
        </h1>
        <p class="text-muted small mb-0">Kelola akun pengguna, peran sistem, dan pembatasan wewenang OPD</p>
    </div>
    <a
        href="<?= base_url('users/create') ?>"
        data-modal-user
        data-modal-url="<?= base_url('users/create/modal') ?>"
        class="btn btn-primary rounded-pill fw-semibold px-4 shadow-sm"
    ><i class="bi bi-person-plus-fill me-2"></i>Tambah User Baru</a>
</div>

<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
    <div class="card-body p-0">
        <?php if (empty($users)) : ?>
            <div class="text-center py-5">
                <i class="bi bi-people text-muted fs-1 mb-2 d-block"></i>
                <h5 class="fw-bold text-dark">Belum ada akun pengguna.</h5>
                <p class="text-muted mb-0">Silakan tambahkan pengguna pertama Anda.</p>
            </div>
        <?php else : ?>
            <div class="table-responsive">
                <table class="table table-premium table-hover align-middle mb-0 js-datatable">
                <thead class="bg-light">
                    <tr>
                        <th width="25%">Nama User</th>
                        <th width="25%">Email</th>
                        <th width="20%">Role / Peran</th>
                        <th width="20%">OPD Instansi</th>
                        <th width="10%" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user) : 
                        $role = $user['role'] ?? 'Pengelola Aset';
                        $badgeClass = 'bg-secondary text-secondary';
                        if ($role === 'Admin') $badgeClass = 'bg-danger text-danger';
                        elseif ($role === 'Pengelola Aset') $badgeClass = 'bg-primary text-primary';
                        elseif ($role === 'Petugas Lapangan') $badgeClass = 'bg-warning text-warning-emphasis';
                        elseif ($role === 'Pimpinan') $badgeClass = 'bg-info text-info';
                    ?>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 34px; height: 34px; font-size: 0.85rem;">
                                        <?= strtoupper(substr($user['nama'], 0, 1)) ?>
                                    </div>
                                    <span class="fw-bold text-dark"><?= esc($user['nama']) ?></span>
                                </div>
                            </td>
                            <td class="text-secondary font-monospace"><?= esc($user['email']) ?></td>
                            <td>
                                <span class="badge <?= $badgeClass ?> bg-opacity-10 border border-opacity-25 rounded-pill px-3 py-1.5 fw-medium" style="font-size: 0.75rem;">
                                    <i class="bi bi-shield-lock me-1"></i> <?= esc($role) ?>
                                </span>
                            </td>
                            <td class="text-secondary"><?= esc($user['opd'] ?? '-') ?></td>
                            <td class="text-center">
                                <div class="btn-group gap-1" role="group">
                                    <a
                                        href="<?= base_url('users/' . $user['id_user'] . '/edit') ?>"
                                        data-modal-user
                                        data-modal-url="<?= base_url('users/' . $user['id_user'] . '/edit/modal') ?>"
                                        class="btn-icon-action btn-icon-warning"
                                        title="Edit User"
                                    >
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="<?= base_url('users/' . $user['id_user']) ?>" method="post" class="d-inline m-0" data-confirm="Hapus user ini?">
                                        <?= csrf_field() ?>
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button type="submit" class="btn-icon-action btn-icon-danger" title="Hapus User">
                                            <i class="bi bi-trash"></i>
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
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden"></div>
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
                content.innerHTML = '<div class="modal-body p-4 text-center"><div class="spinner-border text-primary me-2"></div>Memuat...</div>';
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
