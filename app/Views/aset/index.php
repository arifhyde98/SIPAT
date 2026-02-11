<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
    
    body {
        font-family: 'Inter', sans-serif;
        background-color: #f8fafc;
    }
    
    /* Filter Section */
    .aset-filter-container {
        background: #fff;
        border-radius: 12px;
        padding: 1rem;
        box-shadow: 0 2px 6px rgba(0,0,0,0.02);
        border: 1px solid #e2e8f0;
    }
    .form-control-soft, .form-select-soft {
        background-color: #f1f5f9;
        border: 1px solid transparent;
        border-radius: 8px;
        font-size: 0.875rem;
        transition: all 0.2s;
    }
    .form-control-soft:focus, .form-select-soft:focus {
        background-color: #fff;
        border-color: #cbd5e1;
        box-shadow: 0 0 0 3px rgba(148, 163, 184, 0.1);
    }

    /* Table Styling */
    .table-container {
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.03);
        background: #fff;
        overflow: hidden;
        border: 1px solid #e2e8f0;
        position: relative;
    }
    .table-responsive {
        max-height: 75vh;
        overflow-y: auto;
    }
    .aset-table {
        margin-bottom: 0;
    }
    .aset-table thead th {
        background: #f8fafc;
        color: #64748b;
        font-weight: 600;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        padding: 1rem 1.5rem;
        border-bottom: 1px solid #e2e8f0;
        white-space: nowrap;
        position: sticky;
        top: 0;
        z-index: 10;
    }
    .aset-table tbody td {
        padding: 1rem 1.5rem;
        vertical-align: middle;
        border-bottom: 1px solid #f1f5f9;
        color: #334155;
        font-size: 0.875rem;
    }
    .aset-table tbody tr:hover {
        background-color: #f8fafc;
    }
    
    /* Pastel Badges */
    .badge-pastel {
        padding: 0.35em 0.8em;
        border-radius: 50rem;
        font-weight: 600;
        font-size: 0.75rem;
        letter-spacing: 0.02em;
    }
    /* Override Bootstrap colors for pastel look */
    .badge-pastel.bg-success { background-color: #dcfce7 !important; color: #166534 !important; }
    .badge-pastel.bg-warning { background-color: #fef3c7 !important; color: #92400e !important; }
    .badge-pastel.bg-danger { background-color: #fee2e2 !important; color: #991b1b !important; }
    .badge-pastel.bg-info { background-color: #e0f2fe !important; color: #075985 !important; }
    .badge-pastel.bg-primary { background-color: #dbeafe !important; color: #1e40af !important; }
    .badge-pastel.bg-secondary { background-color: #f1f5f9 !important; color: #475569 !important; }

    /* Actions */
    .btn-icon {
        width: 32px;
        height: 32px;
        padding: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        color: #94a3b8;
        transition: all 0.2s;
        background: transparent;
        border: none;
    }
    .btn-icon:hover, .btn-icon[aria-expanded="true"] {
        background-color: #f1f5f9;
        color: #0f172a;
    }
    .dropdown-menu {
        border: 1px solid #e2e8f0;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
        font-size: 0.875rem;
    }
    .dropdown-item {
        padding: 8px 16px;
        color: #475569;
        border-radius: 6px;
        margin: 2px 4px;
        width: auto;
    }
    .dropdown-item:hover {
        background-color: #f1f5f9;
        color: #0f172a;
    }
    .dropdown-item.text-danger:hover {
        background-color: #fee2e2;
        color: #991b1b;
    }
</style>

<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h1 class="h4 fw-bold text-dark mb-1">Daftar Aset</h1>
        <p class="text-muted small mb-0">Monitoring status pensertifikatan tanah daerah</p>
    </div>
    <?php if (in_array(session()->get('user_role'), ['Admin', 'Pengelola Aset'], true)) : ?>
        <div class="d-flex gap-2">
            <div class="btn-group">
                <button type="button" class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-download me-1"></i> Export
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="<?= base_url('aset/export/print') ?>" target="_blank"><i class="bi bi-file-pdf me-2"></i>Print / PDF</a></li>
                    <li><a class="dropdown-item" href="<?= base_url('aset/export/csv') ?>"><i class="bi bi-file-earmark-spreadsheet me-2"></i>CSV</a></li>
                </ul>
            </div>
            <a href="<?= base_url('aset/import') ?>" class="btn btn-outline-primary"><i class="bi bi-upload me-1"></i> Import</a>
            <a href="<?= base_url('aset/create') ?>" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i> Tambah</a>
        </div>
    <?php endif; ?>
</div>

<form method="get" class="aset-filter-container mb-4">
    <div class="row g-3 align-items-center">
        <div class="col-md-auto">
            <select name="opd" class="form-select form-select-soft" style="min-width: 180px;">
                <option value="">Semua OPD</option>
                <?php foreach ($opdList as $opd) : ?>
                    <option value="<?= esc($opd) ?>" <?= ($filters['opd'] === $opd) ? 'selected' : '' ?>><?= esc($opd) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-auto">
            <select name="status" class="form-select form-select-soft" style="min-width: 160px;">
                <option value="">Semua Status</option>
                <?php foreach ($statusList as $status) : ?>
                    <option value="<?= esc($status['id_status']) ?>" <?= ($filters['status'] == $status['id_status']) ? 'selected' : '' ?>>
                        <?= esc($status['nama_status']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-auto">
            <input type="date" name="tanggal_perolehan" class="form-control form-control-soft" value="<?= esc($filters['tanggal_perolehan'] ?? '') ?>">
        </div>
        <div class="col">
            <div class="input-group">
                <span class="input-group-text border-0 bg-light ps-3"><i class="bi bi-search text-muted"></i></span>
                <input type="text" name="q" class="form-control form-control-soft border-start-0 ps-0 bg-light" placeholder="Cari aset..." value="<?= esc($filters['q'] ?? '') ?>">
            </div>
        </div>
        <div class="col-auto">
            <button class="btn btn-primary px-4 rounded-pill" type="submit">Filter</button>
        </div>
    </div>
</form>

<?php if (empty($data)) : ?>
    <div class="text-center py-5 text-muted">
        <i class="bi bi-inbox fs-1 d-block mb-2 opacity-50"></i>
        <p>Belum ada data aset yang ditemukan.</p>
    </div>
<?php else : ?>
    <div class="table-container">
        <div class="table-responsive">
            <table class="table align-middle mb-0 aset-table">
                <thead>
                    <tr>
                        <th class="d-none">Kode</th>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Penggunaan</th>
                        <th>OPD</th>
                        <th class="text-end">Luas (m²)</th>
                        <th class="text-end">Harga</th>
                        <th>Status Saat Ini</th>
                        <th>Durasi (hari)</th>
                        <th class="text-center" style="width: 60px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; ?>
                    <?php foreach ($data as $row) : ?>
                        <tr>
                            <td class="d-none"><?= esc($row['kode_aset']) ?></td>
                            <td class="text-muted"><?= $no++ ?></td>
                            <td class="fw-medium text-dark"><?= esc($row['nama_aset']) ?></td>
                            <td class="text-secondary"><?= esc($row['peruntukan'] ?? '-') ?></td>
                            <td class="text-secondary"><?= esc($row['opd'] ?? '-') ?></td>
                            <td class="text-end font-monospace"><?= esc($row['luas']) ?></td>
                            <td class="text-end font-monospace">
                                <?php if (!empty($row['harga_perolehan'])) : ?>
                                    <?= esc(number_format((float) $row['harga_perolehan'], 2, '.', ',')) ?>
                                <?php else : ?>
                                    -
                                <?php endif; ?>
                            </td>
                            <td><span class="badge badge-pastel bg-<?= esc($row['warna_status']) ?>"><?= esc($row['status_terkini']) ?></span></td>
                            <td class="text-muted"><?= esc($row['durasi_hari']) ?></td>
                            <td class="text-center">
                                <div class="dropdown">
                                    <button class="btn btn-icon" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                            <a class="dropdown-item" href="<?= base_url('aset/' . $row['id_aset']) ?>" data-modal-aset data-modal-url="<?= base_url('aset/' . $row['id_aset'] . '/modal') ?>">
                                                <i class="bi bi-eye me-2 text-primary"></i>Detail
                                            </a>
                                        </li>
                                        <?php if (in_array(session()->get('user_role'), ['Admin', 'Pengelola Aset'], true)) : ?>
                                            <li>
                                                <a class="dropdown-item" href="<?= base_url('aset/' . $row['id_aset'] . '/edit') ?>">
                                                    <i class="bi bi-pencil me-2 text-warning"></i>Edit
                                                </a>
                                            </li>
                                            <li><hr class="dropdown-divider"></li>
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
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const params = new URLSearchParams(window.location.search);
        const created = params.get('created');
        const updated = params.get('updated');
        const deleted = params.get('deleted');
        const imported = params.get('imported');
        const showAlert = (text) => {
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text,
                    timer: 1800,
                    showConfirmButton: false,
                });
            }
        };
        if (created === '1') {
            showAlert('Aset tanah berhasil ditambahkan.');
            params.delete('created');
        }
        if (updated === '1') {
            showAlert('Aset tanah berhasil diperbarui.');
            params.delete('updated');
        }
        if (deleted === '1') {
            showAlert('Aset tanah berhasil dihapus.');
            params.delete('deleted');
        }
        if (imported === '1') {
            showAlert('Import aset selesai.');
            params.delete('imported');
        }
        if (created === '1' || updated === '1' || deleted === '1' || imported === '1') {
            const newUrl = window.location.pathname + (params.toString() ? '?' + params.toString() : '');
            window.history.replaceState({}, document.title, newUrl);
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
