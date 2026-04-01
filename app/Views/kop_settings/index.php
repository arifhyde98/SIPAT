<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h4 fw-semibold mb-1">Master KOP</h1>
        <small class="text-muted">Atur identitas resmi untuk laporan PDF dan dokumen cetak SIPAT.</small>
    </div>
</div>

<style>
    .kop-shell {
        display: grid;
        grid-template-columns: minmax(0, 1.2fr) minmax(320px, 0.8fr);
        gap: 1.25rem;
    }
    @media (max-width: 991.98px) {
        .kop-shell {
            grid-template-columns: 1fr;
        }
    }
    .kop-card {
        border: 0;
        border-radius: 18px;
        box-shadow: 0 16px 36px rgba(15, 23, 42, 0.08);
    }
    .kop-preview {
        background: linear-gradient(180deg, #fff, #f8fafc);
        border: 1px solid #e2e8f0;
        border-radius: 18px;
        padding: 1.5rem;
    }
    .kop-header {
        display: grid;
        grid-template-columns: 84px 1fr;
        gap: 1rem;
        align-items: center;
        padding-bottom: 1rem;
        border-bottom: 4px double #1e293b;
        margin-bottom: 1rem;
    }
    .kop-logo {
        width: 84px;
        height: 84px;
        border-radius: 18px;
        border: 1px solid #dbe3ef;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #fff;
        overflow: hidden;
    }
    .kop-logo img {
        width: 100%;
        height: 100%;
        object-fit: contain;
    }
    .kop-title-main {
        font-size: 1.05rem;
        font-weight: 800;
        letter-spacing: .06em;
        color: #0f172a;
    }
    .kop-title-sub {
        font-size: 1.15rem;
        font-weight: 800;
        color: #0b4f84;
    }
    .kop-title-mini {
        color: #475569;
        font-size: .92rem;
    }
    .preview-paper {
        background: #fff;
        border-radius: 18px;
        padding: 1.25rem;
        border: 1px solid #e2e8f0;
    }
</style>

<div class="kop-shell">
    <div class="card kop-card">
        <div class="card-body p-4">
            <form method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Nama Instansi</label>
                        <input type="text" name="kop_nama_instansi" class="form-control" value="<?= esc($settings['kop_nama_instansi'] ?? $defaults['kop_nama_instansi']) ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Nama Unit / Aplikasi</label>
                        <input type="text" name="kop_nama_unit" class="form-control" value="<?= esc($settings['kop_nama_unit'] ?? $defaults['kop_nama_unit']) ?>">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Sub Unit</label>
                        <input type="text" name="kop_subunit" class="form-control" value="<?= esc($settings['kop_subunit'] ?? $defaults['kop_subunit']) ?>">
                    </div>
                    <div class="col-md-8">
                        <label class="form-label">Alamat</label>
                        <textarea name="kop_alamat" class="form-control" rows="2"><?= esc($settings['kop_alamat'] ?? $defaults['kop_alamat']) ?></textarea>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Kontak</label>
                        <textarea name="kop_kontak" class="form-control" rows="2"><?= esc($settings['kop_kontak'] ?? $defaults['kop_kontak']) ?></textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Nama Laporan Aset</label>
                        <input type="text" name="kop_nama_laporan_aset" class="form-control" value="<?= esc($settings['kop_nama_laporan_aset'] ?? $defaults['kop_nama_laporan_aset']) ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Kota Tanda Tangan</label>
                        <input type="text" name="kop_kota_ttd" class="form-control" value="<?= esc($settings['kop_kota_ttd'] ?? $defaults['kop_kota_ttd']) ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Jabatan Penandatangan</label>
                        <input type="text" name="kop_pejabat_jabatan" class="form-control" value="<?= esc($settings['kop_pejabat_jabatan'] ?? $defaults['kop_pejabat_jabatan']) ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Nama Penandatangan</label>
                        <input type="text" name="kop_pejabat_nama" class="form-control" value="<?= esc($settings['kop_pejabat_nama'] ?? $defaults['kop_pejabat_nama']) ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">NIP Penandatangan</label>
                        <input type="text" name="kop_pejabat_nip" class="form-control" value="<?= esc($settings['kop_pejabat_nip'] ?? $defaults['kop_pejabat_nip']) ?>">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Footer Dokumen</label>
                        <input type="text" name="kop_footer" class="form-control" value="<?= esc($settings['kop_footer'] ?? $defaults['kop_footer']) ?>">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Logo KOP</label>
                        <input type="file" name="kop_logo" class="form-control">
                        <div class="form-text">Format yang didukung: jpg, jpeg, png, webp.</div>
                    </div>
                </div>
                <div class="mt-4">
                    <button class="btn btn-primary">Simpan Master KOP</button>
                </div>
            </form>
        </div>
    </div>

    <div class="kop-preview">
        <div class="preview-paper">
            <div class="kop-header">
                <div class="kop-logo">
                    <?php if (!empty($settings['kop_logo'])) : ?>
                        <img src="<?= base_url('kop-settings/media/' . $settings['kop_logo']) ?>" alt="Logo KOP">
                    <?php else : ?>
                        <span class="text-muted small text-center px-2">Logo</span>
                    <?php endif; ?>
                </div>
                <div class="text-center">
                    <div class="kop-title-main"><?= esc($settings['kop_nama_instansi'] ?? $defaults['kop_nama_instansi']) ?></div>
                    <div class="kop-title-sub"><?= esc($settings['kop_nama_unit'] ?? $defaults['kop_nama_unit']) ?></div>
                    <div class="kop-title-mini"><?= esc($settings['kop_subunit'] ?? $defaults['kop_subunit']) ?></div>
                    <div class="kop-title-mini"><?= esc($settings['kop_alamat'] ?? $defaults['kop_alamat']) ?></div>
                    <div class="kop-title-mini"><?= esc($settings['kop_kontak'] ?? $defaults['kop_kontak']) ?></div>
                </div>
            </div>
            <div class="text-center mb-3">
                <div class="fw-bold fs-5"><?= esc($settings['kop_nama_laporan_aset'] ?? $defaults['kop_nama_laporan_aset']) ?></div>
                <div class="text-muted small">Preview tampilan header laporan PDF SIPAT</div>
            </div>
            <div class="small text-muted">
                Footer:
                <strong><?= esc($settings['kop_footer'] ?? $defaults['kop_footer']) ?></strong>
            </div>
            <div class="small text-muted mt-3">
                Tanda tangan:
                <strong><?= esc($settings['kop_pejabat_jabatan'] ?? $defaults['kop_pejabat_jabatan']) ?></strong>,
                <?= esc($settings['kop_pejabat_nama'] ?? $defaults['kop_pejabat_nama']) ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

