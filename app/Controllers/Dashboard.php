<?php

namespace App\Controllers;

use App\Models\AsetModel;
use App\Models\StatusProsesModel;
use App\Models\AuditLogModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $asetModel = new AsetModel();
        $statusModel = new StatusProsesModel();
        $auditModel = new AuditLogModel();
        $db = \Config\Database::connect();

        $totalAset = $asetModel->countAllResults();
        $statusMaster = $statusModel->orderBy('urutan', 'ASC')->findAll();

        $recentLogs = $auditModel->select('audit_logs.*, users.nama as user_name')
            ->join('users', 'users.id_user = audit_logs.user_id', 'left')
            ->orderBy('audit_logs.id', 'DESC')
            ->limit(5)
            ->findAll();

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
        $asetBelumDiurus = 0;
        $statusBreakdowns = [
            'bersertifikat' => [],
            'proses'        => [],
            'kendala'       => [],
            'belum_diurus'  => [],
        ];

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

            $category = $this->getStatusCategory($statusName);
            $statusBreakdowns[$category][$statusName] = ($statusBreakdowns[$category][$statusName] ?? 0) + 1;

            if ($category === 'kendala') {
                $asetKendala++;
            } elseif ($category === 'bersertifikat') {
                $asetBersertifikat++;
            } elseif ($category === 'belum_diurus') {
                $asetBelumDiurus++;
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
        foreach ($statusBreakdowns as $category => $items) {
            arsort($items);
            $statusBreakdowns[$category] = $items;
        }

        return view('dashboard/index', [
            'totalAset'         => $totalAset,
            'asetBersertifikat' => $asetBersertifikat,
            'asetKendala'       => $asetKendala,
            'asetProses'        => $asetProses,
            'asetBelumDiurus'   => $asetBelumDiurus,
            'opdStats'          => $opdStats,
            'statusCounts'      => $statusCounts,
            'statusBreakdowns'  => $statusBreakdowns,
            'recentLogs'        => $recentLogs,
        ]);
    }

    private function getStatusCategory(string $statusName): string
    {
        $normalized = strtolower(trim($statusName));

        if ($normalized === '' || str_contains($normalized, 'belum diurus')) {
            return 'belum_diurus';
        }

        if (str_contains($normalized, 'belum bersertifikat')) {
            return 'proses';
        }

        if (str_contains($normalized, 'kendala')
            || str_contains($normalized, 'sengketa')
            || str_contains($normalized, 'masalah')
            || str_contains($normalized, 'bermasalah')) {
            return 'kendala';
        }

        if (str_contains($normalized, 'sertifikat')
            || str_contains($normalized, 'terbit')
            || $normalized === 'selesai') {
            return 'bersertifikat';
        }

        return 'proses';
    }
}
