<style>
    /* Typography */
    .detail-label {
        font-size: 0.72rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #94a3b8;
        font-weight: 600;
        margin-bottom: 0.2rem;
    }
    .detail-value {
        font-size: 0.95rem;
        color: #1e293b;
        font-weight: 600;
        margin-bottom: 1rem;
    }

    /* Tabs */
    .modal-tabs .nav-link {
        color: #64748b;
        font-weight: 500;
        border: none;
        border-bottom: 2px solid transparent;
        padding: 0.75rem 1rem;
        margin-right: 0.5rem;
        background: transparent;
        transition: all 0.2s;
    }
    .modal-tabs .nav-link:hover {
        color: #1E5EFF;
    }
    .modal-tabs .nav-link.active {
        color: #1E5EFF;
        border-bottom-color: #1E5EFF;
        background: transparent;
    }

    /* Cards */
    .clean-card {
        background: #fff;
        border: 1px solid #f1f5f9;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.02);
    }

    /* Vertical Timeline */
    .v-timeline {
        position: relative;
        padding-left: 1.5rem;
        list-style: none;
        margin-bottom: 0;
    }
    .v-timeline::before {
        content: '';
        position: absolute;
        top: 0; bottom: 0; left: 0.4rem;
        width: 2px;
        background: #e2e8f0;
    }
    .v-timeline-item {
        position: relative;
        padding-bottom: 1.5rem;
    }
    .v-timeline-item:last-child { padding-bottom: 0; }
    .v-timeline-node {
        position: absolute;
        left: -1.5rem; top: 0.3rem;
        width: 14px; height: 14px;
        border-radius: 50%;
        border: 2px solid #fff;
        box-shadow: 0 0 0 2px #e2e8f0;
        z-index: 1;
    }
    .v-timeline-content {
        background: #f8fafc;
        border: 1px solid #f1f5f9;
        border-radius: 10px;
        padding: 1rem;
    }

    /* Form Switch Custom */
    .form-switch .form-check-input {
        width: 2.5em;
        height: 1.25em;
        margin-top: 0.15em;
    }
</style>

<div class="modal-header border-bottom-0 pb-0">
    <div>
        <h4 class="modal-title fw-bold text-dark mb-1">Detail Aset</h4>
        <div class="text-muted small">
            <span class="badge bg-secondary me-1"><?= esc($aset['kode_aset']) ?></span>
            <?= esc($aset['nama_aset']) ?>
        </div>
    </div>
    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Tutup"></button>
</div>

<!-- Tabs Navigation -->
<div class="px-3 pt-3">
    <ul class="nav nav-tabs modal-tabs border-bottom" id="assetDetailTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="info-tab" data-bs-toggle="tab" data-bs-target="#info" type="button" role="tab">Informasi Utama</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="timeline-tab" data-bs-toggle="tab" data-bs-target="#timeline" type="button" role="tab">Riwayat & Proses</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="security-tab" data-bs-toggle="tab" data-bs-target="#security" type="button" role="tab">Pengamanan Fisik</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="docs-tab" data-bs-toggle="tab" data-bs-target="#docs" type="button" role="tab">Dokumen Aset</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="elabel-tab" data-bs-toggle="tab" data-bs-target="#elabel" type="button" role="tab"><i class="bi bi-box-seam me-1"></i>Arsip Fisik (eLabel)</button>
        </li>
    </ul>
</div>

