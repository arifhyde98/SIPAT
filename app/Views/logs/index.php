<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<style>
    .log-badge {
        display: inline-flex;
        align-items: center;
        padding: 4px 10px;
        border-radius: 50rem;
        font-size: 0.72rem;
        font-weight: 600;
        letter-spacing: 0.01em;
        text-transform: uppercase;
    }
    .log-badge.bg-create { background-color: #dcfce7 !important; color: #15803d !important; }
    .log-badge.bg-update { background-color: #fef9c3 !important; color: #92400e !important; }
    .log-badge.bg-delete { background-color: #fee2e2 !important; color: #b91c1c !important; }
    .log-badge.bg-other { background-color: #f1f5f9 !important; color: #475569 !important; }
</style>

<!-- ── Page Header ── -->
<div class="page-header-global mb-4">
    <div>
        <h1 class="h4 fw-semibold mb-1">Log Aktivitas</h1>
        <small class="subtitle">Catatan riwayat aksi dan perubahan data sistem oleh pengguna</small>
    </div>
    <?php if (!empty($logs)) : ?>
        <form action="<?= base_url('logs/clear') ?>" method="post" data-confirm="Apakah Anda yakin ingin menghapus semua log aktivitas? Tindakan ini tidak dapat dibatalkan.">
            <?= csrf_field() ?>
            <button type="submit" class="btn btn-outline-danger d-flex align-items-center gap-2">
                <i class="bi bi-trash3"></i> Bersihkan Log
            </button>
        </form>
    <?php endif; ?>
</div>

<!-- ── Filter Card ── -->
<div class="card mb-4">
    <div class="card-body">
        <form method="get" id="filterForm">
            <div class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label class="form-label">Pengguna</label>
                    <select name="user_id" class="form-select">
                        <option value="">Semua Pengguna</option>
                        <?php foreach ($users as $u) : ?>
                            <option value="<?= esc($u['id_user']) ?>" <?= ($filters['user_id'] === (string)$u['id_user']) ? 'selected' : '' ?>>
                                <?= esc($u['nama']) ?> (<?= esc($u['role']) ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Aksi</label>
                    <select name="action" class="form-select">
                        <option value="">Semua Aksi</option>
                        <?php foreach ($distinctActions as $act) : ?>
                            <option value="<?= esc($act) ?>" <?= ($filters['action'] === $act) ? 'selected' : '' ?>>
                                <?= esc(ucfirst($act)) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Entitas</label>
                    <select name="entity" class="form-select">
                        <option value="">Semua Entitas</option>
                        <?php foreach ($distinctEntities as $ent) : ?>
                            <option value="<?= esc($ent) ?>" <?= ($filters['entity'] === $ent) ? 'selected' : '' ?>>
                                <?= esc($ent) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Tanggal Mulai</label>
                    <input type="date" name="date_start" class="form-control" value="<?= esc($filters['date_start'] ?? '') ?>">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Tanggal Akhir</label>
                    <input type="date" name="date_end" class="form-control" value="<?= esc($filters['date_end'] ?? '') ?>">
                </div>
                <div class="col-md-9">
                    <label class="form-label">Cari Data / IP / User Agent</label>
                    <input type="text" name="q" class="form-control" placeholder="Cari IP address, ID target, isi data lama/baru..." value="<?= esc($filters['q'] ?? '') ?>">
                </div>
                <div class="col-md-3 d-flex gap-2">
                    <button class="btn btn-primary w-100" type="submit">
                        <i class="bi bi-funnel me-1"></i> Filter
                    </button>
                    <?php if (array_filter($filters)): ?>
                        <a href="<?= base_url('logs') ?>" class="btn btn-outline-secondary" title="Reset Filter">
                            <i class="bi bi-arrow-counterclockwise"></i>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- ── Logs Table ── -->
<div class="card">
    <div class="card-body p-0">
        <?php if (empty($logs)) : ?>
            <div class="p-5 text-center text-muted">
                <i class="bi bi-journal-x fs-2 mb-2 d-block"></i>
                <p class="mb-0">Tidak ada log aktivitas ditemukan.</p>
            </div>
        <?php else : ?>
            <div class="table-responsive">
                <table class="table table-premium align-middle mb-0">
                    <thead>
                        <tr>
                            <th style="width: 60px;">No</th>
                            <th style="width: 170px;">Waktu</th>
                            <th>Pengguna</th>
                            <th style="width: 110px;">Aksi</th>
                            <th>Entitas</th>
                            <th style="width: 100px;">ID Target</th>
                            <th>IP Address</th>
                            <th class="text-end" style="width: 100px;">Detail</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $currentPage = $pager->getCurrentPage('logs');
                        $perPage = $pager->getPerPage('logs');
                        $no = (($currentPage - 1) * $perPage) + 1;
                        ?>
                        <?php foreach ($logs as $log) : ?>
                            <?php
                            $badgeClass = 'bg-other';
                            if ($log['action'] === 'create') {
                                $badgeClass = 'bg-create';
                            } elseif ($log['action'] === 'update') {
                                $badgeClass = 'bg-update';
                            } elseif ($log['action'] === 'delete') {
                                $badgeClass = 'bg-delete';
                            }
                            ?>
                            <tr>
                                <td class="text-muted fw-medium"><?= $no++ ?></td>
                                <td class="text-secondary" style="font-size: 0.82rem;">
                                    <?= esc(date('d M Y H:i:s', strtotime($log['created_at']))) ?>
                                </td>
                                <td>
                                    <?php if ($log['user_name']) : ?>
                                        <span class="fw-semibold text-dark"><?= esc($log['user_name']) ?></span>
                                    <?php else : ?>
                                        <span class="text-muted fst-italic">Sistem / Tamu</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="log-badge <?= $badgeClass ?>">
                                        <?= esc($log['action']) ?>
                                    </span>
                                </td>
                                <td>
                                    <code class="text-primary" style="font-size: 0.8rem;"><?= esc($log['entity']) ?></code>
                                </td>
                                <td>
                                    <span class="font-monospace text-secondary" style="font-size: 0.82rem;"><?= esc($log['entity_id'] ?? '-') ?></span>
                                </td>
                                <td>
                                    <span class="font-monospace" style="font-size: 0.82rem;"><?= esc($log['ip_address'] ?? '-') ?></span>
                                </td>
                                <td class="text-end">
                                    <a
                                        href="<?= base_url('logs/detail/' . $log['id']) ?>"
                                        data-modal-log
                                        data-modal-url="<?= base_url('logs/detail/' . $log['id']) ?>"
                                        class="btn-icon-action btn-icon-info"
                                        title="Detail Log"
                                    >
                                        <i class="bi bi-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Pagination -->
<?php if (!empty($logs) && isset($pager)) : ?>
    <div class="d-flex justify-content-center mt-4">
        <?= $pager->links('logs', 'bootstrap_full') ?>
    </div>
<?php endif; ?>

<!-- Modern Modal for Details -->
<div class="modal fade modal-modern" id="modalLogDetail" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content"></div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const modalEl = document.getElementById('modalLogDetail');
        if (!modalEl || typeof bootstrap === 'undefined') return;
        const modal = new bootstrap.Modal(modalEl);

        document.querySelectorAll('[data-modal-log]').forEach(function (link) {
            link.addEventListener('click', async function (e) {
                e.preventDefault();
                const url = link.getAttribute('data-modal-url') || link.getAttribute('href');
                const fallback = link.getAttribute('href');
                const content = modalEl.querySelector('.modal-content');
                content.innerHTML = '<div class="modal-body p-4 text-center"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div><div class="mt-2 text-muted">Memuat detail log...</div></div>';
                modal.show();
                try {
                    const res = await fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
                    if (!res.ok) {
                        window.location.href = fallback;
                        return;
                    }
                    const html = await res.text();
                    content.innerHTML = html;
                } catch (err) {
                    window.location.href = fallback;
                }
            });
        });
    });
</script>
<?= $this->endSection() ?>
