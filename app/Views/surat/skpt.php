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
                            <label class="form-label">Alamat Kantor (Kop Surat)</label>
                            <input type="text" name="alamat_kantor" class="form-control" placeholder="Contoh: Jl. Poros Palu – Mamuju Kel. Kabonga Kecil Kec. Banawa">
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
                                        data-umur="<?= esc($pemohon['umur'] ?? '') ?>"
                                        data-jk="<?= esc($pemohon['jenis_kelamin'] ?? '') ?>"
                                        data-wn="<?= esc($pemohon['warga_negara'] ?? '') ?>"
                                        data-agama="<?= esc($pemohon['agama'] ?? '') ?>"
                                        data-pekerjaan="<?= esc($pemohon['pekerjaan'] ?? '') ?>"
                                        data-jabatan="<?= esc($pemohon['jabatan'] ?? '') ?>"
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
                            <label class="form-label">Umur</label>
                            <input type="text" id="pemohonUmur" class="form-control" readonly>
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
                        <div class="col-md-6">
                            <label class="form-label">Jabatan</label>
                            <input type="text" id="pemohonJabatan" class="form-control" readonly>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Alamat Pemohon</label>
                            <textarea id="pemohonAlamat" class="form-control" rows="2" readonly></textarea>
                        </div>
                        <div class="col-12">
                            <h6 class="text-primary">Data Tanah</h6>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Kecamatan</label>
                            <select name="kecamatan_id" id="kecamatanSelect" class="form-select" required>
                                <option value="">- pilih kecamatan -</option>
                                <?php foreach ($kecamatanList ?? [] as $kecamatan) : ?>
                                    <option value="<?= esc($kecamatan['id']) ?>"><?= esc($kecamatan['nama']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Desa/Kelurahan</label>
                            <select name="desa_id" id="desaSelect" class="form-select" required>
                                <option value="">- pilih desa -</option>
                                <?php foreach ($desaList ?? [] as $desa) : ?>
                                    <option value="<?= esc($desa['id']) ?>" data-kec="<?= esc($desa['kecamatan_id'] ?? '') ?>">
                                        <?= esc($desa['nama']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Lokasi Tanah</label>
                            <textarea name="lokasi_tanah" class="form-control" rows="2"></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Jenis Tanah</label>
                            <input type="text" name="jenis_tanah" class="form-control" placeholder="Pekarangan dan Bangunan">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Status Tanah</label>
                            <input type="text" name="status_tanah" class="form-control" placeholder="Tanah negara (bekas tanah Swapraja)">
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
                            <label class="form-label">Asal / Riwayat Tanah</label>
                            <textarea name="asal_tanah" class="form-control" rows="2" placeholder="Selanjutnya diterangkan bahwa bidang tanah tersebut berasal dari ..."></textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Pernyataan Tanah</label>
                            <textarea name="pernyataan_tanah" class="form-control" rows="2" placeholder="Bahwa tanah tersebut merupakan tanah Non Pertanian ..."></textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Keterangan</label>
                            <textarea name="keterangan" class="form-control" rows="2"></textarea>
                        </div>
                        <div class="col-12">
                            <h6 class="text-primary">Pejabat</h6>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Pilih Kepala Desa / Lurah</label>
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
                            <label class="form-label">Nama Kepala Desa / Lurah</label>
                            <input type="text" id="kepalaDesaNama" class="form-control" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">NIP Kepala Desa / Lurah</label>
                            <input type="text" id="kepalaDesaNip" class="form-control" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Pilih Camat</label>
                            <select name="camat_id" id="camatSelect" class="form-select" required>
                                <option value="">- pilih camat -</option>
                                <?php foreach ($camatList ?? [] as $camat) : ?>
                                    <option
                                        value="<?= esc($camat['id']) ?>"
                                        data-kec="<?= esc($camat['kecamatan_id'] ?? '') ?>"
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
                    <form method="get" action="<?= current_url() ?>" class="row g-2 align-items-end mb-3">
                        <div class="col-md-8">
                            <label class="form-label">Filter Kecamatan</label>
                            <select name="kecamatan_id" class="form-select">
                                <option value="">- semua kecamatan -</option>
                                <?php foreach ($kecamatanList ?? [] as $kecamatan) : ?>
                                    <option value="<?= esc($kecamatan['id']) ?>" <?= ((int) ($filterKecamatan ?? 0) === (int) $kecamatan['id']) ? 'selected' : '' ?>>
                                        <?= esc($kecamatan['nama']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <button class="btn btn-outline-primary w-100">Terapkan</button>
                        </div>
                    </form>
                    <div class="table-responsive">
                        <table class="table align-middle mb-0 table-premium">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nomor Surat</th>
                                    <th>Pemohon</th>
                                    <th>Kecamatan</th>
                                    <th>Tanggal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($recent as $r) : ?>
                                    <tr>
                                        <td><?= esc($r['id']) ?></td>
                                        <td><?= esc($r['nomor_surat']) ?></td>
                                        <td><?= esc($r['pemohon_nama'] ?? '-') ?></td>
                                        <td><?= esc($r['kecamatan_nama'] ?? '-') ?></td>
                                        <td><?= esc($r['tanggal_surat'] ?? '-') ?></td>
                                        <td>
                                            <div class="d-flex flex-wrap gap-1">
                                                <a href="<?= base_url('surat/skpt/' . $r['id']) ?>" class="btn btn-sm btn-outline-primary">Preview</a>
                                                <a href="<?= base_url('surat/skpt/' . $r['id'] . '/pdf') ?>" class="btn btn-sm btn-outline-danger">PDF</a>
                                                <a href="<?= base_url('surat/skpt/' . $r['id'] . '/word') ?>" class="btn btn-sm btn-outline-primary">Word</a>
                                                <form action="<?= base_url('surat/skpt/' . $r['id']) ?>" method="post" data-confirm="Hapus SKPT ini?">
                                                    <?= csrf_field() ?>
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <button type="submit" class="btn btn-sm btn-outline-danger">Hapus</button>
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
        <?php endif; ?>
    </div>

    <div class="col-lg-5">
        <div class="card border-0 fancy-card">
            <div class="card-body">
                <h6 class="fw-semibold mb-3">Preview SKPT</h6>
                <?php if (empty($skpt)) : ?>
                    <p class="text-muted mb-0">Isi form dan simpan untuk melihat preview.</p>
                <?php else : ?>
                    <div class="d-flex flex-wrap gap-2 mb-3">
                        <a href="<?= base_url('surat/skpt/' . $skpt['id'] . '/pdf') ?>" class="btn btn-sm btn-outline-danger">
                            <i class="bi bi-file-earmark-pdf"></i> Download PDF
                        </a>
                        <a href="<?= base_url('surat/skpt/' . $skpt['id'] . '/word') ?>" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-file-earmark-word"></i> Export Word
                        </a>
                    </div>
                    <div class="paper-sheet">
                        <?php
                            $alamatKantor = trim((string) ($skpt['alamat_kantor'] ?? ''));
                            $desaJenisRaw = strtolower(trim((string) ($skpt['desa_jenis'] ?? '')));
                            $desaLabel = $desaJenisRaw === 'kelurahan' ? 'Kelurahan' : 'Desa';
                            $desaLabelUpper = strtoupper($desaLabel);
                            $pejabatLabel = $desaLabel === 'Kelurahan' ? 'Lurah' : 'Kepala Desa';
                            $jenisTanah = trim((string) ($skpt['jenis_tanah'] ?? ''));
                            if ($jenisTanah === '') {
                                $jenisTanah = 'Pekarangan dan Bangunan';
                            }
                            $statusTanah = trim((string) ($skpt['status_tanah'] ?? ''));
                            if ($statusTanah === '') {
                                $statusTanah = 'tanah yang dikuasai oleh negara (bekas tanah Swapraja)';
                            }
                            $lokasiTanah = trim((string) ($skpt['lokasi_tanah'] ?? ''));
                            $lokasiText = $lokasiTanah !== '' ? $lokasiTanah . ' ' : '';
                            $asalTanah = trim((string) ($skpt['asal_tanah'] ?? ''));
                            if ($asalTanah === '') {
                                $asalTanah = 'Selanjutnya diterangkan bahwa bidang tanah tersebut berasal dari tanah negara yang dibuka langsung dan dikuasai oleh …………………………... pada tahun ………... kemudian tanah tersebut diserahkan/beralih kepada Pemerintah Kabupaten Donggala secara ' . ($skpt['dasar_perolehan'] ?? 'Jual Beli tanpa surat-surat') . ' pada tahun ………';
                            }
                            $pernyataanTanah = trim((string) ($skpt['pernyataan_tanah'] ?? ''));
                            if ($pernyataanTanah === '') {
                                $pernyataanTanah = 'Bahwa tanah tersebut merupakan tanah Non Pertanian milik Pemerintah Kabupaten Donggala serta pihak lain tidak ada yang keberatan/tidak dalam sengketa.';
                            }
                        ?>
                        <div class="text-center" style="font-size: 12px; line-height: 1.4;">
                            <div class="fw-semibold">PEMERINTAH KABUPATEN DONGGALA</div>
                            <div class="fw-semibold">KECAMATAN <?= esc($skpt['kecamatan_nama'] ?? '-') ?></div>
                            <div class="text-danger fw-semibold"><?= esc($desaLabelUpper) ?> <?= esc($skpt['desa_nama'] ?? '-') ?></div>
                            <?php if ($alamatKantor !== '') : ?>
                                <div>Alamat : <?= esc($alamatKantor) ?></div>
                            <?php endif; ?>
                            <div class="fw-semibold">SURAT KETERANGAN PENGUASAAN TANAH</div>
                            <div class="mt-2">NOMOR : <?= esc($skpt['nomor_surat']) ?></div>
                        </div>
                        <hr>
                        <div style="font-size: 12px; line-height: 1.5;">
                            Yang bertanda tangan di Bawah ini <?= esc($pejabatLabel) ?> <?= esc($skpt['desa_nama'] ?? '-') ?> Kecamatan <?= esc($skpt['kecamatan_nama'] ?? '-') ?> Kabupaten Donggala Provinsi Sulawesi Tengah menerangkan dengan sebenarnya bahwa:
                            <table class="table table-borderless mt-2 mb-3" style="font-size: 12px;">
                                <tr>
                                    <td style="width: 150px;">Nama</td>
                                    <td style="width: 8px;">:</td>
                                    <td><?= esc($skpt['pemohon_nama'] ?? '-') ?></td>
                                </tr>
                                <tr>
                                    <td>NIK</td>
                                    <td>:</td>
                                    <td><?= esc($skpt['pemohon_nik'] ?? '-') ?></td>
                                </tr>
                                <tr>
                                    <td>TTL</td>
                                    <td>:</td>
                                    <td><?= esc($skpt['pemohon_ttl'] ?? '-') ?></td>
                                </tr>
                                <tr>
                                    <td>Umur</td>
                                    <td>:</td>
                                    <td><?= esc($skpt['pemohon_umur'] ?? '-') ?></td>
                                </tr>
                                <tr>
                                    <td>Warga Negara</td>
                                    <td>:</td>
                                    <td><?= esc($skpt['pemohon_wn'] ?? '-') ?></td>
                                </tr>
                                <tr>
                                    <td>Pekerjaan</td>
                                    <td>:</td>
                                    <td><?= esc($skpt['pemohon_pekerjaan'] ?? '-') ?></td>
                                </tr>
                                <tr>
                                    <td>Jabatan</td>
                                    <td>:</td>
                                    <td><?= esc($skpt['pemohon_jabatan'] ?? '-') ?></td>
                                </tr>
                                <tr>
                                    <td>Alamat</td>
                                    <td>:</td>
                                    <td><?= esc($skpt['pemohon_alamat'] ?? '-') ?></td>
                                </tr>
                            </table>
                            Benar mengusahakan / Menggarap / Menggunakan dan atau menguasai sebidang tanah <?= esc($jenisTanah) ?> dengan status tanah <?= esc($statusTanah) ?> seluas <?= esc($skpt['luas_tanah'] ?? '-') ?> M2 yang terletak di <?= esc($lokasiText) . esc($desaLabel) ?> <?= esc($skpt['desa_nama'] ?? '-') ?> Kecamatan <?= esc($skpt['kecamatan_nama'] ?? '-') ?> dengan batas-batas sebagai berikut:
                            <table class="table table-borderless mt-2 mb-3" style="font-size: 12px;">
                                <tr>
                                    <td style="width: 150px;">Sebelah Utara</td>
                                    <td style="width: 8px;">:</td>
                                    <td><?= esc($skpt['batas_utara'] ?? '-') ?></td>
                                </tr>
                                <tr>
                                    <td>Sebelah Timur</td>
                                    <td>:</td>
                                    <td><?= esc($skpt['batas_timur'] ?? '-') ?></td>
                                </tr>
                                <tr>
                                    <td>Sebelah Selatan</td>
                                    <td>:</td>
                                    <td><?= esc($skpt['batas_selatan'] ?? '-') ?></td>
                                </tr>
                                <tr>
                                    <td>Sebelah Barat</td>
                                    <td>:</td>
                                    <td><?= esc($skpt['batas_barat'] ?? '-') ?></td>
                                </tr>
                            </table>
                            <div class="mt-2"><?= nl2br(esc($asalTanah)) ?></div>
                            <div class="mt-2"><?= nl2br(esc($pernyataanTanah)) ?></div>
                            <div class="mt-2">Demikian surat keterangan penguasaan tanah ini dibuat dengan sebenarnya untuk dipergunakan sebagaimana mestinya dan mengingat sumpah jabatan.</div>
                            <?php if (!empty($skpt['keterangan'])) : ?>
                                <div class="mt-2">Keterangan: <?= esc($skpt['keterangan']) ?></div>
                            <?php endif; ?>
                            <div class="mt-4 text-end">
                                Tanggal, <?= esc($skpt['tanggal_surat'] ?? '-') ?>
                            </div>
                            <div class="mt-4 d-flex justify-content-between">
                                <div class="text-center">
                                    Mengetahui,<br>
                                    Camat <?= esc($skpt['kecamatan_nama'] ?? '-') ?><br><br><br>
                                    <strong><?= esc($skpt['camat_nama'] ?? '-') ?></strong><br>
                                    <?php if (!empty($skpt['camat_nip'])) : ?>
                                        NIP. <?= esc($skpt['camat_nip']) ?>
                                    <?php endif; ?>
                                </div>
                                <div class="text-center">
                                    <?= esc($pejabatLabel) ?> <?= esc($skpt['desa_nama'] ?? '-') ?><br><br><br>
                                    <strong><?= esc($skpt['kepala_desa_nama'] ?? '-') ?></strong><br>
                                    <?php if (!empty($skpt['kepala_desa_nip'])) : ?>
                                        NIP. <?= esc($skpt['kepala_desa_nip']) ?>
                                    <?php endif; ?>
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
        const kecamatanSelect = document.getElementById('kecamatanSelect');
        const desaSelect = document.getElementById('desaSelect');
        const kepalaSelect = document.getElementById('kepalaDesaSelect');
        const pemohonSelect = document.getElementById('pemohonSelect');
        const camatSelect = document.getElementById('camatSelect');
        if (!desaSelect || !kepalaSelect || !kecamatanSelect) return;

        const allKepalaOptions = Array.from(kepalaSelect.options);
        const allDesaOptions = Array.from(desaSelect.options);
        const allCamatOptions = camatSelect ? Array.from(camatSelect.options) : [];
        const filterKepala = (selectedValue) => {
            const desaId = desaSelect.value;
            const keepValue = selectedValue || kepalaSelect.value;
            kepalaSelect.innerHTML = '';
            allKepalaOptions.forEach(opt => {
                if (opt.value === '') {
                    kepalaSelect.appendChild(opt.cloneNode(true));
                    return;
                }
                if (desaId === '' || opt.dataset.desa === desaId) {
                    kepalaSelect.appendChild(opt.cloneNode(true));
                }
            });
            if (keepValue) {
                const exists = Array.from(kepalaSelect.options).some(o => o.value === keepValue);
                if (exists) kepalaSelect.value = keepValue;
            }
        };

        const filterDesa = (selectedValue) => {
            const kecId = kecamatanSelect.value;
            const keepValue = selectedValue || desaSelect.value;
            desaSelect.innerHTML = '';
            allDesaOptions.forEach(opt => {
                if (opt.value === '') {
                    desaSelect.appendChild(opt.cloneNode(true));
                    return;
                }
                if (kecId === '' || opt.dataset.kec === kecId) {
                    desaSelect.appendChild(opt.cloneNode(true));
                }
            });
            if (keepValue) {
                const exists = Array.from(desaSelect.options).some(o => o.value === keepValue);
                if (exists) desaSelect.value = keepValue;
            }
        };

        const filterCamat = (selectedValue) => {
            if (!camatSelect) return;
            const kecId = kecamatanSelect.value;
            const keepValue = selectedValue || camatSelect.value;
            camatSelect.innerHTML = '';
            allCamatOptions.forEach(opt => {
                if (opt.value === '') {
                    camatSelect.appendChild(opt.cloneNode(true));
                    return;
                }
                if (kecId === '' || opt.dataset.kec === kecId) {
                    camatSelect.appendChild(opt.cloneNode(true));
                }
            });
            if (keepValue) {
                const exists = Array.from(camatSelect.options).some(o => o.value === keepValue);
                if (exists) camatSelect.value = keepValue;
            }
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
            const umur = document.getElementById('pemohonUmur');
            const jk = document.getElementById('pemohonJk');
            const wn = document.getElementById('pemohonWn');
            const agama = document.getElementById('pemohonAgama');
            const pekerjaan = document.getElementById('pemohonPekerjaan');
            const jabatan = document.getElementById('pemohonJabatan');
            const alamat = document.getElementById('pemohonAlamat');

            if (!opt || opt.value === '') {
                if (nama) nama.value = '';
                if (nik) nik.value = '';
                if (ttl) ttl.value = '';
                if (umur) umur.value = '';
                if (jk) jk.value = '';
                if (wn) wn.value = '';
                if (agama) agama.value = '';
                if (pekerjaan) pekerjaan.value = '';
                if (jabatan) jabatan.value = '';
                if (alamat) alamat.value = '';
                return;
            }
            if (nama) nama.value = opt.dataset.nama || '';
            if (nik) nik.value = opt.dataset.nik || '';
            if (ttl) ttl.value = opt.dataset.ttl || '';
            if (umur) umur.value = opt.dataset.umur || '';
            if (jk) jk.value = opt.dataset.jk || '';
            if (wn) wn.value = opt.dataset.wn || '';
            if (agama) agama.value = opt.dataset.agama || '';
            if (pekerjaan) pekerjaan.value = opt.dataset.pekerjaan || '';
            if (jabatan) jabatan.value = opt.dataset.jabatan || '';
            if (alamat) alamat.value = opt.dataset.alamat || '';
        };

        kecamatanSelect.addEventListener('change', () => {
            filterDesa();
            filterCamat();
            filterKepala();
            updateKepalaInfo();
            updateCamatInfo();
        });
        desaSelect.addEventListener('change', () => {
            const opt = desaSelect.selectedOptions[0];
            if (opt && opt.dataset.kec) {
                kecamatanSelect.value = opt.dataset.kec;
                filterDesa(desaSelect.value);
                filterCamat(camatSelect ? camatSelect.value : '');
            }
            filterKepala(kepalaSelect.value);
            updateKepalaInfo();
        });
        kepalaSelect.addEventListener('change', updateKepalaInfo);
        if (camatSelect) camatSelect.addEventListener('change', updateCamatInfo);
        if (pemohonSelect) pemohonSelect.addEventListener('change', updatePemohonInfo);

        filterDesa();
        filterCamat();
        filterKepala();
        updateKepalaInfo();
        updateCamatInfo();
        updatePemohonInfo();
    });
</script>
<?= $this->endSection() ?>