<div class="modal-body pt-4" style="background-color: #fcfcfc;">
    <div class="tab-content" id="assetDetailTabsContent">
        
        <!-- TAB 1: Informasi Utama -->
        <div class="tab-pane fade show active" id="info" role="tabpanel">
            <div class="clean-card p-4">
                <div class="row">
                    <div class="col-md-6 col-lg-4">
                        <div class="detail-label">OPD</div>
                        <div class="detail-value"><?= esc($aset['opd'] ?? '-') ?></div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="detail-label">Penggunaan</div>
                        <div class="detail-value"><?= esc($aset['peruntukan'] ?? '-') ?></div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="detail-label">Luas Tanah</div>
                        <div class="detail-value">
                            <?= esc($aset['luas'] ?? '-') ?> <span class="text-muted fw-normal">m²</span>
                        </div>
                    </div>
                    
                    <div class="col-md-6 col-lg-4">
                        <div class="detail-label">Harga Perolehan</div>
                        <div class="detail-value font-monospace">
                            <?php if (!empty($aset['harga_perolehan'])) : ?>
                                Rp <?= esc(number_format((float) $aset['harga_perolehan'], 2, ',', '.')) ?>
                            <?php else : ?>
                                -
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="detail-label">Tanggal Perolehan</div>
                        <div class="detail-value"><?= esc($aset['tanggal_perolehan'] ?? '-') ?></div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="detail-label">Dasar Perolehan</div>
                        <div class="detail-value"><?= esc($aset['dasar_perolehan'] ?? '-') ?></div>
                    </div>

                    <div class="col-12 mt-2 mb-3">
                        <hr class="text-muted opacity-25">
                    </div>

                    <div class="col-lg-6">
                        <div class="detail-label">Alamat Lokasi</div>
                        <div class="detail-value"><?= esc($aset['alamat'] ?? '-') ?></div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="detail-label">Latitude</div>
                        <div class="detail-value font-monospace"><?= esc($aset['lat'] ?? '-') ?></div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="detail-label">Longitude</div>
                        <div class="detail-value font-monospace"><?= esc($aset['lng'] ?? '-') ?></div>
                    </div>

                    <div class="col-12 mt-2 mb-3">
                        <hr class="text-muted opacity-25">
                    </div>

                    <div class="col-12">
                        <div class="detail-label">Keterangan Tambahan</div>
                        <div class="detail-value fw-normal text-secondary"><?= esc($aset['keterangan'] ?? '-') ?></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- TAB 2: Riwayat & Proses -->
        <div class="tab-pane fade" id="timeline" role="tabpanel">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="mb-0 fw-bold text-dark">Kronologi Pensertifikatan</h6>
            </div>

            <?php if (in_array(session()->get('user_role'), ['Admin', 'Pengelola Aset'], true)) : ?>
                <div class="mb-4" id="formTambahProses">
                    <div class="clean-card p-3" style="border-top: 3px solid #1E5EFF;">
                        <h6 class="fw-bold mb-3 small">Form Tambah Proses Baru</h6>
                        <form action="<?= base_url('proses/' . $aset['id_aset']) ?>" method="post">
                            <?= csrf_field() ?>
                            <div class="row g-2">
                                <div class="col-md-6">
                                    <label class="form-label small text-muted mb-1">Status Tahapan</label>
                                    <select name="id_status" class="form-select form-select-sm" required>
                                        <?php foreach ($statusList as $status) : ?>
                                            <option value="<?= esc($status['id_status']) ?>"><?= esc($status['nama_status']) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small text-muted mb-1">Keterangan</label>
                                    <input type="text" name="keterangan" class="form-control form-control-sm" placeholder="Contoh: Pengukuran ulang oleh BPN">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small text-muted mb-1">Tanggal Mulai</label>
                                    <input type="date" name="tgl_mulai" class="form-control form-control-sm">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small text-muted mb-1">Tanggal Selesai (Opsional)</label>
                                    <input type="date" name="tgl_selesai" class="form-control form-control-sm">
                                </div>
                            </div>
                            <div class="text-end mt-3">
                                <button type="submit" class="btn btn-sm btn-primary px-4"><i class="bi bi-save2 me-1"></i>Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            <?php endif; ?>

            <div class="clean-card p-4">
                <?php if (empty($prosesList)) : ?>
                    <div class="text-center py-4 text-muted">
                        <i class="bi bi-clock-history fs-1 mb-2 d-block opacity-50"></i>
                        Belum ada riwayat proses dicatat.
                    </div>
                <?php else : ?>
                    <ul class="v-timeline">
                        <?php foreach ($prosesList as $proses) : ?>
                            <li class="v-timeline-item">
                                <div class="v-timeline-node bg-<?= esc($proses['warna'] ?? 'secondary') ?>"></div>
                                <div class="v-timeline-content">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <span class="badge bg-<?= esc($proses['warna'] ?? 'secondary') ?> bg-opacity-10 text-<?= esc($proses['warna'] ?? 'secondary') ?> border border-<?= esc($proses['warna'] ?? 'secondary') ?> mb-2">
                                                <?= esc($proses['nama_status'] ?? '-') ?>
                                            </span>
                                            <h6 class="fw-bold mb-1"><?= esc($proses['keterangan'] ?? 'Tanpa keterangan') ?></h6>
                                            <div class="text-muted small">
                                                <i class="bi bi-calendar-event me-1"></i> 
                                                <?= esc($proses['tgl_mulai'] ?? '-') ?> 
                                                <i class="bi bi-arrow-right mx-1 text-secondary"></i> 
                                                <?= esc($proses['tgl_selesai'] ?? 'Sekarang') ?>
                                                <?php if (!empty($proses['durasi_hari'])): ?>
                                                    <span class="ms-2 badge bg-light text-dark border">(<?= esc($proses['durasi_hari']) ?> hari)</span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <?php if (in_array(session()->get('user_role'), ['Admin', 'Pengelola Aset'], true)) : ?>
                                            <form action="<?= base_url('proses/' . $proses['id_proses']) ?>" method="post" data-confirm="Hapus riwayat proses ini?">
                                                <?= csrf_field() ?>
                                                <input type="hidden" name="_method" value="DELETE">
                                                <button type="submit" class="btn btn-sm text-danger btn-light border-0 p-1 px-2" title="Hapus Riwayat">
                                                    <i class="bi bi-trash3"></i>
                                                </button>
                                            </form>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
        </div>

        <!-- TAB 3: Pengamanan Fisik -->
        <div class="tab-pane fade" id="security" role="tabpanel">
            <div class="clean-card p-4 mx-auto" style="max-width: 600px;">
                <h6 class="fw-bold text-dark mb-4"><i class="bi bi-shield-check text-success me-2"></i>Status Pengamanan Aset</h6>
                <form action="<?= base_url('pengamanan/' . $aset['id_aset']) ?>" method="post">
                    <?= csrf_field() ?>
                    <?php
                    $pItems = (new \App\Models\MasterPengamananItemModel())->where('is_active', 1)->findAll();
                    $pValues = [];
                    if (!empty($pengamanan['id_pengamanan'])) {
                        $rawValues = (new \App\Models\PengamananFisikValueModel())->where('id_pengamanan', $pengamanan['id_pengamanan'])->findAll();
                        foreach ($rawValues as $v) $pValues[$v['id_item']] = $v['is_checked'];
                    }
                    ?>
                    
                    <div class="mb-4">
                        <?php foreach ($pItems as $item): ?>
                            <div class="form-check form-switch mb-3 p-3 border rounded-3 bg-light d-flex align-items-center">
                                <input class="form-check-input ms-0 me-3 mt-0" type="checkbox" role="switch" name="item_<?= $item['id'] ?>" id="item_<?= $item['id'] ?>" <?= !empty($pValues[$item['id']]) ? 'checked' : '' ?>>
                                <label class="form-check-label fw-semibold text-dark flex-grow-1" style="cursor: pointer;" for="item_<?= $item['id'] ?>">
                                    <?= esc($item['label']) ?>
                                </label>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted">Tanggal Pengecekan Terakhir</label>
                            <input type="date" name="tgl_cek" class="form-control" value="<?= esc($pengamanan['tgl_cek'] ?? '') ?>">
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-bold text-muted">Catatan Kondisi Lapangan</label>
                            <textarea name="catatan" class="form-control" rows="3" placeholder="Tuliskan catatan kondisi fisik aset..."><?= esc($pengamanan['catatan'] ?? '') ?></textarea>
                        </div>
                    </div>

                    <?php if (in_array(session()->get('user_role'), ['Admin', 'Pengelola Aset', 'Petugas Lapangan'], true)) : ?>
                        <div class="text-end mt-4">
                            <button type="submit" class="btn btn-success rounded-pill px-4 shadow-sm">
                                <i class="bi bi-save2 me-1"></i> Simpan Status Pengamanan
                            </button>
                        </div>
                    <?php endif; ?>
                </form>
            </div>
        </div>

        <!-- TAB 4: Dokumen Aset -->
        <div class="tab-pane fade" id="docs" role="tabpanel">
            <?php $canManageDocs = in_array(session()->get('user_role'), ['Admin', 'Pengelola Aset', 'Petugas Lapangan'], true); ?>
            
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="mb-0 fw-bold text-dark">Arsip Dokumen Digital</h6>
                <?php if ($canManageDocs) : ?>
                    <button class="btn btn-sm btn-primary rounded-pill px-3 shadow-sm" type="button" data-bs-toggle="collapse" data-bs-target="#formUploadDokumen">
                        <i class="bi bi-cloud-arrow-up me-1"></i> Upload Dokumen
                    </button>
                <?php endif; ?>
            </div>

            <?php if ($canManageDocs) : ?>
                <div class="collapse mb-4" id="formUploadDokumen">
                    <div class="clean-card p-4" style="border-top: 3px solid #6366F1;">
                        <h6 class="fw-bold mb-3 small">Form Upload Dokumen Baru</h6>
                        <form action="<?= base_url('dokumen/' . $aset['id_aset']) ?>" method="post" enctype="multipart/form-data">
                            <?= csrf_field() ?>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label small text-muted mb-1">Jenis Dokumen</label>
                                    <input type="text" name="jenis_dokumen" class="form-control" placeholder="Cth: Sertifikat Hak Pakai" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small text-muted mb-1">Status Dokumen</label>
                                    <input type="text" name="status_dokumen" class="form-control" placeholder="Cth: Asli / Salinan">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small text-muted mb-1">Terkait Riwayat Proses (Opsional)</label>
                                    <select name="id_proses" class="form-select">
                                        <option value="">Tidak terkait riwayat tertentu</option>
                                        <?php foreach ($prosesList as $proses) : ?>
                                            <option value="<?= esc($proses['id_proses']) ?>">
                                                [<?= esc($proses['tgl_mulai'] ?? '') ?>] <?= esc($proses['nama_status'] ?? '-') ?> - <?= esc($proses['keterangan'] ?? '') ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small text-muted mb-1">Pilih File (PDF/JPG/PNG)</label>
                                    <input type="file" name="file" class="form-control" required>
                                </div>
                            </div>
                            <div class="text-end mt-3">
                                <button type="button" class="btn btn-sm btn-light me-1" data-bs-toggle="collapse" data-bs-target="#formUploadDokumen">Batal</button>
                                <button type="submit" class="btn btn-sm btn-primary px-4"><i class="bi bi-upload me-1"></i>Upload Sekarang</button>
                            </div>
                        </form>
                    </div>
                </div>
            <?php endif; ?>

            <div class="clean-card">
                <?php if (empty($dokumenList)) : ?>
                    <div class="text-center py-5 text-muted">
                        <i class="bi bi-folder-x fs-1 mb-2 d-block opacity-50"></i>
                        Belum ada dokumen yang diunggah untuk aset ini.
                    </div>
                <?php else : ?>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light text-muted small text-uppercase">
                                <tr>
                                    <th class="ps-4">Jenis Dokumen</th>
                                    <th>Status</th>
                                    <th>Tanggal Upload</th>
                                    <th class="text-end pe-4">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($dokumenList as $dok) : ?>
                                    <tr>
                                        <td class="ps-4">
                                            <div class="d-flex align-items-center">
                                                <div class="bg-light rounded p-2 me-3 text-primary">
                                                    <i class="bi bi-file-earmark-pdf fs-5"></i>
                                                </div>
                                                <div class="fw-semibold text-dark"><?= esc($dok['jenis_dokumen']) ?></div>
                                            </div>
                                        </td>
                                        <td><span class="badge bg-light text-dark border"><?= esc($dok['status_dokumen'] ?? '-') ?></span></td>
                                        <td class="text-muted small"><?= esc(date('d M Y', strtotime($dok['uploaded_at']))) ?></td>
                                        <td class="text-end pe-4">
                                            <?php if ($canManageDocs) : ?>
                                                <div class="btn-group">
                                                    <a href="<?= base_url('dokumen/view/' . $dok['id_dokumen']) ?>" class="btn btn-sm btn-outline-primary" target="_blank" title="Lihat">
                                                        <i class="bi bi-eye"></i>
                                                    </a>
                                                    <a href="<?= base_url('dokumen/download/' . $dok['id_dokumen']) ?>" class="btn btn-sm btn-outline-primary" title="Unduh">
                                                        <i class="bi bi-download"></i>
                                                    </a>
                                                    <form action="<?= base_url('dokumen/' . $dok['id_dokumen']) ?>" method="post" data-confirm="Hapus dokumen ini?" style="display:inline-block;">
                                                        <?= csrf_field() ?>
                                                        <input type="hidden" name="_method" value="DELETE">
                                                        <button type="submit" class="btn btn-sm btn-outline-danger" style="border-top-left-radius: 0; border-bottom-left-radius: 0;" title="Hapus">
                                                            <i class="bi bi-trash3"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            <?php else : ?>
                                                <span class="text-muted small"><i class="bi bi-lock"></i> Terbatas</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>

