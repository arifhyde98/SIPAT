<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

    body { font-family: 'Inter', sans-serif; background-color: #f8fafc; }

    /* ── Page Header ── */
    .page-header-bar {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }
    .page-header-bar h1 {
        font-size: 1.35rem;
        font-weight: 700;
        color: #0f172a;
        margin: 0 0 2px;
    }
    .page-header-bar .subtitle {
        font-size: 0.82rem;
        color: #64748b;
        font-weight: 400;
    }
    .page-header-bar .breadcrumb-trail {
        font-size: 0.75rem;
        color: #94a3b8;
        margin-bottom: 4px;
    }
    .page-header-bar .breadcrumb-trail a { color: #94a3b8; text-decoration: none; }
    .page-header-bar .breadcrumb-trail a:hover { color: #1E5EFF; }

    /* ── Action Buttons ── */
    .btn-action-primary {
        background: #1E5EFF;
        color: #fff;
        border: none;
        border-radius: 10px;
        padding: 8px 18px;
        font-size: 0.875rem;
        font-weight: 600;
        box-shadow: 0 2px 8px rgba(30,94,255,0.18);
        transition: all 0.2s ease;
    }
    .btn-action-primary:hover { background: #1846C7; color: #fff; transform: translateY(-1px); box-shadow: 0 4px 12px rgba(30,94,255,0.28); }
    .btn-action-secondary {
        background: #fff;
        color: #475569;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 8px 16px;
        font-size: 0.875rem;
        font-weight: 500;
        box-shadow: 0 1px 4px rgba(0,0,0,0.04);
        transition: all 0.2s ease;
    }
    .btn-action-secondary:hover { background: #f8fafc; color: #0f172a; border-color: #cbd5e1; transform: translateY(-1px); }

    /* ── Filter Card ── */
    .filter-card {
        background: #fff;
        border-radius: 16px;
        padding: 1.25rem 1.5rem;
        box-shadow: 0 2px 10px rgba(15,23,42,0.05);
        border: 1px solid #f1f5f9;
        margin-bottom: 1.25rem;
    }

    /* ── Form Controls ── */
    .form-control-soft, .form-select-soft {
        background-color: #f8fafc;
        border: 1.5px solid #e2e8f0;
        border-radius: 10px;
        font-size: 0.875rem;
        transition: all 0.2s;
        color: #334155;
    }
    .form-control-soft:focus, .form-select-soft:focus {
        background-color: #fff;
        border-color: #1E5EFF;
        box-shadow: 0 0 0 3px rgba(30,94,255,0.1);
    }

    /* ── Search Box ── */
    .search-wrapper { position: relative; }
    .search-wrapper .search-icon {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 0.9rem;
        pointer-events: none;
    }
    .search-wrapper .form-control-soft { padding-left: 38px; }

    /* ── Multi-select Status ── */
    .ts-wrapper.multi .ts-control {
        border-radius: 10px !important;
        border: 1.5px solid #e2e8f0 !important;
        background: #f8fafc !important;
        padding: 6px 10px !important;
        min-height: 40px;
        box-shadow: none !important;
        font-size: 0.875rem;
    }
    .ts-wrapper.multi .ts-control:focus-within,
    .ts-wrapper.focus .ts-control {
        border-color: #1E5EFF !important;
        box-shadow: 0 0 0 3px rgba(30,94,255,0.1) !important;
        background: #fff !important;
    }
    .ts-wrapper .ts-dropdown { border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: 0 8px 24px rgba(15,23,42,0.1); font-size: 0.875rem; }
    .ts-wrapper .ts-dropdown .option { padding: 8px 14px; }
    .ts-wrapper .ts-dropdown .option.active { background: #eff6ff; color: #1E5EFF; }
    .ts-wrapper.multi .ts-control .item { background: #eff6ff; color: #1E5EFF; border-radius: 6px; padding: 2px 8px; font-size: 0.8rem; font-weight: 500; border: none; }
    .ts-wrapper.multi .ts-control .item .remove { color: #93c5fd; margin-left: 4px; }

    /* ── Table ── */
    .table-container {
        border-radius: 16px;
        box-shadow: 0 2px 12px rgba(15,23,42,0.05);
        background: #fff;
        overflow: hidden;
        border: 1px solid #f1f5f9;
    }
    .table-responsive { max-height: 72vh; overflow-y: auto; overflow-x: auto; }
    .aset-table { margin-bottom: 0; }
    .aset-table thead th {
        background: #f8fafc;
        color: #64748b;
        font-weight: 600;
        font-size: 0.72rem;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        padding: 12px 18px;
        border-bottom: 1.5px solid #f1f5f9;
        white-space: nowrap;
        position: sticky;
        top: 0;
        z-index: 10;
        background-clip: padding-box;
    }
    .aset-table tbody td {
        padding: 12px 18px;
        vertical-align: middle;
        border-bottom: 1px solid #f8fafc;
        color: #334155;
        font-size: 0.875rem;
        transition: background 0.15s;
    }
    .aset-table tbody tr:nth-child(even) td { background-color: #fafbfc; }
    .aset-table tbody tr:hover td { background-color: #f0f7ff !important; }
    .aset-table tbody tr:last-child td { border-bottom: none; }

    /* ── Badges ── */
    .badge-status {
        display: inline-flex;
        align-items: center;
        padding: 4px 10px;
        border-radius: 50rem;
        font-size: 0.72rem;
        font-weight: 600;
        letter-spacing: 0.01em;
        white-space: nowrap;
    }
    .badge-status.bg-success  { background-color: #dcfce7 !important; color: #15803d !important; }
    .badge-status.bg-warning  { background-color: #fef9c3 !important; color: #92400e !important; }
    .badge-status.bg-danger   { background-color: #fee2e2 !important; color: #b91c1c !important; }
    .badge-status.bg-info     { background-color: #e0f2fe !important; color: #0369a1 !important; }
    .badge-status.bg-primary  { background-color: #dbeafe !important; color: #1d4ed8 !important; }
    .badge-status.bg-secondary{ background-color: #f1f5f9 !important; color: #475569 !important; }

    /* ── Dropdown Action ── */
    .btn-icon {
        width: 32px; height: 32px; padding: 0;
        display: inline-flex; align-items: center; justify-content: center;
        border-radius: 8px; color: #94a3b8; background: transparent; border: none;
        transition: all 0.2s;
    }
    .btn-icon:hover, .btn-icon[aria-expanded="true"] { background-color: #f1f5f9; color: #1E5EFF; }
    .dropdown-menu {
        border: 1px solid #e2e8f0;
        box-shadow: 0 8px 24px rgba(15,23,42,0.1);
        border-radius: 12px;
        font-size: 0.875rem;
        padding: 6px;
    }
    .dropdown-item {
        padding: 8px 14px; color: #475569; border-radius: 8px;
        margin-bottom: 2px; transition: all 0.15s;
    }
    .dropdown-item:hover { background-color: #f1f5f9; color: #0f172a; }
    .dropdown-item.text-danger:hover { background-color: #fee2e2; color: #b91c1c; }

    /* ── Empty State ── */
    .empty-state-block {
        padding: 3rem 2rem;
        text-align: center;
        background: #fff;
        border-radius: 16px;
        border: 1.5px dashed #e2e8f0;
    }
    .empty-state-block .es-icon { font-size: 2.5rem; color: #cbd5e1; margin-bottom: 1rem; display: block; }
    .empty-state-block h6 { font-weight: 600; color: #334155; margin-bottom: 6px; }
    .empty-state-block p { font-size: 0.85rem; color: #94a3b8; margin: 0; }

    /* ── Filter Summary Chips ── */
    .filter-count-badge {
        display: inline-flex;
        align-items: center;
        background: #eff6ff;
        color: #1E5EFF;
        border-radius: 50rem;
        font-size: 0.72rem;
        font-weight: 600;
        padding: 2px 8px;
        margin-left: 6px;
        vertical-align: middle;
    }
</style>
<?php
    // Hitung filter aktif untuk chip counter
    $activeFilterCount = 0;
    if (!empty($filters['opd'])) $activeFilterCount++;
    if (!empty($filters['status'])) $activeFilterCount++;
    if (!empty($filters['tanggal_perolehan'])) $activeFilterCount++;
    if (!empty($filters['q'])) $activeFilterCount++;
?>

<!-- ── Page Header ── -->
<div class="page-header-bar">
    <div>
        <div class="breadcrumb-trail">
            <a href="<?= base_url('dashboard') ?>">Dashboard</a>
            <span class="mx-1">›</span>
            <span>Aset Tanah</span>
        </div>
        <h1>Daftar Aset
            <?php if ($activeFilterCount > 0): ?>
                <span class="filter-count-badge"><?= $activeFilterCount ?> filter</span>
            <?php endif; ?>
        </h1>
        <span class="subtitle">Monitoring status pensertifikatan tanah daerah</span>
    </div>
    <?php if (in_array(session()->get('user_role'), ['Admin', 'Pengelola Aset'], true)) : ?>
        <div class="d-flex gap-2 flex-wrap align-items-center mt-1">
            <div class="dropdown">
                <button type="button" class="btn-action-secondary dropdown-toggle d-flex align-items-center gap-2"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-download"></i> Export
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="<?= base_url('aset/export/print') . ($exportQueryString ?? '') ?>" target="_blank">
                        <i class="bi bi-file-pdf me-2 text-danger"></i>Preview PDF</a></li>
                    <li><a class="dropdown-item" href="<?= base_url('aset/export/pdf') . ($exportQueryString ?? '') ?>">
                        <i class="bi bi-download me-2 text-danger"></i>Download PDF</a></li>
                    <li><a class="dropdown-item" href="<?= base_url('aset/export/csv') . ($exportQueryString ?? '') ?>">
                        <i class="bi bi-file-earmark-spreadsheet me-2 text-success"></i>CSV</a></li>
                </ul>
            </div>
            <a href="<?= base_url('aset/import') ?>" class="btn-action-secondary d-flex align-items-center gap-2 text-decoration-none">
                <i class="bi bi-upload"></i> Import
            </a>
            <button type="button" id="btnCekGanda" class="btn-action-secondary d-flex align-items-center gap-2">
                <i class="bi bi-shield-exclamation text-warning"></i> Cek Kode Ganda
            </button>
            <a href="<?= base_url('aset/create') ?>" class="btn-action-primary d-flex align-items-center gap-2 text-decoration-none">
                <i class="bi bi-plus-lg"></i> Tambah Aset
            </a>
        </div>
    <?php endif; ?>
</div>

<!-- ── Filter Card ── -->
<div class="filter-card">
    <form method="get" id="filterForm">
        <div class="row g-3 align-items-end">
            <div class="col-md-auto">
                <label class="form-label small fw-semibold text-secondary mb-1">OPD</label>
                <select name="opd" class="form-select form-select-soft" style="min-width: 180px;">
                    <option value="">Semua OPD</option>
                    <option value="KOSONG" <?= ($filters['opd'] === 'KOSONG') ? 'selected' : '' ?>>[Tanpa OPD / Kosong]</option>
                    <?php foreach ($opdList as $opd) : ?>
                        <option value="<?= esc($opd) ?>" <?= ($filters['opd'] === $opd) ? 'selected' : '' ?>><?= esc($opd) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-auto">
                <label class="form-label small fw-semibold text-secondary mb-1">
                    Status <span class="filter-count-badge ms-0" style="background:#fef9c3;color:#92400e;">multi</span>
                </label>
                <!-- Multi-select status: name="status[]" agar controller menerima array -->
                <select id="statusMultiSelect" name="status[]" multiple placeholder="Semua Status..." style="min-width: 220px;">
                    <?php foreach ($statusList as $status) : ?>
                        <option value="<?= esc($status['id_status']) ?>"
                            <?= in_array((string)$status['id_status'], (array)($filters['status'] ?? []), true) ? 'selected' : '' ?>>
                            <?= esc($status['nama_status']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-auto">
                <label class="form-label small fw-semibold text-secondary mb-1">Tanggal Perolehan</label>
                <input type="date" name="tanggal_perolehan" class="form-control form-control-soft"
                    value="<?= esc($filters['tanggal_perolehan'] ?? '') ?>">
            </div>
            <div class="col">
                <label class="form-label small fw-semibold text-secondary mb-1">Pencarian</label>
                <div class="search-wrapper">
                    <i class="bi bi-search search-icon"></i>
                    <input type="text" name="q" class="form-control form-control-soft"
                        placeholder="Cari nama, kode aset, OPD..."
                        value="<?= esc($filters['q'] ?? '') ?>">
                </div>
            </div>
            <div class="col-auto d-flex gap-2">
                <button class="btn-action-primary px-4" type="submit">
                    <i class="bi bi-funnel me-1"></i> Filter
                </button>
                <?php if ($activeFilterCount > 0): ?>
                    <a href="<?= base_url('aset') ?>" class="btn-action-secondary d-flex align-items-center gap-1 text-decoration-none"
                        title="Reset semua filter">
                        <i class="bi bi-x-circle"></i>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </form>
</div>

<?php if (empty($data)) : ?>
    <!-- ── Empty State ── -->
    <div class="empty-state-block">
        <span class="es-icon"><i class="bi bi-folder2-open"></i></span>
        <h6>Tidak ada aset ditemukan</h6>
        <p>Coba ubah filter atau kata kunci pencarian Anda,<br>atau tambahkan aset baru ke dalam sistem.</p>
        <?php if (in_array(session()->get('user_role'), ['Admin', 'Pengelola Aset'], true)) : ?>
            <a href="<?= base_url('aset/create') ?>" class="btn-action-primary d-inline-flex align-items-center gap-2 text-decoration-none mt-3">
                <i class="bi bi-plus-lg"></i> Tambah Aset Pertama
            </a>
        <?php endif; ?>
    </div>
<?php else : ?>
    <div class="table-container">
        <div class="table-responsive">
            <table class="table align-middle mb-0 aset-table">
                <thead>
                    <tr>
                        <th class="d-none">Kode</th>
                        <th style="width:50px;">No</th>
                        <th>Nama Aset</th>
                        <th>Penggunaan</th>
                        <th>OPD</th>
                        <th class="text-end">Luas (m²)</th>
                        <th class="text-end">Harga Perolehan</th>
                        <th>Status Saat Ini</th>
                        <th class="text-center" style="width: 60px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $currentPage = isset($pager) ? (int) $pager->getCurrentPage('aset') : 1;
                    $perPageVal  = isset($perPage) ? (int) $perPage : count($data);
                    $no = (($currentPage - 1) * max($perPageVal, 1)) + 1;
                    ?>
                    <?php foreach ($data as $row) : ?>
                        <tr>
                            <td class="d-none"><?= esc($row['kode_aset']) ?></td>
                            <td class="text-muted fw-medium" style="font-size:0.8rem;"><?= $no++ ?></td>
                            <td class="fw-semibold text-dark"><?= esc($row['nama_aset']) ?></td>
                            <td class="text-secondary"><?= esc($row['peruntukan'] ?? '-') ?></td>
                            <td>
                                <?php if (!empty($row['opd'])): ?>
                                    <span class="text-secondary" style="font-size:0.82rem;"><?= esc($row['opd']) ?></span>
                                <?php else: ?>
                                    <span class="text-muted fst-italic" style="font-size:0.8rem;">-</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-end font-monospace" style="font-size:0.82rem;"><?= esc($row['luas']) ?></td>
                            <td class="text-end font-monospace" style="font-size:0.82rem;">
                                <?php if (!empty($row['harga_perolehan'])) : ?>
                                    <?= esc(number_format((float) $row['harga_perolehan'], 2, '.', ',')) ?>
                                <?php else : ?>
                                    <span class="text-muted">-</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <span class="badge-status bg-<?= esc($row['warna_status']) ?>">
                                    <?= esc($row['status_terkini']) ?>
                                </span>
                            </td>
                            <td class="text-center">
                                <div class="dropdown">
                                    <button class="btn btn-icon" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                            <a class="dropdown-item" href="<?= base_url('aset/' . $row['id_aset']) ?>"
                                                data-modal-aset data-modal-url="<?= base_url('aset/' . $row['id_aset'] . '/modal') ?>">
                                                <i class="bi bi-eye me-2 text-primary"></i>Detail
                                            </a>
                                        </li>
                                        <?php if (in_array(session()->get('user_role'), ['Admin', 'Pengelola Aset'], true)) : ?>
                                            <li>
                                                <a class="dropdown-item" href="<?= base_url('aset/' . $row['id_aset'] . '/edit') . ($exportQueryString ?? '') ?>">
                                                    <i class="bi bi-pencil me-2 text-warning"></i>Edit
                                                </a>
                                            </li>
                                            <li><hr class="dropdown-divider my-1"></li>
                                            <li>
                                                <form action="<?= base_url('aset/' . $row['id_aset']) ?>" method="post" data-confirm="Hapus aset ini?">
                                                    <?= csrf_field() ?>
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <button type="submit" class="dropdown-item text-danger">
                                                        <i class="bi bi-trash me-2"></i>Hapus
                                                    </button>
                                                </form>
                                            </li>
                                        <?php endif; ?>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php if (isset($pager)) : ?>
        <div class="d-flex justify-content-center mt-4">
            <?= $pager->links('aset', 'bootstrap_full') ?>
        </div>
    <?php endif; ?>
<?php endif; ?>

<div class="modal fade modal-modern" id="modalRemote" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content"></div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<!-- TomSelect untuk multi-select status -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.bootstrap5.min.css">
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // ── TomSelect Multi-select Status ──
        const statusEl = document.getElementById('statusMultiSelect');
        if (statusEl) {
            new TomSelect(statusEl, {
                plugins: ['remove_button', 'checkbox_options'],
                placeholder: 'Semua Status...',
                maxOptions: 50,
                closeAfterSelect: false,
                hideSelected: false,
                render: {
                    option: function(data, escape) {
                        return '<div class="d-flex align-items-center gap-2"><span>' + escape(data.text) + '</span></div>';
                    }
                }
            });
        }

        // ── Flash Alerts ──
        const params = new URLSearchParams(window.location.search);
        const created  = params.get('created');
        const updated  = params.get('updated');
        const deleted  = params.get('deleted');
        const imported = params.get('imported');
        const showAlert = (text) => {
            if (typeof Swal !== 'undefined') {
                Swal.fire({ icon: 'success', title: 'Berhasil', text, timer: 1800, showConfirmButton: false });
            }
        };
        if (created  === '1') { showAlert('Aset tanah berhasil ditambahkan.'); params.delete('created'); }
        if (updated  === '1') { showAlert('Aset tanah berhasil diperbarui.'); params.delete('updated'); }
        if (deleted  === '1') { showAlert('Aset tanah berhasil dihapus.'); params.delete('deleted'); }
        if (imported === '1') { showAlert('Import aset selesai.'); params.delete('imported'); }
        if (created === '1' || updated === '1' || deleted === '1' || imported === '1') {
            const newUrl = window.location.pathname + (params.toString() ? '?' + params.toString() : '');
            window.history.replaceState({}, document.title, newUrl);
        }

        // ── Cek Kode Ganda Handler ──
        const btnCekGanda = document.getElementById('btnCekGanda');
        if (btnCekGanda) {
            btnCekGanda.addEventListener('click', async function () {
                btnCekGanda.disabled = true;
                const originalHtml = btnCekGanda.innerHTML;
                btnCekGanda.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Memproses...';
                
                try {
                    const res = await fetch('<?= base_url('aset/cek-ganda') ?>', {
                        headers: { 'X-Requested-With': 'XMLHttpRequest' }
                    });
                    if (!res.ok) throw new Error('Network response was not ok');
                    const result = await res.json();
                    
                    if (result.success) {
                        if (result.count === 0) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Verifikasi Kode Aset',
                                text: 'Hebat! Tidak ditemukan kode aset ganda di database.',
                                confirmButtonColor: '#1E5EFF'
                            });
                        } else {
                            let rows = '';
                            result.data.forEach(item => {
                                rows += `<tr>
                                    <td class="font-monospace text-start fw-bold" style="font-size: 0.8rem;">${sipatEscape(item.kode_aset)}</td>
                                    <td class="text-secondary text-start" style="font-size: 0.8rem;">${sipatEscape(item.jumlah)} kali</td>
                                    <td class="text-muted text-start" style="font-size: 0.75rem; max-width: 250px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;" title="${sipatEscape(item.daftar_aset)}">${sipatEscape(item.daftar_aset)}</td>
                                </tr>`;
                            });
                            
                            Swal.fire({
                                icon: 'warning',
                                title: 'Verifikasi Kode Aset',
                                html: `
                                    <p class="mb-3 text-start">Ditemukan <strong>${result.count}</strong> kode aset ganda di database:</p>
                                    <div class="table-responsive" style="max-height: 250px;">
                                        <table class="table table-sm table-bordered align-middle">
                                            <thead class="table-light">
                                                <tr>
                                                    <th class="text-start">Kode</th>
                                                    <th class="text-start">Jumlah</th>
                                                    <th class="text-start">Daftar Aset</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                ${rows}
                                            </tbody>
                                        </table>
                                    </div>
                                `,
                                confirmButtonColor: '#1E5EFF',
                                confirmButtonText: 'Tutup'
                            });
                        }
                    }
                } catch (err) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Kesalahan',
                        text: 'Gagal memproses verifikasi kode aset ganda.'
                    });
                } finally {
                    btnCekGanda.disabled = false;
                    btnCekGanda.innerHTML = originalHtml;
                }
            });
        }
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const modalEl = document.getElementById('modalRemote');
        if (!modalEl || typeof bootstrap === 'undefined') return;
        const modal = new bootstrap.Modal(modalEl);

        document.querySelectorAll('[data-modal-aset]').forEach(function (link) {
            link.addEventListener('click', async function (e) {
                e.preventDefault();
                const url      = link.getAttribute('data-modal-url') || link.getAttribute('href');
                const fallback = link.getAttribute('href');
                const content  = modalEl.querySelector('.modal-content');
                content.innerHTML = '<div class="modal-body p-4">Memuat...</div>';
                try {
                    const res = await fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
                    if (!res.ok) { window.location.href = fallback; return; }
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
