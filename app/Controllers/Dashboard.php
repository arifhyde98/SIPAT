<?php

namespace App\Controllers;

use App\Models\AsetModel;
use App\Models\StatusProsesModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $asetModel = new AsetModel();
        $statusModel = new StatusProsesModel();
        $db = \Config\Database::connect();

        $totalAset = $asetModel->countAllResults();
        $statusMaster = $statusModel->orderBy('urutan', 'ASC')->findAll();

        $latestRows = $db->query(
            "SELECT p1.id_aset, p1.id_status, sp.nama_status
             FROM proses_aset p1
             JOIN (
                 SELECT id_aset, MAX(id_proses) AS max_id
                 FROM proses_aset
                 GROUP BY id_aset
             ) p2 ON p1.id_aset = p2.id_aset AND p1.id_proses = p2.max_id
             LEFT JOIN status_proses sp ON sp.id_status = p1.id_status"
        )->getResultArray();

        $latestMap = [];
        foreach ($latestRows as $row) {
            $latestMap[(int) $row['id_aset']] = [
                'id_status'   => (int) ($row['id_status'] ?? 0),
                'nama_status' => trim((string) ($row['nama_status'] ?? '')),
            ];
        }

        $asetRows = $asetModel->select('id_aset, opd')->findAll();
        $asetBersertifikat = 0;
        $asetKendala = 0;
        $asetProses = 0;

        // Siapkan semua status agar distribusi selalu mengikuti master status.
        $statusCounts = [];
        foreach ($statusMaster as $status) {
            $name = trim((string) ($status['nama_status'] ?? ''));
            if ($name !== '') {
                $statusCounts[$name] = 0;
            }
        }
        if (!array_key_exists('Belum Diurus', $statusCounts)) {
            $statusCounts['Belum Diurus'] = 0;
        }

        $opdStats = [];

        foreach ($asetRows as $aset) {
            $idAset = (int) $aset['id_aset'];
            $latest = $latestMap[$idAset] ?? null;

            $statusName = $latest['nama_status'] ?? '';
            if ($statusName === '') {
                $statusName = 'Belum Diurus';
            }

            if (!array_key_exists($statusName, $statusCounts)) {
                $statusCounts[$statusName] = 0;
            }
            $statusCounts[$statusName]++;

            $normalized = strtolower($statusName);
            if (str_contains($normalized, 'kendala') || str_contains($normalized, 'sengketa')) {
                $asetKendala++;
            } elseif (str_contains($normalized, 'selesai ukur')) {
                $asetProses++;
            } elseif (str_contains($normalized, 'sertifikat') || str_contains($normalized, 'terbit') || str_contains($normalized, 'selesai')) {
                $asetBersertifikat++;
            } else {
                $asetProses++;
            }

            $opdKey = $aset['opd'] ?? 'Tidak Diketahui';
            $opdStats[$opdKey] = ($opdStats[$opdKey] ?? 0) + 1;
        }

        // Pertahankan urutan status sesuai master (urutan ASC).
        $orderedStatusCounts = [];
        foreach ($statusMaster as $status) {
            $name = trim((string) ($status['nama_status'] ?? ''));
            if ($name !== '') {
                $orderedStatusCounts[$name] = $statusCounts[$name] ?? 0;
            }
        }
        foreach ($statusCounts as $name => $count) {
            if (!array_key_exists($name, $orderedStatusCounts)) {
                $orderedStatusCounts[$name] = $count;
            }
        }
        $statusCounts = $orderedStatusCounts;

        return view('dashboard/index', [
            'totalAset'         => $totalAset,
            'asetBersertifikat' => $asetBersertifikat,
            'asetKendala'       => $asetKendala,
            'asetProses'        => $asetProses,
            'opdStats'          => $opdStats,
            'statusCounts'      => $statusCounts,
        ]);
    }
}