<!-- TAB 5: Arsip Fisik eLabel -->
        <div class="tab-pane fade" id="elabel" role="tabpanel">
            <div class="clean-card p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h6 class="mb-0 fw-bold text-dark"><i class="bi bi-archive text-primary me-2"></i>Status Arsip Fisik (eLabel)</h6>
                    <button class="btn btn-sm btn-outline-primary rounded-pill px-3" onclick="loadElabelArchive()" id="btnReloadElabel">
                        <i class="bi bi-arrow-clockwise"></i> Muat Ulang
                    </button>
                </div>

                <div id="elabelLoading" class="text-center py-5">
                    <div class="spinner-border text-primary mb-3" role="status"></div>
                    <p class="text-muted small">Menghubungkan ke server eLabel...</p>
                </div>

                <div id="elabelError" class="text-center py-4 d-none">
                    <i class="bi bi-exclamation-triangle fs-1 text-warning mb-2 d-block"></i>
                    <h6 class="fw-bold" id="elabelErrorMsg">Gagal memuat data</h6>
                    <p class="text-muted small">Pastikan NIB aset valid dan server eLabel aktif.</p>
                </div>

                <div id="elabelData" class="d-none">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="p-3 border rounded-3 bg-light h-100">
                                <div class="detail-label">Status Arsip Fisik</div>
                                <div class="d-flex align-items-center mt-1">
                                    <i class="bi bi-check-circle-fill text-success fs-4 me-2" id="iconArchived"></i>
                                    <span class="fw-bold fs-5 text-dark" id="lblArchived">Tersedia di Gudang Arsip</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3 border rounded-3 bg-light h-100 border-start border-4 border-primary">
                                <div class="detail-label">Lokasi Penyimpanan (Box)</div>
                                <h5 class="fw-bold text-primary mb-1 mt-1" id="lblBoxCode">-</h5>
                                <div class="text-muted small" id="lblBoxLokasi">-</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-label">Nomor Sertifikat (BPN)</div>
                            <div class="fw-semibold text-dark fs-6" id="lblNoSertifikat">-</div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-label">Atas Nama Pemilik</div>
                            <div class="fw-semibold text-dark fs-6" id="lblNamaPemilik">-</div>
                        </div>
                        <div class="col-12 mt-4 text-center" id="pdfContainer">
                            <a href="#" id="btnPdfViewer" target="_blank" class="btn btn-primary rounded-pill px-4 shadow-sm">
                                <i class="bi bi-file-earmark-pdf me-1"></i> Lihat Scan Dokumen Asli
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<div class="modal-footer bg-white border-top">
    <button type="button" class="btn btn-light rounded-pill px-4 shadow-sm border" data-bs-dismiss="modal">
        Tutup
    </button>
    <?php if (in_array(session()->get('user_role'), ['Admin', 'Pengelola Aset'], true)) : ?>
        <a href="<?= base_url('aset/' . $aset['id_aset'] . '/edit') ?>" class="btn btn-warning rounded-pill px-4 shadow-sm">
            <i class="bi bi-pencil-square me-1"></i> Edit Data Utama
        </a>
    <?php endif; ?>
