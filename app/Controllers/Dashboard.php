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

        $statusSertifikat = $statusModel->where('nama_status', 'Sertifikat Terbit')->first();
        $statusKendala = $statusModel->where('nama_status', 'Kendala/Sengketa')->first();

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
                'id_status'   => (int) $row['id_status'],
                'nama_status' => $row['nama_status'] ?? null,
            ];
        }

        $asetRows = $asetModel->select('id_aset, opd')->findAll();
        $asetBersertifikat = 0;
        $asetKendala = 0;
        $asetProses = 0;
        $statusCounts = [];
        $opdStats = [];

        foreach ($asetRows as $aset) {
            $idAset = (int) $aset['id_aset'];
            $latest = $latestMap[$idAset] ?? null;

            if ($latest) {
                if ($statusSertifikat && $latest['id_status'] === (int) $statusSertifikat['id_status']) {
                    $asetBersertifikat++;
                } elseif ($statusKendala && $latest['id_status'] === (int) $statusKendala['id_status']) {
                    $asetKendala++;
                } else {
                    $asetProses++;
                }
            } else {
                $asetProses++;
            }

            $statusName = $latest['nama_status'] ?? 'Belum Diurus';
            $statusCounts[$statusName] = ($statusCounts[$statusName] ?? 0) + 1;

            $opdKey = $aset['opd'] ?? 'Tidak Diketahui';
            $opdStats[$opdKey] = ($opdStats[$opdKey] ?? 0) + 1;
        }

        ksort($statusCounts);

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
