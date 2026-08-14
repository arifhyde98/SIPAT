<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h4 fw-semibold mb-1">Import & Update Kolektif</h1>
        <small class="text-muted">Upload file Excel / CSV untuk import data aset atau update status massal</small>
    </div>
    <a href="<?= base_url('aset') ?>" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar Aset
    </a>
</div>

<?php if (session()->has('errors')): ?>
    <div class="alert alert-danger alert-dismissible fade show rounded-3 mb-3" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>
        <?php foreach ((array) session('errors') as $err): ?>
            <div><?= esc($err) ?></div>
        <?php endforeach; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
    <div class="card-header bg-white border-bottom pt-3 pb-0">
        <ul class="nav nav-tabs card-header-tabs border-bottom-0" id="importTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active fw-semibold text-primary px-4 py-3" id="tab-status-tab" data-bs-toggle="tab" data-bs-target="#tab-status" type="button" role="tab" aria-controls="tab-status" aria-selected="true">
                    <i class="bi bi-layers me-2 text-primary"></i> 1. Upload Status Proses (NIBAR + Status)
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link fw-semibold text-secondary px-4 py-3" id="tab-aset-tab" data-bs-toggle="tab" data-bs-target="#tab-aset" type="button" role="tab" aria-controls="tab-aset" aria-selected="false">
                    <i class="bi bi-file-earmark-plus me-2 text-success"></i> 2. Import Data Aset Baru
                </button>
            </li>
        </ul>
    </div>
    <div class="card-body p-4">
        <div class="tab-content" id="importTabContent">
            
            <!-- ── TAB 1: Upload Status Proses via Excel ── -->
            <div class="tab-pane fade show active" id="tab-status" role="tabpanel" aria-labelledby="tab-status-tab">
                <div class="row g-4 align-items-start">
                    <div class="col-lg-7">
                        <h5 class="fw-bold text-dark mb-2">Upload Status Proses Kolektif</h5>
                        <p class="text-secondary small mb-3">
                            Unggah file Excel (<code>.xlsx</code>) atau CSV berisi daftar **NIBAR (Kode Aset)** dan **Status Proses** untuk memperbarui riwayat status proses aset secara otomatis.
                        </p>

                        <div class="card bg-light border-0 rounded-3 p-3 mb-4">
                            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-2">
                                <span class="fw-semibold text-dark small"><i class="bi bi-file-earmark-spreadsheet text-success me-1"></i> Format Header Kolom Excel:</span>
                                <a href="<?= base_url('aset/template-status-csv') ?>" class="btn btn-sm btn-outline-primary rounded-pill">
                                    <i class="bi bi-download me-1"></i> Download Template CSV/Excel
                                </a>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered bg-white text-center align-middle mb-0" style="font-size: 0.78rem;">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="text-primary">nibar <span class="text-danger">*</span></th>
                                            <th class="text-primary">status_proses <span class="text-danger">*</span></th>
                                            <th class="text-secondary">tgl_mulai</th>
                                            <th class="text-secondary">tgl_selesai</th>
                                            <th class="text-secondary">keterangan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="font-monospace">12.01.02.01.001</td>
                                            <td><span class="badge bg-success">Sertifikat</span></td>
                                            <td>2026-08-14</td>
                                            <td>-</td>
                                            <td class="text-muted">Update via Excel</td>
                                        </tr>
                                        <tr>
                                            <td class="font-monospace">12.01.02.01.002</td>
                                            <td><span class="badge bg-warning text-dark">Proses BPN</span></td>
                                            <td>2026-08-14</td>
                                            <td>-</td>
                                            <td class="text-muted">Update via Excel</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <form action="<?= base_url('aset/import-status') ?>" method="post" enctype="multipart/form-data">
                            <?= csrf_field() ?>
                            <div class="mb-4">
                                <label class="form-label fw-semibold text-dark">Pilih File Excel / CSV (.xlsx, .csv)</label>
                                <input type="file" name="file" class="form-control form-control-soft p-2" accept=".csv,.xlsx" required>
                                <span class="form-text text-muted">Maksimal ukuran file: 10 MB.</span>
                            </div>
                            <button type="submit" class="btn btn-primary rounded-3 px-4">
                                <i class="bi bi-cloud-upload me-1"></i> Proses Upload Status
                            </button>
                        </form>
                    </div>

                    <div class="col-lg-5">
                        <div class="alert alert-info border-0 rounded-4 p-3 mb-0" style="font-size: 0.85rem;">
                            <h6 class="fw-bold alert-heading mb-2"><i class="bi bi-lightbulb-fill text-warning me-1"></i> Petunjuk Pengisian:</h6>
                            <ul class="mb-0 ps-3">
                                <li class="mb-1"><strong>Boleh Tanpa Header (Langsung Baris 1):</strong> Kolom A = <code>NIBAR</code>, Kolom B = <code>Status Proses</code>.</li>
                                <li class="mb-1"><strong>Boleh Dengan Header:</strong> Baris 1 berisi nama kolom <code>nibar</code> (atau <code>kode_aset</code>) dan <code>status_proses</code>.</li>
                                <li class="mb-1">Nama <code>status_proses</code> harus diisi sesuai Master Status (contoh: <em>Proses Pengukuran, Proses BPN, Sertifikat Terbit, Selesai, dll.</em>).</li>
                                <li>Baris data yang berhasil diunggah akan langsung memperbarui status aset & mencatat audit log.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ── TAB 2: Import Data Aset Baru ── -->
            <div class="tab-pane fade" id="tab-aset" role="tabpanel" aria-labelledby="tab-aset-tab">
                <div class="row g-4 align-items-start">
                    <div class="col-lg-7">
                        <h5 class="fw-bold text-dark mb-2">Import Master Data Aset Baru</h5>
                        <p class="text-secondary small mb-3">
                            Unggah data aset tanah baru secara massal beserta detail OPD, peruntukan, luas, harga perolehan, dll.
                        </p>

                        <div class="d-flex align-items-center justify-content-between bg-light rounded-3 p-3 mb-4">
                            <div>
                                <h6 class="fw-semibold text-dark mb-1">Unduh Template Excel Data Aset</h6>
                                <span class="text-muted small">Template standar pengisian data aset baru.</span>
                            </div>
                            <a href="<?= base_url('template-import-aset.xlsx') ?>" class="btn btn-sm btn-outline-primary rounded-pill">
                                <i class="bi bi-download me-1"></i> Download Template (.xlsx)
                            </a>
                        </div>

                        <form action="<?= base_url('aset/import') ?>" method="post" enctype="multipart/form-data">
                            <?= csrf_field() ?>
                            <div class="mb-4">
                                <label class="form-label fw-semibold text-dark">File CSV / Excel (.xlsx)</label>
                                <input type="file" name="file" class="form-control form-control-soft p-2" accept=".csv,.xlsx" required>
                            </div>
                            <button type="submit" class="btn btn-success rounded-3 px-4">
                                <i class="bi bi-cloud-upload me-1"></i> Proses Import Aset Baru
                            </button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<?= $this->endSection() ?>
