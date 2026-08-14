<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 fw-bold text-dark mb-1">
            <i class="bi bi-tags text-primary me-2"></i> Master Status Proses
        </h1>
        <p class="text-muted small mb-0">Kelola urutan dan visual warna untuk setiap tahapan proses sertifikasi aset</p>
    </div>
    <a
        href="<?= base_url('status/create') ?>"
        data-modal-status
        data-modal-url="<?= base_url('status/create/modal') ?>"
        class="btn btn-primary rounded-pill fw-semibold px-4 shadow-sm"
    ><i class="bi bi-plus-lg me-2"></i>Tambah Status</a>
</div>

<div class="card fancy-card border-0 shadow-sm">
    <div class="card-body p-0">
        <?php if (empty($status)) : ?>
            <div class="text-center py-5">
                <i class="bi bi-inboxes text-muted fs-1 mb-2 d-block"></i>
                <h5 class="fw-bold text-dark">Belum ada status.</h5>
                <p class="text-muted mb-0">Silakan tambahkan status proses pertama Anda.</p>
            </div>
        <?php else : ?>
            <div class="table-responsive">
                <table class="table table-premium table-hover align-middle mb-0 js-datatable">
                <thead class="bg-light">
                    <tr>
                        <th width="28%">Nama Status</th>
                        <th width="10%" class="text-center">Urutan</th>
                        <th width="25%">Kategori Dashboard</th>
                        <th width="25%">Preview Warna</th>
                        <th width="12%" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($status as $row) : 
                        $warna = $row['warna'] ?: 'secondary';
                        $catMap = [
                            'belum_diurus'  => ['label' => 'Belum Diurus / Diproses', 'class' => 'bg-secondary text-secondary'],
                            'proses'        => ['label' => 'Sedang Diproses', 'class' => 'bg-primary text-primary'],
                            'kendala'       => ['label' => 'Kendala / Sengketa', 'class' => 'bg-danger text-danger'],
                            'bersertifikat' => ['label' => 'Sudah Bersertifikat', 'class' => 'bg-success text-success'],
                        ];
                        $catKey = $row['kategori'] ?? 'proses';
                        $catInfo = $catMap[$catKey] ?? $catMap['proses'];
                    ?>
                        <tr>
                            <td>
                                <span class="fw-bold text-dark"><?= esc($row['nama_status']) ?></span>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-light text-dark border border-secondary border-opacity-25 rounded-circle fs-6 p-2" style="width:35px; height:35px; display:inline-flex; align-items:center; justify-content:center;">
                                    <?= esc($row['urutan']) ?>
                                </span>
                            </td>
                            <td>
                                <span class="badge <?= $catInfo['class'] ?> bg-opacity-10 border border-opacity-25 rounded-pill px-3 py-1.5 fw-medium" style="font-size: 0.75rem;">
                                    <i class="bi bi-tag-fill me-1"></i> <?= $catInfo['label'] ?>
                                </span>
                            </td>
                            <td>
                                <!-- Preview bagaimana badge status ini akan terlihat di aplikasi -->
                                <span class="badge bg-<?= esc($warna) ?> bg-opacity-10 text-<?= esc($warna) ?> border border-<?= esc($warna) ?> border-opacity-25 rounded-pill px-3 py-2">
                                    <?= esc($row['nama_status']) ?>
                                </span>
                                <small class="text-muted ms-2 font-monospace">(<?= esc($warna) ?>)</small>
                            </td>
                            <td class="text-center">
                                <div class="btn-group gap-2" role="group">
                                    <a
                                        href="<?= base_url('status/' . $row['id_status'] . '/edit') ?>"
                                        data-modal-status
                                        data-modal-url="<?= base_url('status/' . $row['id_status'] . '/edit/modal') ?>"
                                        class="btn btn-sm btn-outline-warning rounded-circle"
                                        title="Edit Status"
                                        style="width: 32px; height: 32px; padding: 0; display: inline-flex; align-items: center; justify-content: center;"
                                    >
                                        <i class="bi bi-pencil-fill"></i>
                                    </a>
                                    <form action="<?= base_url('status/' . $row['id_status']) ?>" method="post" class="d-inline" data-confirm="Hapus status ini?">
                                        <?= csrf_field() ?>
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-circle" title="Hapus Status" style="width: 32px; height: 32px; padding: 0; display: inline-flex; align-items: center; justify-content: center;">
                                            <i class="bi bi-trash3-fill"></i>
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
                    const res = await fetch(url, { 
                        headers: { 'X-Requested-With': 'XMLHttpRequest' },
                        cache: 'no-store'
                    });
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
