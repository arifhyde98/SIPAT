<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 fw-bold text-primary-emphasis">Data Desa & Kelurahan</h1>
        <p class="text-muted mb-0">Manajemen data wilayah administratif desa di Kabupaten Donggala.</p>
    </div>
    <button type="button" class="btn btn-primary btn-lg shadow-sm" data-bs-toggle="modal" data-bs-target="#modalDesa">
        <i class="bi bi-plus-lg me-2"></i>Tambah Data
    </button>
</div>

<div class="row g-4">
    <!-- Statistik Cards -->
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100 overflow-hidden position-relative" style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);">
            <div class="card-body text-white position-relative z-1">
                <div class="d-flex align-items-center mb-2">
                    <div class="bg-white bg-opacity-25 rounded p-2 me-3">
                        <i class="bi bi-geo-alt-fill fs-4"></i>
                    </div>
                    <h6 class="mb-0 text-white-50 text-uppercase small fw-bold">Total Wilayah</h6>
                </div>
                <h2 class="mb-0 fw-bold display-6"><?= esc($totalDesa ?? 0) ?></h2>
            </div>
            <i class="bi bi-map position-absolute text-white opacity-10" style="font-size: 6rem; right: -20px; bottom: -20px;"></i>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100 overflow-hidden position-relative" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
            <div class="card-body text-white position-relative z-1">
                <div class="d-flex align-items-center mb-2">
                    <div class="bg-white bg-opacity-25 rounded p-2 me-3">
                        <i class="bi bi-house-door-fill fs-4"></i>
                    </div>
                    <h6 class="mb-0 text-white-50 text-uppercase small fw-bold">Desa</h6>
                </div>
                <h2 class="mb-0 fw-bold display-6"><?= esc($totalDesaOnly ?? 0) ?></h2>
            </div>
            <i class="bi bi-tree position-absolute text-white opacity-10" style="font-size: 6rem; right: -20px; bottom: -20px;"></i>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100 overflow-hidden position-relative" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
            <div class="card-body text-white position-relative z-1">
                <div class="d-flex align-items-center mb-2">
                    <div class="bg-white bg-opacity-25 rounded p-2 me-3">
                        <i class="bi bi-building-fill fs-4"></i>
                    </div>
                    <h6 class="mb-0 text-white-50 text-uppercase small fw-bold">Kelurahan</h6>
                </div>
                <h2 class="mb-0 fw-bold display-6"><?= esc($totalKelurahan ?? 0) ?></h2>
            </div>
            <i class="bi bi-buildings position-absolute text-white opacity-10" style="font-size: 6rem; right: -20px; bottom: -20px;"></i>
        </div>
    </div>

    <!-- Main Table -->
    <div class="col-12">
        <div class="card border-0 fancy-card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-premium align-middle js-datatable">
                        <thead class="bg-light">
                            <tr>
                                <th width="5%">No</th>
                                <th>Nama Wilayah</th>
                                <th>Jenis</th>
                                <th>Kecamatan</th>
                                <th>Kode Wilayah</th>
                                <th width="10%" class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach (($desaList ?? []) as $i => $d) : ?>
                                <tr>
                                    <td><?= $i + 1 ?></td>
                                    <td>
                                        <div class="fw-semibold text-dark"><?= esc($d['nama']) ?></div>
                                    </td>
                                    <td>
                                        <?php if (strtolower($d['jenis']) === 'kelurahan') : ?>
                                            <span class="badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25 rounded-pill px-3">
                                                Kelurahan
                                            </span>
                                        <?php else : ?>
                                            <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 rounded-pill px-3">
                                                Desa
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= esc($d['kecamatan_nama'] ?? '-') ?></td>
                                    <td class="font-monospace text-muted"><?= esc($d['kode_wilayah'] ?? '-') ?></td>
                                    <td class="text-end">
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-sm btn-light text-primary" 
                                                onclick='editDesa(<?= json_encode($d) ?>)' title="Edit">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>
                                            <form action="<?= base_url('master/desa/' . $d['id']) ?>" method="post" class="d-inline" data-confirm="Hapus data desa ini?">
                                                <?= csrf_field() ?>
                                                <input type="hidden" name="_method" value="DELETE">
                                                <button type="submit" class="btn btn-sm btn-light text-danger" title="Hapus">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Add/Edit -->
<div class="modal fade modal-modern" id="modalDesa" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?= base_url('master/desa') ?>" method="post">
                <?= csrf_field() ?>
                <input type="hidden" name="id" id="desaId">
                <input type="hidden" name="_method" id="methodField" value="POST">
                
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">
                        <i class="bi bi-plus-circle me-2 text-primary"></i>Tambah Desa Baru
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold small text-uppercase text-muted">Kecamatan</label>
                        <select name="kecamatan_id" id="kecamatanId" class="form-select" required>
                            <option value="">- Pilih Kecamatan -</option>
                            <?php foreach (($kecamatanList ?? []) as $k) : ?>
                                <option value="<?= $k['id'] ?>"><?= esc($k['nama']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold small text-uppercase text-muted">Nama Wilayah</label>
                        <input type="text" name="nama" id="namaDesa" class="form-control" placeholder="Contoh: Kabonga Kecil" required>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small text-uppercase text-muted">Jenis</label>
                            <select name="jenis" id="jenisDesa" class="form-select" required>
                                <option value="Desa">Desa</option>
                                <option value="Kelurahan">Kelurahan</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small text-uppercase text-muted">Kode Wilayah</label>
                            <input type="text" name="kode_wilayah" id="kodeWilayah" class="form-control" placeholder="Opsional">
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary px-4">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    function editDesa(data) {
        document.getElementById('modalTitle').innerHTML = '<i class="bi bi-pencil-square me-2 text-primary"></i>Edit Data Desa';
        document.getElementById('desaId').value = data.id;
        document.getElementById('methodField').value = 'PUT';
        document.getElementById('kecamatanId').value = data.kecamatan_id;
        document.getElementById('namaDesa').value = data.nama;
        document.getElementById('jenisDesa').value = data.jenis;
        document.getElementById('kodeWilayah').value = data.kode_wilayah;
        
        const modalEl = document.getElementById('modalDesa');
        const modal = new bootstrap.Modal(modalEl);
        modal.show();
        
        modalEl.addEventListener('hidden.bs.modal', function () {
            document.getElementById('modalTitle').innerHTML = '<i class="bi bi-plus-circle me-2 text-primary"></i>Tambah Desa Baru';
            document.getElementById('desaId').value = '';
            document.getElementById('methodField').value = 'POST';
            modalEl.querySelector('form').reset();
        }, { once: true });
    }
</script>
<?= $this->endSection() ?>