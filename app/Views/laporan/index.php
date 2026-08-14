<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<style>
    /* Premium UI Tokens */
    :root {
        --gov-primary: #1E5EFF;
        --gov-primary-hover: #1846C7;
        --gov-primary-light: #eff6ff;
        --gov-success: #10b981;
        --gov-success-light: #ecfdf5;
        --gov-warning: #f59e0b;
        --gov-warning-light: #fffbeb;
        --gov-danger: #ef4444;
        --gov-danger-light: #fef2f2;
        --gov-dark: #0f172a;
        --gov-gray-text: #64748b;
        --gov-bg: #f8fafc;
        --card-shadow: 0 10px 30px -10px rgba(15, 23, 42, 0.08);
        --hover-shadow: 0 20px 40px -15px rgba(30, 94, 255, 0.15);
    }

    body {
        background-color: var(--gov-bg);
    }

    .report-shell {
        display: grid;
        grid-template-columns: minmax(0, 1.4fr) minmax(350px, 0.8fr);
        gap: 1.5rem;
    }
    @media (max-width: 991.98px) { .report-shell { grid-template-columns: 1fr; } }

    /* Modern Cards */
    .report-card {
        border: 0;
        border-radius: 20px;
        background: #ffffff;
        box-shadow: var(--card-shadow);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        overflow: hidden;
    }
    .report-card:hover {
        box-shadow: var(--hover-shadow);
    }
    .report-card-header {
        background: linear-gradient(to right, #ffffff, var(--gov-primary-light));
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid rgba(30, 94, 255, 0.1);
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    .header-icon {
        width: 40px;
        height: 40px;
        border-radius: 12px;
        background: var(--gov-primary);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        box-shadow: 0 4px 10px rgba(30, 94, 255, 0.3);
    }

    /* Form Controls */
    .form-label {
        font-weight: 600;
        color: var(--gov-dark);
        font-size: 0.85rem;
        margin-bottom: 0.5rem;
    }
    .form-control, .form-select {
        border-radius: 12px;
        border: 1px solid #cbd5e1;
        padding: 0.6rem 1rem;
        font-size: 0.95rem;
        transition: all 0.2s ease;
        background-color: #f8fafc;
    }
    .form-control:focus, .form-select:focus {
        border-color: var(--gov-primary);
        box-shadow: 0 0 0 4px var(--gov-primary-light);
        background-color: #ffffff;
    }
    
    /* TomSelect Overrides */
    .ts-control {
        border-radius: 12px !important;
        border: 1px solid #cbd5e1 !important;
        padding: 0.6rem 1rem !important;
        background-color: #f8fafc !important;
        transition: all 0.2s ease;
    }
    .ts-control.focus {
        border-color: var(--gov-primary) !important;
        box-shadow: 0 0 0 4px var(--gov-primary-light) !important;
        background-color: #ffffff !important;
    }

    /* Summary Stats */
    .report-summary {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 1rem;
    }
    @media (max-width: 767.98px) { .report-summary { grid-template-columns: 1fr; } }
    .summary-box {
        padding: 1.25rem;
        border-radius: 16px;
        border: 1px solid rgba(255, 255, 255, 0.5);
        background: linear-gradient(135deg, #ffffff 0%, #f1f5f9 100%);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    .summary-box::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0; height: 4px;
        background: var(--gov-primary);
        border-radius: 16px 16px 0 0;
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    .summary-box:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px -5px rgba(15, 23, 42, 0.1);
    }
    .summary-box:hover::before { opacity: 1; }
    .summary-icon {
        position: absolute;
        right: -10px;
        bottom: -15px;
        font-size: 5rem;
        opacity: 0.05;
        color: var(--gov-dark);
        transition: transform 0.3s ease;
    }
    .summary-box:hover .summary-icon {
        transform: scale(1.1) rotate(-10deg);
    }
    .summary-label { color: var(--gov-gray-text); font-size: 0.85rem; font-weight: 600; margin-bottom: 4px; text-transform: uppercase; letter-spacing: 0.5px;}
    .summary-value { font-weight: 800; font-size: 1.75rem; color: var(--gov-dark); line-height: 1.2; }

    /* Filter Chips */
    .filter-chip {
        display: inline-flex; align-items: center; gap: 0.4rem;
        padding: 0.4rem 0.85rem; border-radius: 999px;
        background: var(--gov-primary-light); color: var(--gov-primary);
        font-size: 0.8rem; font-weight: 600;
        margin: 0 0.4rem 0.5rem 0;
        border: 1px solid rgba(30, 94, 255, 0.2);
        transition: all 0.2s;
    }
    .filter-chip:hover {
        background: var(--gov-primary);
        color: white;
    }

    /* Download Action List */
    .action-list {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }
    .action-list .list-group-item {
        border: 1px solid #e2e8f0;
        border-radius: 16px !important;
        padding: 1.25rem;
        background: #ffffff;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        align-items: flex-start;
        gap: 1rem;
        text-decoration: none;
        position: relative;
        overflow: hidden;
    }
    .action-list .list-group-item::after {
        content: '\F285'; /* bi-arrow-right-short */
        font-family: bootstrap-icons !important;
        position: absolute;
        right: 1.5rem;
        top: 50%;
        transform: translateY(-50%) translateX(20px);
        font-size: 1.5rem;
        opacity: 0;
        color: var(--gov-primary);
        transition: all 0.3s ease;
    }
    .action-list .list-group-item:hover {
        border-color: var(--gov-primary);
        background: var(--gov-primary-light);
        box-shadow: 0 8px 16px rgba(30, 94, 255, 0.1);
        transform: scale(1.02);
    }
    .action-list .list-group-item:hover::after {
        opacity: 1;
        transform: translateY(-50%) translateX(0);
    }
    .action-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        flex-shrink: 0;
        transition: all 0.3s ease;
    }
    
    .action-preview { background: var(--gov-primary-light); color: var(--gov-primary); }
    .action-pdf { background: var(--gov-danger-light); color: var(--gov-danger); }
    .action-excel { background: var(--gov-success-light); color: var(--gov-success); }
    .action-csv { background: var(--gov-warning-light); color: var(--gov-warning); }

    .action-list .list-group-item:hover .action-preview { background: var(--gov-primary); color: white; }
    .action-list .list-group-item:hover .action-pdf { background: var(--gov-danger); color: white; }
    .action-list .list-group-item:hover .action-excel { background: var(--gov-success); color: white; }
    .action-list .list-group-item:hover .action-csv { background: var(--gov-warning); color: white; }

    .action-text .fw-semibold { color: var(--gov-dark); font-size: 1.05rem; margin-bottom: 0.25rem; transition: color 0.3s ease;}
    .action-text .text-muted { font-size: 0.85rem; line-height: 1.4; }
    .action-list .list-group-item:hover .action-text .fw-semibold { color: var(--gov-primary); }

    /* Custom Radio Buttons */
    .custom-radio-group {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
    }
    .custom-radio {
        position: relative;
    }
    .custom-radio input[type="radio"] {
        position: absolute;
        opacity: 0;
    }
    .custom-radio label {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.6rem 1.2rem;
        background: #ffffff;
        border: 2px solid #e2e8f0;
        border-radius: 999px;
        cursor: pointer;
        font-weight: 600;
        font-size: 0.9rem;
        color: var(--gov-gray-text);
        transition: all 0.2s ease;
    }
    .custom-radio input[type="radio"]:checked + label {
        background: var(--gov-primary-light);
        border-color: var(--gov-primary);
        color: var(--gov-primary);
        box-shadow: 0 4px 12px rgba(30, 94, 255, 0.15);
    }

    .manual-title-box {
        background: linear-gradient(to right, #fff7ed, #ffffff);
        border: 1px solid #fed7aa;
        border-left: 4px solid var(--gov-warning);
        border-radius: 12px;
        padding: 1.25rem;
    }
    
    /* Buttons */
    .btn-premium {
        background: linear-gradient(135deg, var(--gov-primary), #3b82f6);
        color: white;
        border: none;
        border-radius: 12px;
        padding: 0.6rem 1.5rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        box-shadow: 0 4px 12px rgba(30, 94, 255, 0.2);
        transition: all 0.3s ease;
    }
    .btn-premium:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(30, 94, 255, 0.3);
        color: white;
    }
    .btn-premium-outline {
        background: white;
        color: var(--gov-gray-text);
        border: 1px solid #cbd5e1;
        border-radius: 12px;
        padding: 0.6rem 1.5rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
    }
    .btn-premium-outline:hover {
        background: #f1f5f9;
        color: var(--gov-dark);
        border-color: #94a3b8;
    }

</style>

<div class="d-flex justify-content-between align-items-start mb-4 flex-wrap gap-2">
    <div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-1" style="font-size: 0.85rem; font-weight: 500;">
                <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>" class="text-decoration-none text-muted">Dashboard</a></li>
                <li class="breadcrumb-item active text-primary" aria-current="page">Laporan Aset</li>
            </ol>
        </nav>
        <h1 class="h3 fw-bold text-dark mb-1">
            <i class="bi bi-file-earmark-text text-primary me-2"></i> Pusat Laporan Aset Tanah
        </h1>
        <p class="text-muted mb-0">Atur filter dan unduh data aset tanah dalam berbagai format sesuai kebutuhan Anda.</p>
    </div>
</div>

<div class="report-shell">
    <!-- Kolom Kiri: Filter & Summary -->
    <div class="d-flex flex-column gap-4">
        <div class="card report-card">
            <div class="report-card-header">
                <div class="header-icon">
                    <i class="bi bi-funnel"></i>
                </div>
                <h5 class="fw-bold mb-0 text-dark">Filter Laporan</h5>
            </div>
            <div class="card-body p-4">
                <form method="get" class="mb-2">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label"><i class="bi bi-building me-1"></i> OPD</label>
                            <select name="opd" class="form-select">
                                <option value="">Semua OPD</option>
                                <option value="KOSONG" <?= ($filters['opd'] === 'KOSONG') ? 'selected' : '' ?>>[Tanpa OPD / Kosong]</option>
                                <?php foreach ($opdList as $opd) : ?>
                                    <option value="<?= esc($opd) ?>" <?= ($filters['opd'] === $opd) ? 'selected' : '' ?>><?= esc($opd) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label"><i class="bi bi-tag me-1"></i> Status Sertifikasi</label>
                            <select name="status[]" id="statusMultiSelect" class="form-select" multiple placeholder="Pilih status...">
                                <?php foreach ($statusList as $status) : ?>
                                    <option value="<?= esc($status['id_status']) ?>" <?= in_array((string)$status['id_status'], (array)($filters['status'] ?? []), true) ? 'selected' : '' ?>><?= esc($status['nama_status']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label"><i class="bi bi-calendar-event me-1"></i> Tanggal Perolehan</label>
                            <input type="date" name="tanggal_perolehan" class="form-control" value="<?= esc($filters['tanggal_perolehan'] ?? '') ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label"><i class="bi bi-search me-1"></i> Kata Kunci Pencarian</label>
                            <input type="text" name="q" class="form-control" placeholder="Cari kode aset, nama, atau lokasi..." value="<?= esc($filters['q'] ?? '') ?>">
                        </div>
                        
                        <div class="col-12 mt-4 pt-4 border-top">
                            <label class="form-label mb-3"><i class="bi bi-type me-1"></i> Pengaturan Judul Laporan PDF</label>
                            <div class="custom-radio-group mb-4">
                                <div class="custom-radio">
                                    <input type="radio" name="title_mode" id="titleModeMaster" value="master" <?= (($filters['title_mode'] ?? 'master') !== 'manual') ? 'checked' : '' ?>>
                                    <label for="titleModeMaster"><i class="bi bi-list-ul"></i> Pilih dari Master Judul</label>
                                </div>
                                <div class="custom-radio">
                                    <input type="radio" name="title_mode" id="titleModeManual" value="manual" <?= (($filters['title_mode'] ?? '') === 'manual') ? 'checked' : '' ?>>
                                    <label for="titleModeManual"><i class="bi bi-pencil-square"></i> Ketik Judul Manual</label>
                                </div>
                            </div>
                            
                            <div id="masterTitleBox" class="bg-light p-3 rounded-3 border">
                                <label class="form-label text-muted small">Pilih Format Master</label>
                                <select name="report_title_id" class="form-select">
                                    <option value="">Ganti dengan judul bawaan (Default)</option>
                                    <?php foreach ($reportTitleList as $item) : ?>
                                        <option value="<?= esc($item['id']) ?>" <?= (($filters['report_title_id'] ?? '') == $item['id']) ? 'selected' : '' ?>><?= esc($item['judul']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            
                            <div id="manualTitleBox" style="display:none;">
                                <div class="manual-title-box shadow-sm">
                                    <label class="form-label text-warning-emphasis">Ketik Judul Kustom</label>
                                    <input type="text" name="manual_title" class="form-control" placeholder="Contoh: LAPORAN REKAPITULASI ASET TANAH DINAS PENDIDIKAN" value="<?= esc($filters['manual_title'] ?? '') ?>">
                                    <div class="form-text mt-2"><i class="bi bi-info-circle"></i> Judul ini hanya akan digunakan untuk sesi ekspor saat ini dan tidak tersimpan di master.</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-4 pt-3 d-flex gap-2 flex-wrap">
                        <button type="submit" class="btn-premium">
                            <i class="bi bi-funnel-fill"></i> Terapkan Filter Data
                        </button>
                        <a href="<?= base_url('laporan') ?>" class="btn-premium-outline">
                            <i class="bi bi-arrow-counterclockwise"></i> Reset
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <div class="card report-card">
            <div class="card-body p-4">
                <h6 class="fw-bold text-dark mb-3">Ringkasan Hasil Filter</h6>
                <div class="report-summary mb-4">
                    <div class="summary-box">
                        <i class="bi bi-layers summary-icon"></i>
                        <div class="summary-label">Total Data Aset</div>
                        <div class="summary-value"><?= number_format((int) ($summary['total_data'] ?? 0)) ?></div>
                    </div>
                    <div class="summary-box" style="background: linear-gradient(135deg, #ffffff 0%, #ecfdf5 100%); border-color: #d1fae5;">
                        <i class="bi bi-cash-coin summary-icon text-success"></i>
                        <div class="summary-label text-success">Total Nilai Perolehan</div>
                        <div class="summary-value fs-4 text-success"><?= esc($summary['total_nilai'] ?? '-') ?></div>
                    </div>
                    <div class="summary-box" style="background: linear-gradient(135deg, #ffffff 0%, #eff6ff 100%); border-color: #dbeafe;">
                        <i class="bi bi-check2-circle summary-icon text-primary"></i>
                        <div class="summary-label text-primary">Aset Berstatus</div>
                        <div class="summary-value text-primary"><?= number_format((int) ($summary['total_berstatus'] ?? 0)) ?></div>
                    </div>
                </div>

                <div class="p-3 bg-light rounded-3 border">
                    <div class="fw-bold text-dark mb-2" style="font-size: 0.85rem; text-transform: uppercase;">Tag Filter Aktif:</div>
                    <div class="d-flex flex-wrap">
                        <?php if (!empty($activeFilters)) : ?>
                            <?php foreach ($activeFilters as $filter) : ?>
                                <span class="filter-chip shadow-sm">
                                    <i class="bi bi-bookmark-check"></i> 
                                    <?= esc($filter['label']) ?>: <strong><?= esc($filter['value']) ?></strong>
                                </span>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <span class="filter-chip shadow-sm bg-secondary bg-opacity-10 text-secondary border-secondary">
                                <i class="bi bi-asterisk"></i> Menampilkan Seluruh Data Aset
                            </span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Kolom Kanan: Aksi Ekspor -->
    <div class="d-flex flex-column gap-4">
        <div class="card report-card sticky-top" style="top: 2rem;">
            <div class="report-card-header" style="background: linear-gradient(to right, #ffffff, #ecfdf5);">
                <div class="header-icon bg-success">
                    <i class="bi bi-cloud-download"></i>
                </div>
                <h5 class="fw-bold mb-0 text-dark">Aksi Unduh Laporan</h5>
            </div>
            <div class="card-body p-4">
                <div class="list-group action-list">
                    <a href="<?= base_url('laporan/aset/preview-pdf') . ($exportQueryString ?? '') ?>" target="_blank" class="list-group-item shadow-sm">
                        <div class="action-icon action-preview">
                            <i class="bi bi-file-earmark-text"></i>
                        </div>
                        <div class="action-text">
                            <div class="fw-semibold">Pratinjau PDF</div>
                            <div class="text-muted">Lihat hasil laporan di tab baru sebelum mencetaknya secara fisik.</div>
                        </div>
                    </a>
                    
                    <a href="<?= base_url('laporan/aset/download-pdf') . ($exportQueryString ?? '') ?>" class="list-group-item shadow-sm">
                        <div class="action-icon action-pdf">
                            <i class="bi bi-file-earmark-pdf"></i>
                        </div>
                        <div class="action-text">
                            <div class="fw-semibold">Unduh Dokumen PDF</div>
                            <div class="text-muted">Unduh laporan resmi lengkap dengan KOP surat dan kolom tanda tangan.</div>
                        </div>
                    </a>
                    
                    <a href="<?= base_url('laporan/aset/xlsx') . ($exportQueryString ?? '') ?>" class="list-group-item shadow-sm">
                        <div class="action-icon action-excel">
                            <i class="bi bi-file-earmark-excel"></i>
                        </div>
                        <div class="action-text">
                            <div class="fw-semibold">Unduh Microsoft Excel</div>
                            <div class="text-muted">Unduh data tabel (XLSX) dengan format angka rapi untuk dianalisis lebih lanjut.</div>
                        </div>
                    </a>
                    
                    <a href="<?= base_url('laporan/aset/csv') . ($exportQueryString ?? '') ?>" class="list-group-item shadow-sm">
                        <div class="action-icon action-csv">
                            <i class="bi bi-filetype-csv"></i>
                        </div>
                        <div class="action-text">
                            <div class="fw-semibold">Unduh Format CSV</div>
                            <div class="text-muted">Unduh <i>raw data</i> mentah yang ringan untuk di-impor ke sistem lain.</div>
                        </div>
                    </a>
                </div>
                
                <div class="alert alert-info mt-4 mb-0 d-flex align-items-start gap-3 border-0 bg-primary bg-opacity-10 text-primary-emphasis rounded-4 shadow-sm">
                    <i class="bi bi-info-circle-fill fs-5 mt-1"></i>
                    <div>
                        <div class="fw-bold mb-1">Catatan Penting</div>
                        <small style="line-height: 1.5; display: block;">File yang Anda unduh akan <strong>selalu menyesuaikan secara otomatis</strong> dengan filter yang sedang aktif di panel sebelah kiri.</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<!-- TomSelect untuk multi-select status -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.bootstrap5.min.css">
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const masterRadio = document.getElementById('titleModeMaster');
    const manualRadio = document.getElementById('titleModeManual');
    const masterBox = document.getElementById('masterTitleBox');
    const manualBox = document.getElementById('manualTitleBox');
    
    const syncMode = () => {
        const manual = manualRadio && manualRadio.checked;
        if (masterBox) masterBox.style.display = manual ? 'none' : 'block';
        if (manualBox) manualBox.style.display = manual ? 'block' : 'none';
    };
    
    if (masterRadio) masterRadio.addEventListener('change', syncMode);
    if (manualRadio) manualRadio.addEventListener('change', syncMode);
    syncMode();

    // Initialize TomSelect for status
    const statusEl = document.getElementById('statusMultiSelect');
    if (statusEl) {
        new TomSelect(statusEl, {
            plugins: ['remove_button', 'checkbox_options'],
            placeholder: 'Ketik untuk mencari status...',
            maxOptions: 50,
            closeAfterSelect: false,
            hideSelected: false,
            render: {
                option: function(data, escape) {
                    return '<div class="d-flex align-items-center gap-2 px-2 py-1"><span>' + escape(data.text) + '</span></div>';
                }
            }
        });
    }
});
</script>
<?= $this->endSection() ?>
