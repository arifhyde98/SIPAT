<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h4 fw-semibold mb-1">Edit Pemohon</h1>
        <small class="text-muted">Perbarui data pemohon.</small>
    </div>
</div>

<div class="card border-0 fancy-card">
    <div class="card-body">
        <form method="post" action="<?= base_url('master/pemohon/' . $row['id']) ?>">
            <?= csrf_field() ?>
            <div class="mb-3">
                <label class="form-label">Nama Pemohon</label>
                <input type="text" name="nama" class="form-control" value="<?= esc($row['nama']) ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">NIK</label>
                <input type="text" name="nik" class="form-control" value="<?= esc($row['nik'] ?? '') ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">Tempat, Tgl Lahir</label>
                <input type="text" name="ttl" class="form-control" value="<?= esc($row['ttl'] ?? '') ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">Jenis Kelamin</label>
                <select name="jenis_kelamin" class="form-select">
                    <option value="">- pilih -</option>
                    <option value="Laki-laki" <?= ($row['jenis_kelamin'] ?? '') === 'Laki-laki' ? 'selected' : '' ?>>Laki-laki</option>
                    <option value="Perempuan" <?= ($row['jenis_kelamin'] ?? '') === 'Perempuan' ? 'selected' : '' ?>>Perempuan</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Warga Negara</label>
                <input type="text" name="warga_negara" class="form-control" value="<?= esc($row['warga_negara'] ?? '') ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">Agama</label>
                <input type="text" name="agama" class="form-control" value="<?= esc($row['agama'] ?? '') ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">Pekerjaan</label>
                <input type="text" name="pekerjaan" class="form-control" value="<?= esc($row['pekerjaan'] ?? '') ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">Alamat</label>
                <textarea name="alamat" class="form-control" rows="2"><?= esc($row['alamat'] ?? '') ?></textarea>
            </div>
            <div class="d-flex gap-2">
                <button class="btn btn-primary">Simpan</button>
                <a href="<?= base_url('master/pemohon') ?>" class="btn btn-light">Batal</a>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
