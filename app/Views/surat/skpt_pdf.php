<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>SKPT</title>
    <style>
        body { font-family: Arial, sans-serif; color: #111; }
        .center { text-align: center; }
        .title { font-weight: 700; }
        .section { font-size: 12px; line-height: 1.5; }
        table { width: 100%; }
        td { vertical-align: top; }
    </style>
</head>
<body>
    <div class="center">
        <div class="title">PEMERINTAH KABUPATEN DONGGALA</div>
        <div class="title">KECAMATAN <?= esc($skpt['kecamatan_nama'] ?? '-') ?></div>
        <div class="title">DESA/KELURAHAN <?= esc($skpt['desa_nama'] ?? '-') ?></div>
        <div class="title">SURAT KETERANGAN PENGUASAAN TANAH</div>
        <div class="title">NOMOR : <?= esc($skpt['nomor_surat'] ?? '-') ?></div>
    </div>

    <hr>

    <div class="section">
        Yang bertanda tangan di bawah ini Kepala Desa/Lurah <?= esc($skpt['desa_nama'] ?? '-') ?> Kecamatan <?= esc($skpt['kecamatan_nama'] ?? '-') ?> Kabupaten Donggala menerangkan bahwa yang bersangkutan:
        <div>Nama: <?= esc($skpt['pemohon_nama'] ?? '-') ?></div>
        <div>NIK: <?= esc($skpt['pemohon_nik'] ?? '-') ?></div>
        <div>TTL: <?= esc($skpt['pemohon_ttl'] ?? '-') ?></div>
        <div>Jenis Kelamin: <?= esc($skpt['pemohon_jk'] ?? '-') ?></div>
        <div>Warga Negara: <?= esc($skpt['pemohon_wn'] ?? '-') ?></div>
        <div>Agama: <?= esc($skpt['pemohon_agama'] ?? '-') ?></div>
        <div>Pekerjaan: <?= esc($skpt['pemohon_pekerjaan'] ?? '-') ?></div>
        <div>Alamat: <?= esc($skpt['pemohon_alamat'] ?? '-') ?></div>

        <div style="margin-top: 12px;">
            Menguasai sebidang tanah yang terletak di:
            <div><?= esc($skpt['lokasi_tanah'] ?? '-') ?></div>
            <div>Luas: <?= esc($skpt['luas_tanah'] ?? '-') ?> m2</div>
            <div>Dasar Perolehan: <?= esc($skpt['dasar_perolehan'] ?? '-') ?></div>
        </div>

        <div style="margin-top: 12px;">
            Dengan batas-batas:
            <div>Sebelah Utara: <?= esc($skpt['batas_utara'] ?? '-') ?></div>
            <div>Sebelah Timur: <?= esc($skpt['batas_timur'] ?? '-') ?></div>
            <div>Sebelah Selatan: <?= esc($skpt['batas_selatan'] ?? '-') ?></div>
            <div>Sebelah Barat: <?= esc($skpt['batas_barat'] ?? '-') ?></div>
        </div>

        <div style="margin-top: 12px;">
            Keterangan: <?= esc($skpt['keterangan'] ?? '-') ?>
        </div>

        <div style="margin-top: 16px; text-align: right;">
            <?= esc($skpt['desa_nama'] ?? '-') ?>, <?= esc($skpt['tanggal_surat'] ?? '-') ?>
        </div>

        <table style="margin-top: 24px;">
            <tr>
                <td>Mengetahui,<br>Camat <?= esc($skpt['kecamatan_nama'] ?? '-') ?></td>
                <td style="text-align:right;">Kepala Desa <?= esc($skpt['desa_nama'] ?? '-') ?></td>
            </tr>
            <tr>
                <td style="height: 60px;"></td>
                <td></td>
            </tr>
            <tr>
                <td><?= esc($skpt['camat_nama'] ?? '-') ?><br><?= esc($skpt['camat_nip'] ?? '') ?></td>
                <td style="text-align:right;"><?= esc($skpt['kepala_desa_nama'] ?? '-') ?><br><?= esc($skpt['kepala_desa_nip'] ?? '') ?></td>
            </tr>
        </table>
    </div>
</body>
</html>