</div>

<script>
(function() {
    let elabelLoaded = false;
    const currentAsetId = <?= $aset['id_aset'] ?>;
    
    const tabEl = document.getElementById('elabel-tab');
    if (tabEl) {
        tabEl.addEventListener('shown.bs.tab', function (e) {
            if (!elabelLoaded) {
                loadElabelArchive();
            }
        });
    }

    const btnReload = document.getElementById('btnReloadElabel');
    if (btnReload) {
        btnReload.addEventListener('click', loadElabelArchive);
    }

    function loadElabelArchive() {
        document.getElementById('elabelLoading').classList.remove('d-none');
        document.getElementById('elabelError').classList.add('d-none');
        document.getElementById('elabelData').classList.add('d-none');
        if(btnReload) btnReload.disabled = true;

        fetch('<?= base_url("api/arsip/cek/") ?>' + currentAsetId, { credentials: 'same-origin' })
            .then(response => response.json())
            .then(res => {
                document.getElementById('elabelLoading').classList.add('d-none');
                if(btnReload) btnReload.disabled = false;
                
                if (res.status === 200 && res.data) {
                    const data = res.data;
                    document.getElementById('elabelData').classList.remove('d-none');
                    elabelLoaded = true;

                    document.getElementById('lblNoSertifikat').textContent = data.no_sertipikat || '-';
                    document.getElementById('lblNamaPemilik').textContent = data.nama_pemilik || '-';
                    
                    if (data.is_archived) {
                        document.getElementById('iconArchived').className = 'bi bi-check-circle-fill text-success fs-4 me-2';
                        document.getElementById('lblArchived').textContent = 'Tersedia di Gudang Arsip';
                        document.getElementById('lblBoxCode').textContent = data.box_code;
                        document.getElementById('lblBoxLokasi').textContent = data.box_lokasi;
                    } else {
                        document.getElementById('iconArchived').className = 'bi bi-x-circle-fill text-danger fs-4 me-2';
                        document.getElementById('lblArchived').textContent = 'Belum Ada di Box eLabel';
                        document.getElementById('lblBoxCode').textContent = '-';
                        document.getElementById('lblBoxLokasi').textContent = '-';
                    }

                    if (data.pdf_url) {
                        document.getElementById('pdfContainer').classList.remove('d-none');
                        document.getElementById('btnPdfViewer').href = data.pdf_url;
                    } else {
                        document.getElementById('pdfContainer').classList.add('d-none');
                    }
                } else {
                    showElabelError(res.message || 'Gagal memuat data');
                }
            })
            .catch(error => {
                document.getElementById('elabelLoading').classList.add('d-none');
                if(btnReload) btnReload.disabled = false;
                showElabelError('Koneksi terputus atau API eLabel tidak bisa dihubungi.');
            });
    }

    function showElabelError(msg) {
        document.getElementById('elabelError').classList.remove('d-none');
        document.getElementById('elabelErrorMsg').textContent = msg;
    }
})();
</script>
