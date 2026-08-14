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
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        padding: 8px 12px;
        border-bottom: 1.5px solid #cbd5e1;
        white-space: nowrap;
        position: sticky;
        top: 0;
        z-index: 10;
        background-clip: padding-box;
    }
    .aset-table tbody td {
        padding: 8px 12px;
        vertical-align: middle;
        border-bottom: 1px solid #cbd5e1;
        color: #334155;
        font-size: 0.8rem;
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
    
    /* ── Inline Action Buttons ── */
    .btn-icon-action {
        width: 34px; height: 34px; padding: 0;
        display: inline-flex; align-items: center; justify-content: center;
        border-radius: 10px; border: none;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        text-decoration: none;
    }
    .btn-icon-primary {
        background-color: #e0e7ff; color: #4f46e5;
        box-shadow: 0 4px 10px rgba(79, 70, 229, 0.15);
    }
    .btn-icon-primary:hover {
        background-color: #4f46e5; color: #fff;
        box-shadow: 0 6px 14px rgba(79, 70, 229, 0.35);
        transform: translateY(-2px);
    }
    .btn-icon-warning {
        background-color: #fef3c7; color: #d97706;
        box-shadow: 0 4px 10px rgba(217, 119, 6, 0.15);
    }
    .btn-icon-warning:hover {
        background-color: #d97706; color: #fff;
        box-shadow: 0 6px 14px rgba(217, 119, 6, 0.35);
        transform: translateY(-2px);
    }
    .btn-icon-danger {
        background-color: #fee2e2; color: #dc2626;
        box-shadow: 0 4px 10px rgba(220, 38, 38, 0.15);
    }
    .btn-icon-danger:hover {
        background-color: #dc2626; color: #fff;
        box-shadow: 0 6px 14px rgba(220, 38, 38, 0.35);
        transform: translateY(-2px);
    }
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

    /* ── Bulk Floating Action Bar ── */
    .bulk-floating-bar {
        position: fixed;
        bottom: 24px;
        left: 50%;
        transform: translateX(-50%);
        z-index: 1050;
        background: #0f172a;
        color: #fff;
        padding: 10px 22px;
        border-radius: 50rem;
        box-shadow: 0 10px 30px rgba(15,23,42,0.3);
        min-width: 320px;
        max-width: 90vw;
        border: 1px solid #334155;
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .form-check-input:checked {
        background-color: #1E5EFF;
        border-color: #1E5EFF;
    }

    /* ── Penyesuaian Resolusi 1366x768 Laptop ── */
    @media screen and (max-width: 1440px), screen and (max-height: 850px) {
        .page-header-bar { margin-bottom: 0.75rem !important; }
        .page-header-bar h1 { font-size: 1.15rem !important; }
        .page-header-bar .subtitle { font-size: 0.78rem !important; }
        .btn-action-primary, .btn-action-secondary { padding: 5px 12px !important; font-size: 0.8rem !important; }
        .filter-card { padding: 0.85rem 1rem !important; margin-bottom: 0.85rem !important; }
        .form-control-soft, .form-select-soft { font-size: 0.8rem !important; padding: 4px 8px !important; }
        .aset-table thead th { padding: 6px 8px !important; font-size: 0.65rem !important; }
        .aset-table tbody td { padding: 5px 8px !important; font-size: 0.75rem !important; }
        .badge-status { font-size: 0.68rem !important; padding: 3px 8px !important; }
        .btn-icon-action { width: 28px; height: 28px; font-size: 0.75rem; }
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
            <button type="button" id="btnBulkStatusHeader" class="btn-action-secondary d-none align-items-center gap-2 text-primary border-primary bg-primary-subtle" data-bs-toggle="modal" data-bs-target="#modalBulkStatus">
                <i class="bi bi-ui-checks"></i> Ubah Status Massal (<span id="bulkCountHeader">0</span>)
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
        <div class="row g-2 align-items-end">
            <div class="col-auto">
                <label class="form-label small fw-semibold text-secondary mb-1">OPD</label>
                <select name="opd" class="form-select form-select-soft" style="width: 145px;">
                    <option value="">Semua OPD</option>
                    <option value="KOSONG" <?= ($filters['opd'] === 'KOSONG') ? 'selected' : '' ?>>[Tanpa OPD / Kosong]</option>
                    <?php foreach ($opdList as $opd) : ?>
                        <option value="<?= esc($opd) ?>" <?= ($filters['opd'] === $opd) ? 'selected' : '' ?>><?= esc($opd) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-auto">
                <label class="form-label small fw-semibold text-secondary mb-1">
                    Status <span class="filter-count-badge ms-0" style="background:#fef9c3;color:#92400e;">multi</span>
                </label>
                <select id="statusMultiSelect" name="status[]" multiple placeholder="Status..." style="width: 165px;">
                    <?php foreach ($statusList as $status) : ?>
                        <option value="<?= esc($status['id_status']) ?>"
                            <?= in_array((string)$status['id_status'], (array)($filters['status'] ?? []), true) ? 'selected' : '' ?>>
                            <?= esc($status['nama_status']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-auto">
                <label class="form-label small fw-semibold text-secondary mb-1">Tgl Perolehan</label>
                <input type="date" name="tanggal_perolehan" class="form-control form-control-soft" style="width: 135px;"
                    value="<?= esc($filters['tanggal_perolehan'] ?? '') ?>">
            </div>
            <div class="col-auto">
                <label class="form-label small fw-semibold text-secondary mb-1">Tampilkan</label>
                <select name="per_page" class="form-select form-select-soft" style="width: 115px;" onchange="this.form.submit()">
                    <option value="25" <?= ($perPageParam === '25' || empty($perPageParam)) ? 'selected' : '' ?>>25 hal</option>
                    <option value="50" <?= ($perPageParam === '50') ? 'selected' : '' ?>>50 hal</option>
                    <option value="100" <?= ($perPageParam === '100') ? 'selected' : '' ?>>100 hal</option>
                    <option value="250" <?= ($perPageParam === '250') ? 'selected' : '' ?>>250 hal</option>
                    <option value="all" <?= ($perPageParam === 'all') ? 'selected' : '' ?>>✨ Semua</option>
                </select>
            </div>
            <div class="col">
                <label class="form-label small fw-semibold text-secondary mb-1">
                    Pencarian Cepat <span id="searchResultCount" class="text-primary small fw-normal ms-1"></span>
                </label>
                <div class="search-wrapper">
                    <i class="bi bi-search search-icon"></i>
                    <input type="text" name="q" id="quickSearchInput" class="form-control form-control-soft"
                        placeholder="Ketik nama, NIBAR, OPD..."
                        value="<?= esc($filters['q'] ?? '') ?>" autocomplete="off">
                </div>
            </div>
            <div class="col-auto d-flex gap-1">
                <button class="btn-action-primary px-3" type="submit">
                    <i class="bi bi-funnel me-1"></i> Filter
                </button>
                <?php if ($activeFilterCount > 0): ?>
                    <a href="<?= base_url('aset') ?>" class="btn-action-secondary d-flex align-items-center gap-1 text-decoration-none px-2"
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
    <div class="table-container hide-on-mobile">
        <div class="table-responsive">
            <table class="table align-middle mb-0 aset-table">
                <thead>
                    <tr>
                        <?php if (in_array(session()->get('user_role'), ['Admin', 'Pengelola Aset'], true)) : ?>
                            <th class="text-center" style="width:40px;">
                                <input type="checkbox" id="checkAllAset" class="form-check-input" title="Pilih Semua">
                            </th>
                        <?php endif; ?>
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
                            <?php if (in_array(session()->get('user_role'), ['Admin', 'Pengelola Aset'], true)) : ?>
                                <td class="text-center">
                                    <input type="checkbox" class="form-check-input aset-checkbox" value="<?= $row['id_aset'] ?>">
                                </td>
                            <?php endif; ?>
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
                                <div class="d-flex justify-content-center gap-1">
                                    <a class="btn-icon-action btn-icon-primary" href="<?= base_url('aset/' . $row['id_aset']) ?>"
                                        data-modal-aset data-modal-url="<?= base_url('aset/' . $row['id_aset'] . '/modal') ?>" title="Detail">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <?php if (in_array(session()->get('user_role'), ['Admin', 'Pengelola Aset'], true)) : ?>
                                        <a class="btn-icon-action btn-icon-warning" href="<?= base_url('aset/' . $row['id_aset'] . '/edit') . ($exportQueryString ?? '') ?>" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="<?= base_url('aset/' . $row['id_aset']) ?>" method="post" data-confirm="Hapus aset ini?" class="m-0">
                                            <?= csrf_field() ?>
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button type="submit" class="btn-icon-action btn-icon-danger" title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Mobile Card View (<768px) -->
    <div class="mobile-card-view d-md-none">
        <?php foreach ($data as $row) : ?>
            <div class="mobile-data-card">
                <div class="mobile-card-header">
                    <div class="d-flex align-items-start gap-2">
                        <?php if (in_array(session()->get('user_role'), ['Admin', 'Pengelola Aset'], true)) : ?>
                            <input type="checkbox" class="form-check-input aset-checkbox mt-1" value="<?= $row['id_aset'] ?>">
                        <?php endif; ?>
                        <div>
                            <span class="mobile-card-code"><?= esc($row['kode_aset'] ?? 'ASET') ?></span>
                            <div class="mobile-card-title mt-1"><?= esc($row['nama_aset']) ?></div>
                        </div>
                    </div>
                    <span class="badge-status bg-<?= esc($row['warna_status']) ?>">
                        <?= esc($row['status_terkini']) ?>
                    </span>
                </div>
                <div class="mobile-card-subtitle">
                    <i class="bi bi-buildings text-muted me-1"></i>
                    <span><?= esc(!empty($row['opd']) ? $row['opd'] : 'Tanpa OPD') ?></span>
                </div>
                <div class="mobile-card-details">
                    <div class="mobile-card-detail-item">
                        <span class="mobile-card-detail-label">Penggunaan</span>
                        <span class="mobile-card-detail-val"><?= esc($row['peruntukan'] ?? '-') ?></span>
                    </div>
                    <div class="mobile-card-detail-item">
                        <span class="mobile-card-detail-label">Luas Tanah</span>
                        <span class="mobile-card-detail-val"><?= esc($row['luas']) ?> m²</span>
                    </div>
                </div>
                <div class="mobile-card-actions">
                    <div class="d-flex gap-2">
                        <a class="btn btn-sm btn-outline-primary" href="<?= base_url('aset/' . $row['id_aset']) ?>"
                           data-modal-aset data-modal-url="<?= base_url('aset/' . $row['id_aset'] . '/modal') ?>" title="Detail">
                            <i class="bi bi-eye"></i> Detail
                        </a>
                        <?php if (in_array(session()->get('user_role'), ['Admin', 'Pengelola Aset'], true)) : ?>
                            <a class="btn btn-sm btn-outline-warning" href="<?= base_url('aset/' . $row['id_aset'] . '/edit') . ($exportQueryString ?? '') ?>" title="Edit">
                                <i class="bi bi-pencil"></i> Edit
                            </a>
                            <form action="<?= base_url('aset/' . $row['id_aset']) ?>" method="post" data-confirm="Hapus aset ini?" class="m-0">
                                <?= csrf_field() ?>
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                    <i class="bi bi-trash"></i> Hapus
                                </button>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <?php if (isset($pager)) : ?>
        <div class="d-flex justify-content-center mt-4">
            <?= $pager->links('aset', 'bootstrap_full') ?>
        </div>
    <?php endif; ?>
<?php endif; ?>

<!-- ── Bulk Floating Action Bar ── -->
<div id="bulkFloatingBar" class="bulk-floating-bar d-none">
    <div class="d-flex align-items-center justify-content-between gap-3">
        <div class="d-flex align-items-center gap-2 text-white fw-semibold" style="font-size: 0.875rem;">
            <i class="bi bi-check-circle-fill text-warning fs-5"></i>
            <span><strong id="bulkCountFloat">0</strong> aset dipilih</span>
        </div>
        <div class="d-flex align-items-center gap-2">
            <button type="button" class="btn btn-sm btn-light fw-medium text-dark rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#modalBulkStatus">
                <i class="bi bi-pencil-square me-1 text-primary"></i> Ubah Status Massal
            </button>
            <button type="button" id="btnCancelBulk" class="btn btn-sm btn-outline-light rounded-circle p-0 d-flex align-items-center justify-content-center" style="width: 28px; height: 28px;">
                <i class="bi bi-x"></i>
            </button>
        </div>
    </div>
</div>

<!-- ── Modal Ubah Status Massal ── -->
<div class="modal fade modal-modern" id="modalBulkStatus" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="modal-header bg-primary-subtle border-bottom px-4 py-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 38px; height: 38px;">
                        <i class="bi bi-layers-fill fs-5"></i>
                    </div>
                    <div>
                        <h5 class="modal-title fw-bold text-dark mb-0">Ubah Status Massal (Bulk Update)</h5>
                        <small class="text-primary fw-medium">Pembaruan Riwayat Status Kolektif Aset</small>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('proses/bulk') ?>" method="post" id="formBulkStatus" onsubmit="handleFormSubmit(this)">
                <?= csrf_field() ?>
                <div id="bulkSelectedInputsContainer"></div>
                <div class="modal-body p-4">
                    <div class="alert alert-primary border-0 d-flex align-items-center gap-3 mb-3 p-3 rounded-3" style="font-size: 0.85rem;">
                        <i class="bi bi-info-circle-fill fs-4 text-primary"></i>
                        <div>Anda akan memperbarui status untuk <strong id="modalBulkCount" class="badge bg-primary fs-6 px-2 py-1 ms-1">0</strong> aset sekaligus.</div>
                    </div>

                    <div class="card bg-light border-0 rounded-3 p-3 mb-3">
                        <div class="mb-3">
                            <label class="form-label small fw-semibold text-secondary mb-1">Pilih Status Proses Baru <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-white text-muted"><i class="bi bi-tags"></i></span>
                                <select name="id_status" class="form-select form-select-soft" required>
                                    <option value="">-- Pilih Status Proses --</option>
                                    <?php if (!empty($allStatusList)): ?>
                                        <?php foreach ($allStatusList as $st): ?>
                                            <option value="<?= esc($st['id_status']) ?>"><?= esc($st['nama_status']) ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>

                        <div class="row g-2 mb-2">
                            <div class="col-6">
                                <label class="form-label small fw-semibold text-secondary mb-1">Tanggal Mulai</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white text-muted"><i class="bi bi-calendar-event"></i></span>
                                    <input type="date" name="tgl_mulai" class="form-control form-control-soft" value="<?= date('Y-m-d') ?>">
                                </div>
                            </div>
                            <div class="col-6">
                                <label class="form-label small fw-semibold text-secondary mb-1">Tanggal Selesai</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white text-muted"><i class="bi bi-calendar-check"></i></span>
                                    <input type="date" name="tgl_selesai" class="form-control form-control-soft">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card bg-light border-0 rounded-3 p-3 mb-3">
                        <a class="small text-decoration-none fw-semibold text-primary d-inline-flex align-items-center gap-2" data-bs-toggle="collapse" href="#collapseNibarList" role="button" aria-expanded="false">
                            <i class="bi bi-clipboard-plus fs-6"></i> + Tempel / Masukkan Daftar NIBAR Massal (Match Database)
                        </a>
                        <div class="collapse mt-2" id="collapseNibarList">
                            <textarea name="nibar_list" class="form-control form-control-soft font-monospace p-2" rows="3" style="font-size: 0.8rem;" placeholder="Tempel daftar NIBAR di sini (dipisahkan baris/koma)...&#10;Contoh:&#10;12.01.02.01.001&#10;12.01.02.01.002"></textarea>
                            <div class="text-muted mt-1" style="font-size: 0.75rem;"><i class="bi bi-info-circle me-1"></i> NIBAR yang ditempel di sini akan dicocokkan ke seluruh database secara otomatis.</div>
                        </div>
                    </div>

                    <div>
                        <label class="form-label small fw-semibold text-secondary mb-1">Keterangan / Catatan Proses</label>
                        <textarea name="keterangan" class="form-control form-control-soft" rows="2" placeholder="Catatan proses massal (opsional)...">Update status massal</textarea>
                    </div>
                </div>
                <div class="modal-footer border-top pt-2 px-4 pb-3">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 fw-semibold shadow-sm" id="btnSubmitBulk"><i class="bi bi-save2 me-1"></i> Simpan Pembaruan Massal</button>
                </div>
            </form>
        </div>
    </div>
</div>

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
        const bulkUpdated = params.get('bulk_updated');
        const showAlert = (text) => {
            if (typeof Swal !== 'undefined') {
                Swal.fire({ icon: 'success', title: 'Berhasil', text, timer: 2000, showConfirmButton: false });
            }
        };
        if (created  === '1') { showAlert('Aset tanah berhasil ditambahkan.'); params.delete('created'); }
        if (updated  === '1') { showAlert('Aset tanah berhasil diperbarui.'); params.delete('updated'); }
        if (deleted  === '1') { showAlert('Aset tanah berhasil dihapus.'); params.delete('deleted'); }
        if (imported === '1') { showAlert('Import aset selesai.'); params.delete('imported'); }
        if (bulkUpdated === '1') { showAlert('Status massal berhasil diperbarui.'); params.delete('bulk_updated'); }
        if (created === '1' || updated === '1' || deleted === '1' || imported === '1' || bulkUpdated === '1') {
            const newUrl = window.location.pathname + (params.toString() ? '?' + params.toString() : '');
            window.history.replaceState({}, document.title, newUrl);
        }

        // ── Bulk Status Update Handler ──
        const checkAllEl = document.getElementById('checkAllAset');
        const asetCheckboxes = document.querySelectorAll('.aset-checkbox');
        const btnBulkHeader = document.getElementById('btnBulkStatusHeader');
        const bulkFloatingBar = document.getElementById('bulkFloatingBar');
        const bulkCountHeader = document.getElementById('bulkCountHeader');
        const bulkCountFloat = document.getElementById('bulkCountFloat');
        const modalBulkCount = document.getElementById('modalBulkCount');
        const bulkInputsContainer = document.getElementById('bulkSelectedInputsContainer');
        const btnCancelBulk = document.getElementById('btnCancelBulk');

        function updateBulkUI() {
            const selected = Array.from(document.querySelectorAll('.aset-checkbox:checked'));
            const count = selected.length;

            if (bulkCountHeader) bulkCountHeader.textContent = count;
            if (bulkCountFloat) bulkCountFloat.textContent = count;
            if (modalBulkCount) modalBulkCount.textContent = count;

            if (count > 0) {
                if (btnBulkHeader) btnBulkHeader.classList.remove('d-none'), btnBulkHeader.classList.add('d-inline-flex');
                if (bulkFloatingBar) bulkFloatingBar.classList.remove('d-none');
            } else {
                if (btnBulkHeader) btnBulkHeader.classList.add('d-none'), btnBulkHeader.classList.remove('d-inline-flex');
                if (bulkFloatingBar) bulkFloatingBar.classList.add('d-none');
                if (checkAllEl) checkAllEl.checked = false;
            }
        }

        // ── Live Instant Search & Smart Check All ──
        const quickSearchInput = document.getElementById('quickSearchInput');
        const searchResultCount = document.getElementById('searchResultCount');
        const tableRows = document.querySelectorAll('.aset-table tbody tr');
        const mobileCards = document.querySelectorAll('.mobile-data-card');

        function filterRows() {
            if (!quickSearchInput) return;
            const q = quickSearchInput.value.toLowerCase().trim();
            let visibleCount = 0;

            tableRows.forEach(row => {
                const text = row.textContent.toLowerCase();
                const match = text.includes(q);
                row.style.display = match ? '' : 'none';
                if (match) visibleCount++;
            });

            mobileCards.forEach(card => {
                const text = card.textContent.toLowerCase();
                card.style.display = text.includes(q) ? '' : 'none';
            });

            if (searchResultCount) {
                searchResultCount.textContent = q ? `(${visibleCount} cocok)` : '';
            }

            if (checkAllEl) {
                const visibleCheckboxes = Array.from(document.querySelectorAll('.aset-table tbody tr:not([style*="display: none"]) .aset-checkbox'));
                if (visibleCheckboxes.length > 0) {
                    checkAllEl.checked = visibleCheckboxes.every(cb => cb.checked);
                } else {
                    checkAllEl.checked = false;
                }
            }
        }

        if (quickSearchInput) {
            quickSearchInput.addEventListener('input', filterRows);
        }

        if (checkAllEl) {
            checkAllEl.addEventListener('change', function () {
                const visibleCheckboxes = Array.from(document.querySelectorAll('.aset-table tbody tr:not([style*="display: none"]) .aset-checkbox, .mobile-data-card:not([style*="display: none"]) .aset-checkbox'));
                const targetCheckboxes = visibleCheckboxes.length > 0 ? visibleCheckboxes : asetCheckboxes;
                targetCheckboxes.forEach(cb => cb.checked = checkAllEl.checked);
                updateBulkUI();
            });
        }

        asetCheckboxes.forEach(cb => {
            cb.addEventListener('change', function () {
                if (!this.checked && checkAllEl) {
                    checkAllEl.checked = false;
                } else if (checkAllEl) {
                    const visibleCheckboxes = Array.from(document.querySelectorAll('.aset-table tbody tr:not([style*="display: none"]) .aset-checkbox'));
                    if (visibleCheckboxes.length > 0) {
                        checkAllEl.checked = visibleCheckboxes.every(c => c.checked);
                    }
                }
                updateBulkUI();
            });
        });

        if (btnCancelBulk) {
            btnCancelBulk.addEventListener('click', function () {
                if (checkAllEl) checkAllEl.checked = false;
                asetCheckboxes.forEach(cb => cb.checked = false);
                updateBulkUI();
            });
        }

        const modalBulkStatusEl = document.getElementById('modalBulkStatus');
        if (modalBulkStatusEl) {
            modalBulkStatusEl.addEventListener('show.bs.modal', function () {
                if (bulkInputsContainer) {
                    bulkInputsContainer.innerHTML = '';
                    const selected = Array.from(document.querySelectorAll('.aset-checkbox:checked'));
                    selected.forEach(cb => {
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = 'aset_ids[]';
                        input.value = cb.value;
                        bulkInputsContainer.appendChild(input);
                    });
                }
            });
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
                    // Re-execute scripts injected via innerHTML
                    content.querySelectorAll('script').forEach(function(oldScript) {
                        const newScript = document.createElement('script');
                        if (oldScript.src) {
                            newScript.src = oldScript.src;
                        } else {
                            newScript.textContent = oldScript.textContent;
                        }
                        oldScript.parentNode.replaceChild(newScript, oldScript);
                    });
                    modal.show();
                } catch (err) {
                    window.location.href = fallback;
                }
            });
        });
    });
</script>
<?= $this->endSection() ?>
