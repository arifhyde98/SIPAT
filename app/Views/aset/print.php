<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laporan Aset</title>
    <style>
        body { font-family: Arial, sans-serif; color: #111; }
        h1 { font-size: 18px; margin-bottom: 8px; }
        table { width: 100%; border-collapse: collapse; font-size: 12px; }
        th, td { border: 1px solid #999; padding: 6px; text-align: left; }
        th { background: #f2f2f2; }
        @media print { .no-print { display: none; } }
    </style>
</head>
<body>
    <div class="no-print" style="margin-bottom: 10px;">
        <button onclick="window.print()">Print / Save PDF</button>
    </div>
    <h1>Laporan Aset Tanah</h1>
    <table>
        <thead>
            <tr>
                <th>Kode</th>
                <th>Nama</th>
                <th>OPD</th>
                <th>Luas</th>
                <th>Harga</th>
                <th>Tanggal Perolehan</th>
                <th>Status</th>
                <th>Durasi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($rows as $row) : ?>
                <tr>
                    <td><?= esc($row['kode_aset']) ?></td>
                    <td><?= esc($row['nama_aset']) ?></td>
                    <td><?= esc($row['opd'] ?? '-') ?></td>
                    <td><?= esc($row['luas']) ?></td>
                    <td><?= esc($row['harga_perolehan']) ?></td>
                    <td><?= esc($row['tanggal_perolehan']) ?></td>
                    <td><?= esc($row['nama_status'] ?? 'Belum Diurus') ?></td>
                    <td><?= esc($row['durasi_hari'] ?? '-') ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
