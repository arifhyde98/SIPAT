<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<style>
    .report-shell {
        display: grid;
        grid-template-columns: minmax(0, 1.2fr) minmax(320px, 0.8fr);
        gap: 1.25rem;
    }
    @media (max-width: 991.98px) { .report-shell { grid-template-columns: 1fr; } }
    .report-card {
        border: 0;
        border-radius: 18px;
        box-shadow: 0 4px 20px rgba(15,23,42,0.06);
    }
    .report-summary {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 1rem;
    }
    @media (max-width: 767.98px) { .report-summary { grid-template-columns: 1fr; } }
    .summary-box {
        padding: 1rem 1.2rem;
        border: 1.5px solid #f1f5f9;
        border-radius: 14px;
        background: linear-gradient(160deg, #ffffff, #f8fafc);
        transition: box-shadow 0.2s;
    }
    .summary-box:hover { box-shadow: 0 4px 12px rgba(15,23,42,0.06); }
    .summary-label { color: #64748b; font-size: 0.8rem; font-weight: 500; margin-bottom: 4px; }
    .summary-value { font-weight: 800; font-size: 1.5rem; color: #0f172a; }
    .filter-chip {
        display: inline-flex; align-items: center; gap: .35rem;
        padding: .3rem .75rem; border-radius: 999px;
        background: #eff6ff; color: #1d4ed8;
        font-size: .78rem; font-weight: 600;
        margin: 0 .4rem .4rem 0;
    }
    .action-list .list-group-item {
        border: 1.5px solid #f1f5f9;
        border-radius: 12px;
        margin-bottom: .6rem;
        padding: 1rem 1.2rem;
        transition: all 0.15s;
    }
    .action-list .list-group-item:hover {
        background: #f8fafc;
        border-color: #e2e8f0;
        transform: translateX(2px);
        box-shadow: 0 2px 8px rgba(15,23,42,0.06);
    }
    .action-list .list-group-item .fw-semibold { color: #0f172a; }
    .manual-title-box {
        background: #fff7ed;
        border: 1.5px solid #fed7aa;
        border-radius: 12px;
        padding: 1rem 1.2rem;
    }
</style>

<div class="d-flex justify-content-between align-items-start mb-4 flex-wrap gap-2">
    <div>
        <div style="font-size:0.75rem;color:#94a3b8;margin-bottom:4px;">
            <a href="<?= base_url('dashboard') ?>" style="color:#94a3b8;text-decoration:none;">Dashboard</a>
            <span class="mx-1">›</span> Laporan
        </div>
        <h1 class="h4 fw-bold text-dark mb-1">Laporan Aset</h1>
        <small class="text-muted">Pusat download laporan aset tanah dengan filter yang sama seperti export di master aset.</small>
    </div>
</div>

<div class="report-shell">
    <div class="card report-card">
        <div class="card-body p-4">
            <h5 class="fw-semibold mb-3"><?= esc($reportTitle ?? 'Laporan Aset Tanah') ?></h5>

            <form method="get" class="mb-4">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">OPD</label>
                        <select name="opd" class="form-select">
                            <option value="">Semua OPD</option>
                            <option value="KOSONG" <?= ($filters['opd'] === 'KOSONG') ? 'selected' : '' ?>>[Tanpa OPD / Kosong]</option>
                            <?php foreach ($opdList as $opd) : ?>
                                <option value="<?= esc($opd) ?>" <?= ($filters['opd'] === $opd) ? 'selected' : '' ?>><?= esc($opd) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Status</label>
                        <select name="status[]" id="statusMultiSelect" class="form-select" multiple placeholder="Semua Status...">
                            <?php foreach ($statusList as $status) : ?>
                                <option value="<?= esc($status['id_status']) ?>" <?= in_array((string)$status['id_status'], (array)($filters['status'] ?? []), true) ? 'selected' : '' ?>><?= esc($status['nama_status']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Tanggal Perolehan</label>
                        <input type="date" name="tanggal_perolehan" class="form-control" value="<?= esc($filters['tanggal_perolehan'] ?? '') ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Kata Kunci</label>
                        <input type="text" name="q" class="form-control" placeholder="Kode aset, nama aset, OPD..." value="<?= esc($filters['q'] ?? '') ?>">
                    </div>
                    <div class="col-12">
                        <div class="fw-semibold mb-2">Judul Laporan</div>
                        <div class="d-flex flex-wrap gap-3 mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="title_mode" id="titleModeMaster" value="master" <?= (($filters['title_mode'] ?? 'master') !== 'manual') ? 'checked' : '' ?>>
                                <label class="form-check-label" for="titleModeMaster">Pilih dari form list</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="title_mode" id="titleModeManual" value="manual" <?= (($filters['title_mode'] ?? '') === 'manual') ? 'checked' : '' ?>>
                                <label class="form-check-label" for="titleModeManual">Centang untuk isi judul manual</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-12" id="masterTitleBox">
                        <label class="form-label">Form List Judul Laporan</label>
                        <select name="report_title_id" class="form-select">
                            <option value="">Gunakan judul default KOP</option>
                            <?php foreach ($reportTitleList as $item) : ?>
                                <option value="<?= esc($item['id']) ?>" <?= (($filters['report_title_id'] ?? '') == $item['id']) ? 'selected' : '' ?>><?= esc($item['judul']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-12" id="manualTitleBox">
                        <div class="manual-title-box">
                            <label class="form-label">Judul Manual</label>
                            <input type="text" name="manual_title" class="form-control" placeholder="Contoh: Laporan Aset Tanah Sudah Bersertifikat" value="<?= esc($filters['manual_title'] ?? '') ?>">
                            <div class="form-text">Isi judul manual jika ingin mengganti judul laporan hanya untuk export saat ini.</div>
                        </div>
                    </div>
                </div>
                <div class="mt-3 d-flex gap-2 flex-wrap">
                    <button class="btn btn-primary">Terapkan Filter</button>
                    <a href="<?= base_url('laporan') ?>" class="btn btn-outline-secondary">Reset</a>
                </div>
            </form>

            <div class="report-summary mb-4">
                <div class="summary-box">
                    <div class="summary-label">Total Data</div>
                    <div class="summary-value"><?= number_format((int) ($summary['total_data'] ?? 0)) ?></div>
                </div>
                <div class="summary-box">
                    <div class="summary-label">Total Nilai Perolehan</div>
                    <div class="summary-value fs-4"><?= esc($summary['total_nilai'] ?? '-') ?></div>
                </div>
                <div class="summary-box">
                    <div class="summary-label">Sudah Berstatus</div>
                    <div class="summary-value"><?= number_format((int) ($summary['total_berstatus'] ?? 0)) ?></div>
                </div>
            </div>

            <div>
                <div class="fw-semibold mb-2">Filter Aktif</div>
                <?php if (!empty($activeFilters)) : ?>
                    <?php foreach ($activeFilters as $filter) : ?>
                        <span class="filter-chip"><?= esc($filter['label']) ?>: <?= esc($filter['value']) ?></span>
                    <?php endforeach; ?>
                <?php else : ?>
                    <span class="filter-chip">Semua data aset tanah</span>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="card report-card">
        <div class="card-body p-4">
            <h5 class="fw-semibold mb-3">Download Laporan</h5>
            <div class="list-group action-list">
                <a href="<?= base_url('laporan/aset/preview-pdf') . ($exportQueryString ?? '') ?>" target="_blank" class="list-group-item list-group-item-action">
                    <div class="fw-semibold">Preview PDF</div>
                    <small class="text-muted">Buka laporan PDF di tab baru untuk direview sebelum dicetak.</small>
                </a>
                <a href="<?= base_url('laporan/aset/download-pdf') . ($exportQueryString ?? '') ?>" class="list-group-item list-group-item-action">
                    <div class="fw-semibold">Download PDF</div>
                    <small class="text-muted">Unduh laporan PDF resmi dengan KOP dan tanda tangan.</small>
                </a>
                <a href="<?= base_url('laporan/aset/xlsx') . ($exportQueryString ?? '') ?>" class="list-group-item list-group-item-action">
                    <div class="fw-semibold">Download XLSX</div>
                    <small class="text-muted">Unduh laporan Excel dengan judul, filter aktif, dan format angka yang rapi.</small>
                </a>
                <a href="<?= base_url('laporan/aset/csv') . ($exportQueryString ?? '') ?>" class="list-group-item list-group-item-action">
                    <div class="fw-semibold">Download CSV</div>
                    <small class="text-muted">Unduh data laporan untuk pengolahan lanjutan.</small>
                </a>
            </div>
            <div class="alert alert-light border mt-3 mb-0">
                <div class="fw-semibold mb-1">Catatan</div>
                <small class="text-muted">Seluruh file yang diunduh dari halaman ini mengikuti filter aktif dan mode judul yang dipilih di atas.</small>
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
        if (masterBox) masterBox.style.display = manual ? 'none' : '';
        if (manualBox) manualBox.style.display = manual ? '' : 'none';
    };
    if (masterRadio) masterRadio.addEventListener('change', syncMode);
    if (manualRadio) manualRadio.addEventListener('change', syncMode);
    syncMode();

    // Initialize TomSelect for status
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
});
</script>
<?= $this->endSection() ?>

