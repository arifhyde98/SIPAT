<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h4 fw-semibold mb-1">Generate Surat Tanah - SKPT</h1>
        <small class="text-muted">Isi data pemohon dan detail tanah, lalu simpan untuk preview.</small>
    </div>
</div>

<div class="row g-3">
    <div class="col-lg-7">
        <div class="card border-0 fancy-card mb-3">
            <div class="card-body">
                <form method="post" action="<?= base_url('surat/skpt') ?>">
                    <?= csrf_field() ?>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Nomor Surat (opsional)</label>
                            <input type="text" name="nomor_surat" class="form-control" placeholder="SKPT-20260206-1234">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tanggal Surat</label>
                            <input type="date" name="tanggal_surat" class="form-control" required>
                        </div>
                        <div class="col-12">
                            <h6 class="text-primary">Data Pemohon</h6>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Pilih Pemohon</label>
                            <select name="pemohon_id" id="pemohonSelect" class="form-select" required>
                                <option value="">- pilih pemohon -</option>
                                <?php foreach ($pemohonList ?? [] as $pemohon) : ?>
                                    <option
                                        value="<?= esc($pemohon['id']) ?>"
                                        data-nama="<?= esc($pemohon['nama']) ?>"
                                        data-nik="<?= esc($pemohon['nik'] ?? '') ?>"
                                        data-ttl="<?= esc($pemohon['ttl'] ?? '') ?>"
                                        data-jk="<?= esc($pemohon['jenis_kelamin'] ?? '') ?>"
                                        data-wn="<?= esc($pemohon['warga_negara'] ?? '') ?>"
                                        data-agama="<?= esc($pemohon['agama'] ?? '') ?>"
                                        data-pekerjaan="<?= esc($pemohon['pekerjaan'] ?? '') ?>"
                                        data-alamat="<?= esc($pemohon['alamat'] ?? '') ?>"
                                    >
                                        <?= esc($pemohon['nama']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <small class="text-muted">Jika dipilih, data pemohon otomatis terisi.</small>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Nama Pemohon</label>
                            <input type="text" id="pemohonNama" class="form-control" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">NIK</label>
                            <input type="text" id="pemohonNik" class="form-control" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tempat, Tgl Lahir</label>
                            <input type="text" id="pemohonTtl" class="form-control" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Jenis Kelamin</label>
                            <select id="pemohonJk" class="form-select" disabled>
                                <option value="">- pilih -</option>
                                <option value="Laki-laki">Laki-laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Warga Negara</label>
                            <input type="text" id="pemohonWn" class="form-control" readonly>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Agama</label>
                            <input type="text" id="pemohonAgama" class="form-control" readonly>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Pekerjaan</label>
                            <input type="text" id="pemohonPekerjaan" class="form-control" readonly>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Alamat Pemohon</label>
                            <textarea id="pemohonAlamat" class="form-control" rows="2" readonly></textarea>
                        </div>
                        <div class="col-12">
                            <h6 class="text-primary">Data Tanah</h6>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Desa/Kelurahan</label>
                            <select name="desa_id" id="desaSelect" class="form-select" required>
                                <option value="">- pilih desa -</option>
                                <?php foreach ($desaList ?? [] as $desa) : ?>
                                    <option value="<?= esc($desa['id']) ?>"><?= esc($desa['nama']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Lokasi Tanah</label>
                            <textarea name="lokasi_tanah" class="form-control" rows="2"></textarea>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Luas (m2)</label>
                            <input type="number" step="0.01" name="luas_tanah" class="form-control">
                        </div>
                        <div class="col-md-8">
                            <label class="form-label">Dasar Perolehan</label>
                            <input type="text" name="dasar_perolehan" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Batas Utara</label>
                            <input type="text" name="batas_utara" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Batas Timur</label>
                            <input type="text" name="batas_timur" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Batas Selatan</label>
                            <input type="text" name="batas_selatan" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Batas Barat</label>
                            <input type="text" name="batas_barat" class="form-control">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Keterangan</label>
                            <textarea name="keterangan" class="form-control" rows="2"></textarea>
                        </div>
                        <div class="col-12">
                            <h6 class="text-primary">Pejabat</h6>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Pilih Kepala Desa</label>
                            <select name="kepala_desa_id" id="kepalaDesaSelect" class="form-select" required>
                                <option value="">- pilih kepala desa -</option>
                                <?php foreach ($kepalaList ?? [] as $kepala) : ?>
                                    <option
                                        value="<?= esc($kepala['id']) ?>"
                                        data-desa="<?= esc($kepala['desa_id']) ?>"
                                        data-nama="<?= esc($kepala['nama']) ?>"
                                        data-nip="<?= esc($kepala['nip'] ?? '') ?>"
                                    >
                                        <?= esc($kepala['nama']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <small class="text-muted">Jika dipilih, nama & NIP otomatis terisi.</small>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Nama Kepala Desa</label>
                            <input type="text" id="kepalaDesaNama" class="form-control" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">NIP Kepala Desa</label>
                            <input type="text" id="kepalaDesaNip" class="form-control" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Pilih Camat</label>
                            <select name="camat_id" id="camatSelect" class="form-select" required>
                                <option value="">- pilih camat -</option>
                                <?php foreach ($camatList ?? [] as $camat) : ?>
                                    <option
                                        value="<?= esc($camat['id']) ?>"
                                        data-nama="<?= esc($camat['nama']) ?>"
                                        data-nip="<?= esc($camat['nip'] ?? '') ?>"
                                    >
                                        <?= esc($camat['nama']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <small class="text-muted">Jika dipilih, nama & NIP otomatis terisi.</small>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Nama Camat</label>
                            <input type="text" id="camatNama" class="form-control" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">NIP Camat</label>
                            <input type="text" id="camatNip" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="mt-3 d-flex justify-content-end">
                        <button class="btn btn-primary">Simpan & Preview</button>
                    </div>
                </form>
            </div>
        </div>

        <?php if (!empty($recent)) : ?>
            <div class="card border-0 fancy-card">
                <div class="card-body">
                    <h6 class="fw-semibold">SKPT Terbaru</h6>
                    <div class="table-responsive">
                        <table class="table align-middle mb-0 table-premium">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nomor Surat</th>
                                    <th>Pemohon</th>
                                    <th>Tanggal</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($recent as $r) : ?>
                                    <tr>
                                        <td><?= esc($r['id']) ?></td>
                                        <td><?= esc($r['nomor_surat']) ?></td>
                                        <td><?= esc($r['pemohon_nama'] ?? '-') ?></td>
                                        <td><?= esc($r['tanggal_surat'] ?? '-') ?></td>
                                        <td>
                                            <a href="<?= base_url('surat/skpt/' . $r['id']) ?>" class="btn btn-sm btn-outline-primary">Preview</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <div class="col-lg-5">
        <div class="card border-0 fancy-card">
            <div class="card-body">
                <h6 class="fw-semibold mb-3">Preview SKPT</h6>
                <?php if (empty($skpt)) : ?>
                    <p class="text-muted mb-0">Isi form dan simpan untuk melihat preview.</p>
                <?php else : ?>
                    <div class="border p-3" style="background: #fff;">
                        <div class="text-center" style="font-size: 12px; line-height: 1.4;">
                            <div class="fw-semibold">PEMERINTAH KABUPATEN DONGGALA</div>
                            <div class="fw-semibold">KECAMATAN BANAWA</div>
                            <div class="text-danger fw-semibold">DESA/KELURAHAN <?= esc($skpt['desa_nama'] ?? '-') ?></div>
                            <div class="fw-semibold">SURAT KETERANGAN PENGUASAAN TANAH</div>
                            <div class="mt-2">NOMOR : <?= esc($skpt['nomor_surat']) ?></div>
                        </div>
                        <hr>
                        <div style="font-size: 12px; line-height: 1.5;">
                            Yang bertanda tangan di bawah ini Lurah Kabonga Kecil Kecamatan Banawa Kabupaten Donggala
                            menerangkan bahwa yang bersangkutan:
                            <div class="mt-2">
                                <div>Nama: <?= esc($skpt['pemohon_nama'] ?? '-') ?></div>
                                <div>NIK: <?= esc($skpt['pemohon_nik'] ?? '-') ?></div>
                                <div>TTL: <?= esc($skpt['pemohon_ttl'] ?? '-') ?></div>
                                <div>Jenis Kelamin: <?= esc($skpt['pemohon_jk'] ?? '-') ?></div>
                                <div>Warga Negara: <?= esc($skpt['pemohon_wn'] ?? '-') ?></div>
                                <div>Agama: <?= esc($skpt['pemohon_agama'] ?? '-') ?></div>
                                <div>Pekerjaan: <?= esc($skpt['pemohon_pekerjaan'] ?? '-') ?></div>
                                <div>Alamat: <?= esc($skpt['pemohon_alamat'] ?? '-') ?></div>
                            </div>
                            <div class="mt-3">
                                Menguasai sebidang tanah yang terletak di:
                                <div><?= esc($skpt['lokasi_tanah'] ?? '-') ?></div>
                                <div>Luas: <?= esc($skpt['luas_tanah'] ?? '-') ?> m2</div>
                                <div>Dasar Perolehan: <?= esc($skpt['dasar_perolehan'] ?? '-') ?></div>
                            </div>
                            <div class="mt-3">
                                Dengan batas-batas:
                                <div>Sebelah Utara: <?= esc($skpt['batas_utara'] ?? '-') ?></div>
                                <div>Sebelah Timur: <?= esc($skpt['batas_timur'] ?? '-') ?></div>
                                <div>Sebelah Selatan: <?= esc($skpt['batas_selatan'] ?? '-') ?></div>
                                <div>Sebelah Barat: <?= esc($skpt['batas_barat'] ?? '-') ?></div>
                            </div>
                            <div class="mt-3">
                                Keterangan: <?= esc($skpt['keterangan'] ?? '-') ?>
                            </div>
                            <div class="mt-4 text-end">
                                Kabonga Kecil, <?= esc($skpt['tanggal_surat'] ?? '-') ?>
                            </div>
                            <div class="mt-4 d-flex justify-content-between">
                                <div class="text-center">
                                    Mengetahui,<br>
                                    Camat Banawa<br><br><br>
                                    <strong><?= esc($skpt['camat_nama'] ?? '-') ?></strong><br>
                                    <?= esc($skpt['camat_nip'] ?? '') ?>
                                </div>
                                <div class="text-center">
                                    Kepala Desa <?= esc($skpt['desa_nama'] ?? '-') ?><br><br><br>
                                    <strong><?= esc($skpt['kepala_desa_nama'] ?? '-') ?></strong><br>
                                    <?= esc($skpt['kepala_desa_nip'] ?? '') ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const desaSelect = document.getElementById('desaSelect');
        const kepalaSelect = document.getElementById('kepalaDesaSelect');
        const pemohonSelect = document.getElementById('pemohonSelect');
        const camatSelect = document.getElementById('camatSelect');
        if (!desaSelect || !kepalaSelect) return;

        const allOptions = Array.from(kepalaSelect.options);
        const filterKepala = () => {
            const desaId = desaSelect.value;
            kepalaSelect.innerHTML = '';
            allOptions.forEach(opt => {
                if (opt.value === '') {
                    kepalaSelect.appendChild(opt.cloneNode(true));
                    return;
                }
                if (desaId === '' || opt.dataset.desa === desaId) {
                    kepalaSelect.appendChild(opt.cloneNode(true));
                }
            });
        };

        const kepalaNama = document.getElementById('kepalaDesaNama');
        const kepalaNip = document.getElementById('kepalaDesaNip');
        const camatNama = document.getElementById('camatNama');
        const camatNip = document.getElementById('camatNip');

        const updateKepalaInfo = () => {
            const opt = kepalaSelect.selectedOptions[0];
            if (!opt || opt.value === '') {
                if (kepalaNama) kepalaNama.value = '';
                if (kepalaNip) kepalaNip.value = '';
                return;
            }
            if (kepalaNama) kepalaNama.value = opt.dataset.nama || '';
            if (kepalaNip) kepalaNip.value = opt.dataset.nip || '';
        };

        const updateCamatInfo = () => {
            const opt = camatSelect ? camatSelect.selectedOptions[0] : null;
            if (!opt || opt.value === '') {
                if (camatNama) camatNama.value = '';
                if (camatNip) camatNip.value = '';
                return;
            }
            if (camatNama) camatNama.value = opt.dataset.nama || '';
            if (camatNip) camatNip.value = opt.dataset.nip || '';
        };

        const updatePemohonInfo = () => {
            if (!pemohonSelect) return;
            const opt = pemohonSelect.selectedOptions[0];
            const nama = document.getElementById('pemohonNama');
            const nik = document.getElementById('pemohonNik');
            const ttl = document.getElementById('pemohonTtl');
            const jk = document.getElementById('pemohonJk');
            const wn = document.getElementById('pemohonWn');
            const agama = document.getElementById('pemohonAgama');
            const pekerjaan = document.getElementById('pemohonPekerjaan');
            const alamat = document.getElementById('pemohonAlamat');

            if (!opt || opt.value === '') {
                if (nama) nama.value = '';
                if (nik) nik.value = '';
                if (ttl) ttl.value = '';
                if (jk) jk.value = '';
                if (wn) wn.value = '';
                if (agama) agama.value = '';
                if (pekerjaan) pekerjaan.value = '';
                if (alamat) alamat.value = '';
                return;
            }
            if (nama) nama.value = opt.dataset.nama || '';
            if (nik) nik.value = opt.dataset.nik || '';
            if (ttl) ttl.value = opt.dataset.ttl || '';
            if (jk) jk.value = opt.dataset.jk || '';
            if (wn) wn.value = opt.dataset.wn || '';
            if (agama) agama.value = opt.dataset.agama || '';
            if (pekerjaan) pekerjaan.value = opt.dataset.pekerjaan || '';
            if (alamat) alamat.value = opt.dataset.alamat || '';
        };

        desaSelect.addEventListener('change', () => {
            filterKepala();
            updateKepalaInfo();
        });
        kepalaSelect.addEventListener('change', updateKepalaInfo);
        if (camatSelect) camatSelect.addEventListener('change', updateCamatInfo);
        if (pemohonSelect) pemohonSelect.addEventListener('change', updatePemohonInfo);

        filterKepala();
        updateKepalaInfo();
        updateCamatInfo();
        updatePemohonInfo();
    });
</script>
<?= $this->endSection() ?>
