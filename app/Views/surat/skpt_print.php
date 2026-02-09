<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cetak SKPT</title>
    <style>
        body { font-family: Arial, sans-serif; color: #111; }
        .no-print { margin-bottom: 12px; }
        @media print { .no-print { display: none; } }
        .center { text-align: center; }
        .title { font-weight: 700; }
        .section { font-size: 12px; line-height: 1.5; }
        table { width: 100%; }
        td { vertical-align: top; }
    </style>
</head>
<body>
    <div class="no-print">
        <button onclick="window.print()">Print / Save PDF</button>
    </div>

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

    <div class="center">
        <div class="title">PEMERINTAH KABUPATEN DONGGALA</div>
        <div class="title">KECAMATAN <?= esc($skpt['kecamatan_nama'] ?? '-') ?></div>
        <div class="title"><?= esc($desaLabelUpper) ?> <?= esc($skpt['desa_nama'] ?? '-') ?></div>
        <?php if ($alamatKantor !== '') : ?>
            <div>Alamat : <?= esc($alamatKantor) ?></div>
        <?php endif; ?>
        <div class="title">SURAT KETERANGAN PENGUASAAN TANAH</div>
        <div class="title">NOMOR : <?= esc($skpt['nomor_surat'] ?? '-') ?></div>
    </div>

    <hr>

    <div class="section">
        Yang bertanda tangan di Bawah ini <?= esc($pejabatLabel) ?> <?= esc($skpt['desa_nama'] ?? '-') ?> Kecamatan <?= esc($skpt['kecamatan_nama'] ?? '-') ?> Kabupaten Donggala Provinsi Sulawesi Tengah menerangkan dengan sebenarnya bahwa:
        <table style="margin-top: 8px; margin-bottom: 12px;">
            <tr><td style="width: 150px;">Nama</td><td style="width: 8px;">:</td><td><?= esc($skpt['pemohon_nama'] ?? '-') ?></td></tr>
            <tr><td>NIK</td><td>:</td><td><?= esc($skpt['pemohon_nik'] ?? '-') ?></td></tr>
            <tr><td>TTL</td><td>:</td><td><?= esc($skpt['pemohon_ttl'] ?? '-') ?></td></tr>
            <tr><td>Umur</td><td>:</td><td><?= esc($skpt['pemohon_umur'] ?? '-') ?></td></tr>
            <tr><td>Warga Negara</td><td>:</td><td><?= esc($skpt['pemohon_wn'] ?? '-') ?></td></tr>
            <tr><td>Pekerjaan</td><td>:</td><td><?= esc($skpt['pemohon_pekerjaan'] ?? '-') ?></td></tr>
            <tr><td>Jabatan</td><td>:</td><td><?= esc($skpt['pemohon_jabatan'] ?? '-') ?></td></tr>
            <tr><td>Alamat</td><td>:</td><td><?= esc($skpt['pemohon_alamat'] ?? '-') ?></td></tr>
        </table>

        Benar mengusahakan / Menggarap / Menggunakan dan atau menguasai sebidang tanah <?= esc($jenisTanah) ?> dengan status tanah <?= esc($statusTanah) ?> seluas <?= esc($skpt['luas_tanah'] ?? '-') ?> M2 yang terletak di <?= esc($lokasiText) . esc($desaLabel) ?> <?= esc($skpt['desa_nama'] ?? '-') ?> Kecamatan <?= esc($skpt['kecamatan_nama'] ?? '-') ?> dengan batas-batas sebagai berikut :
        <table style="margin-top: 8px; margin-bottom: 12px;">
            <tr><td style="width: 150px;">Sebelah Utara</td><td style="width: 8px;">:</td><td><?= esc($skpt['batas_utara'] ?? '-') ?></td></tr>
            <tr><td>Sebelah Timur</td><td>:</td><td><?= esc($skpt['batas_timur'] ?? '-') ?></td></tr>
            <tr><td>Sebelah Selatan</td><td>:</td><td><?= esc($skpt['batas_selatan'] ?? '-') ?></td></tr>
            <tr><td>Sebelah Barat</td><td>:</td><td><?= esc($skpt['batas_barat'] ?? '-') ?></td></tr>
        </table>

        <div><?= nl2br(esc($asalTanah)) ?></div>
        <div style="margin-top: 8px;"><?= nl2br(esc($pernyataanTanah)) ?></div>
        <div style="margin-top: 8px;">Demikian surat keterangan penguasaan tanah ini dibuat dengan sebenarnya untuk dipergunakan sebagaimana mestinya dan mengingat sumpah jabatan.</div>
        <?php if (!empty($skpt['keterangan'])) : ?>
            <div style="margin-top: 8px;">Keterangan: <?= esc($skpt['keterangan']) ?></div>
        <?php endif; ?>

        <div style="margin-top: 16px; text-align: right;">
            Tanggal, <?= esc($skpt['tanggal_surat'] ?? '-') ?>
        </div>

        <table style="margin-top: 24px;">
            <tr>
                <td>Mengetahui,<br>Camat <?= esc($skpt['kecamatan_nama'] ?? '-') ?></td>
                <td style="text-align:right;"><?= esc($pejabatLabel) ?> <?= esc($skpt['desa_nama'] ?? '-') ?></td>
            </tr>
            <tr>
                <td style="height: 60px;"></td>
                <td></td>
            </tr>
            <tr>
                <td>
                    <?= esc($skpt['camat_nama'] ?? '-') ?><br>
                    <?php if (!empty($skpt['camat_nip'])) : ?>
                        NIP. <?= esc($skpt['camat_nip']) ?>
                    <?php endif; ?>
                </td>
                <td style="text-align:right;">
                    <?= esc($skpt['kepala_desa_nama'] ?? '-') ?><br>
                    <?php if (!empty($skpt['kepala_desa_nip'])) : ?>
                        NIP. <?= esc($skpt['kepala_desa_nip']) ?>
                    <?php endif; ?>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
