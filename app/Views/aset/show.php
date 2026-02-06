<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="modal fade modal-modern" id="modalForm" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="modal-title">Detail Aset</h5>
                    <small class="text-muted"><?= esc($aset['kode_aset']) ?> • <?= esc($aset['nama_aset']) ?></small>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <div class="card mb-4 border-0" style="background: rgba(59, 130, 246, 0.06);">
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <div class="text-muted small">OPD</div>
                                <div class="fw-semibold"><?= esc($aset['opd'] ?? '-') ?></div>
                            </div>
                            <div class="col-md-4">
                                <div class="text-muted small">Penggunaan</div>
                                <div class="fw-semibold"><?= esc($aset['peruntukan'] ?? '-') ?></div>
                            </div>
                            <div class="col-md-4">
                                <div class="text-muted small">Luas</div>
                                <div class="fw-semibold"><?= esc($aset['luas'] ?? '-') ?></div>
                            </div>
                            <div class="col-md-4">
                                <div class="text-muted small">Harga Perolehan</div>
                                <div class="fw-semibold">
                                    <?php if (!empty($aset['harga_perolehan'])) : ?>
                                        <?= esc(number_format((float) $aset['harga_perolehan'], 2, '.', ',')) ?>
                                    <?php else : ?>
                                        -
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="text-muted small">Tanggal Perolehan</div>
                                <div class="fw-semibold"><?= esc($aset['tanggal_perolehan'] ?? '-') ?></div>
                            </div>
                            <div class="col-md-6">
                                <div class="text-muted small">Alamat</div>
                                <div class="fw-semibold"><?= esc($aset['alamat'] ?? '-') ?></div>
                            </div>
                            <div class="col-md-3">
                                <div class="text-muted small">Lat</div>
                                <div class="fw-semibold"><?= esc($aset['lat'] ?? '-') ?></div>
                            </div>
                            <div class="col-md-3">
                                <div class="text-muted small">Lng</div>
                                <div class="fw-semibold"><?= esc($aset['lng'] ?? '-') ?></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-lg-7">
                        <div class="card mb-3 border-0" style="background: rgba(14, 165, 233, 0.08);">
                            <div class="card-header border-0" style="background: transparent;">
                                <h3 class="card-title text-primary mb-0">Timeline Proses</h3>
                            </div>
                            <div class="card-body">
                                <?php if (empty($prosesList)) : ?>
                                    <p class="text-muted mb-0">Belum ada proses.</p>
                                <?php else : ?>
                                    <ul class="list-group list-group-flush">
                                        <?php foreach ($prosesList as $proses) : ?>
                                            <li class="list-group-item">
                                                <div class="d-flex justify-content-between">
                                                    <div>
                                                        <span class="badge bg-<?= esc($proses['warna'] ?? 'secondary') ?> me-2">
                                                            <?= esc($proses['nama_status'] ?? '-') ?>
                                                        </span>
                                                        <strong><?= esc($proses['keterangan'] ?? '-') ?></strong>
                                                    </div>
                                                    <small class="text-muted">
                                                        <?= esc($proses['tgl_mulai'] ?? '-') ?> → <?= esc($proses['tgl_selesai'] ?? '-') ?>
                                                    </small>
                                                </div>
                                                <div class="text-muted small">Durasi: <?= esc($proses['durasi_hari'] ?? '-') ?> hari</div>
                                                <?php if (in_array(session()->get('user_role'), ['Admin', 'Pengelola Aset'], true)) : ?>
                                                    <form action="<?= base_url('proses/' . $proses['id_proses']) ?>" method="post" class="mt-2">
                                                        <?= csrf_field() ?>
                                                        <input type="hidden" name="_method" value="DELETE">
                                                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill" onclick="return confirm('Hapus proses ini?')">
                                                            <i class="bi bi-trash3 me-1"></i>Hapus
                                                        </button>
                                                    </form>
                                                <?php endif; ?>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php endif; ?>
                            </div>
                        </div>

                        <?php if (in_array(session()->get('user_role'), ['Admin', 'Pengelola Aset'], true)) : ?>
                            <div class="card border-0" style="background: rgba(59, 130, 246, 0.06);">
                                <div class="card-header border-0" style="background: transparent;">
                                    <h3 class="card-title text-primary mb-0">Tambah Proses</h3>
                                </div>
                                <div class="card-body">
                                    <form action="<?= base_url('proses/' . $aset['id_aset']) ?>" method="post">
                                        <?= csrf_field() ?>
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label class="form-label">Status</label>
                                                <select name="id_status" class="form-select" required>
                                                    <?php foreach ($statusList as $status) : ?>
                                                        <option value="<?= esc($status['id_status']) ?>"><?= esc($status['nama_status']) ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Keterangan</label>
                                                <input type="text" name="keterangan" class="form-control">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Tanggal Mulai</label>
                                                <input type="date" name="tgl_mulai" class="form-control">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Tanggal Selesai</label>
                                                <input type="date" name="tgl_selesai" class="form-control">
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary mt-3 rounded-pill">
                                            <i class="bi bi-save2 me-1"></i>Simpan Proses
                                        </button>
                                    </form>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="col-lg-5">
                        <div class="card mb-3 border-0" style="background: rgba(16, 185, 129, 0.08);">
                            <div class="card-header border-0" style="background: transparent;">
                                <h3 class="card-title text-success mb-0">Pengamanan Fisik</h3>
                            </div>
                            <div class="card-body">
                                <form action="<?= base_url('pengamanan/' . $aset['id_aset']) ?>" method="post">
                                    <?= csrf_field() ?>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="sertifikat_ada" id="sertifikat_ada" <?= !empty($pengamanan['sertifikat_ada']) ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="sertifikat_ada">Sertifikat Ada</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="pagar" id="pagar" <?= !empty($pengamanan['pagar']) ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="pagar">Pagar</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="papan_nama" id="papan_nama" <?= !empty($pengamanan['papan_nama']) ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="papan_nama">Papan Nama</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="dikuasai_pihak_lain" id="dikuasai_pihak_lain" <?= !empty($pengamanan['dikuasai_pihak_lain']) ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="dikuasai_pihak_lain">Dikuasai Pihak Lain</label>
                                    </div>
                                    <div class="mt-3">
                                        <label class="form-label">Tanggal Cek</label>
                                        <input type="date" name="tgl_cek" class="form-control" value="<?= esc($pengamanan['tgl_cek'] ?? '') ?>">
                                    </div>
                                    <div class="mt-3">
                                        <label class="form-label">Catatan</label>
                                        <textarea name="catatan" class="form-control" rows="3"><?= esc($pengamanan['catatan'] ?? '') ?></textarea>
                                    </div>
                                    <?php if (in_array(session()->get('user_role'), ['Admin', 'Petugas Lapangan'], true)) : ?>
                                        <button type="submit" class="btn btn-primary mt-3 rounded-pill">
                                            <i class="bi bi-shield-check me-1"></i>Simpan Pengamanan
                                        </button>
                                    <?php endif; ?>
                                </form>
                            </div>
                        </div>

                        <div class="card border-0" style="background: rgba(99, 102, 241, 0.08);">
                            <div class="card-header border-0" style="background: transparent;">
                                <h3 class="card-title text-primary mb-0">Dokumen Aset</h3>
                            </div>
                            <div class="card-body">
                                <?php if (in_array(session()->get('user_role'), ['Admin', 'Pengelola Aset', 'Petugas Lapangan'], true)) : ?>
                                    <form action="<?= base_url('dokumen/' . $aset['id_aset']) ?>" method="post" enctype="multipart/form-data" class="mb-3">
                                        <?= csrf_field() ?>
                                        <div class="mb-2">
                                            <label class="form-label">Jenis Dokumen</label>
                                            <input type="text" name="jenis_dokumen" class="form-control" required>
                                        </div>
                                        <div class="mb-2">
                                            <label class="form-label">Status Dokumen</label>
                                            <input type="text" name="status_dokumen" class="form-control">
                                        </div>
                                        <div class="mb-2">
                                            <label class="form-label">Terkait Proses</label>
                                            <select name="id_proses" class="form-select">
                                                <option value="">Tidak terkait</option>
                                                <?php foreach ($prosesList as $proses) : ?>
                                                    <option value="<?= esc($proses['id_proses']) ?>">
                                                        <?= esc($proses['nama_status'] ?? '-') ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="mb-2">
                                            <input type="file" name="file" class="form-control" required>
                                        </div>
                                        <button type="submit" class="btn btn-primary rounded-pill">
                                            <i class="bi bi-upload me-1"></i>Upload Dokumen
                                        </button>
                                    </form>
                                <?php endif; ?>

                                <?php if (empty($dokumenList)) : ?>
                                    <p class="text-muted mb-0">Belum ada dokumen.</p>
                                <?php else : ?>
                                    <ul class="list-group list-group-flush">
                                        <?php foreach ($dokumenList as $dok) : ?>
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                <div>
                                                    <div class="fw-semibold"><?= esc($dok['jenis_dokumen']) ?></div>
                                                    <small class="text-muted"><?= esc($dok['status_dokumen'] ?? '-') ?></small>
                                                </div>
                                                <div class="d-flex gap-2">
                                                    <a href="<?= base_url('dokumen/view/' . $dok['id_dokumen']) ?>" class="btn btn-sm btn-outline-primary rounded-pill" target="_blank" rel="noopener">
                                                        <i class="bi bi-eye me-1"></i>Lihat
                                                    </a>
                                                    <a href="<?= base_url('dokumen/download/' . $dok['id_dokumen']) ?>" class="btn btn-sm btn-outline-secondary rounded-pill">
                                                        <i class="bi bi-download me-1"></i>Unduh
                                                    </a>
                                                    <?php if (in_array(session()->get('user_role'), ['Admin', 'Pengelola Aset', 'Petugas Lapangan'], true)) : ?>
                                                        <form action="<?= base_url('dokumen/' . $dok['id_dokumen']) ?>" method="post">
                                                            <?= csrf_field() ?>
                                                            <input type="hidden" name="_method" value="DELETE">
                                                            <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill" onclick="return confirm('Hapus dokumen ini?')">
                                                                <i class="bi bi-trash3 me-1"></i>Hapus
                                                            </button>
                                                        </form>
                                                    <?php endif; ?>
                                                </div>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="<?= base_url('aset') ?>" class="btn btn-outline-secondary rounded-pill">
                    <i class="bi bi-arrow-left me-1"></i>Kembali
                </a>
                <?php if (in_array(session()->get('user_role'), ['Admin', 'Pengelola Aset'], true)) : ?>
                    <a href="<?= base_url('aset/' . $aset['id_aset'] . '/edit') ?>" class="btn btn-primary rounded-pill">
                        <i class="bi bi-pencil-square me-1"></i>Edit
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const modalEl = document.getElementById('modalForm');
        if (!modalEl || typeof bootstrap === 'undefined') return;
        const modal = new bootstrap.Modal(modalEl, { backdrop: 'static' });
        modal.show();
        modalEl.addEventListener('hidden.bs.modal', function () {
            window.location.href = '<?= base_url('aset') ?>';
        });
    });
</script>
<?= $this->endSection() ?>
