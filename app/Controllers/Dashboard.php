<?php

namespace App\Controllers;

use App\Models\AsetModel;
use App\Models\StatusProsesModel;
use App\Models\AuditLogModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $data = $this->getDashboardStats();
        return view('dashboard/index', $data);
    }

    public function realtimeStats()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(403)->setBody('Forbidden');
        }
        $data = $this->getDashboardStats();
        return $this->response->setJSON($data);
    }

    private function getDashboardStats(): array
    {
        $asetModel = new AsetModel();
        $statusModel = new StatusProsesModel();
        $auditModel = new AuditLogModel();
        $db = \Config\Database::connect();

        $totalAset = $asetModel->countAllResults();
        $statusMaster = $statusModel->orderBy('urutan', 'ASC')->findAll();
        
        // Buat map id_status -> nama_status
        $statusMap = [];
        foreach ($statusMaster as $sm) {
            $statusMap[(int)$sm['id_status']] = trim((string)($sm['nama_status'] ?? ''));
        }

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
        
        // --- LOGIKA CHART PROGRESS BULANAN ---
        $year = (int) date('Y');
        $chartSelesai = array_fill(0, 12, 0);
        $chartProses = array_fill(0, 12, 0);
        $chartBelum = array_fill(0, 12, 0);

        // Ambil semua aset dengan tanggal dibuatnya
        $allAsetsForChart = $db->query("SELECT id_aset, created_at FROM aset_tanah")->getResultArray();
        
        // Ambil semua riwayat proses
        $allProses = $db->query("SELECT id_aset, id_status, created_at FROM proses_aset ORDER BY created_at ASC")->getResultArray();
        
        // Kelompokkan proses berdasarkan id_aset
        $prosesByAset = [];
        foreach ($allProses as $p) {
            $prosesByAset[(int)$p['id_aset']][] = $p;
        }

        for ($m = 1; $m <= 12; $m++) {
            $endOfMonth = date('Y-m-t 23:59:59', strtotime("$year-$m-01"));
            
            foreach ($allAsetsForChart as $asetChart) {
                $asetCreatedAt = $asetChart['created_at'];
                
                // Jika aset dibuat setelah akhir bulan ini, lewati
                if ($asetCreatedAt > $endOfMonth) {
                    continue;
                }
                
                // Cari status terakhir di bulan ini
                $currentStatusName = 'Belum Diurus';
                $asetIdChart = (int) $asetChart['id_aset'];
                
                if (isset($prosesByAset[$asetIdChart])) {
                    $latestProsesInMonth = null;
                    foreach ($prosesByAset[$asetIdChart] as $p) {
                        if ($p['created_at'] <= $endOfMonth) {
                            $latestProsesInMonth = $p;
                        } else {
                            break; // Karena sudah diorder ASC
                        }
                    }
                    if ($latestProsesInMonth) {
                        $currentStatusName = $statusMap[(int)$latestProsesInMonth['id_status']] ?? 'Belum Diurus';
                    }
                }
                
                $cat = $this->getStatusCategory($currentStatusName);
                if ($cat === 'bersertifikat') {
                    $chartSelesai[$m - 1]++;
                } elseif ($cat === 'proses' || $cat === 'kendala') {
                    $chartProses[$m - 1]++;
                } else {
                    $chartBelum[$m - 1]++;
                }
            }
        }
        // --- END LOGIKA CHART ---
        
        $pctBersertifikat = $totalAset > 0 ? round(($asetBersertifikat / $totalAset) * 100, 1) : 0;
        $pctProses = $totalAset > 0 ? round(($asetProses / $totalAset) * 100, 1) : 0;
        $pctKendala = $totalAset > 0 ? round(($asetKendala / $totalAset) * 100, 1) : 0;
        $pctBelumDiurus = $totalAset > 0 ? round(($asetBelumDiurus / $totalAset) * 100, 1) : 0;

        // Render HTML for recent logs specifically for realtime updates
        $recentLogsHtml = '';
        if (empty($recentLogs)) {
            $recentLogsHtml = '<div class="text-center text-muted py-4"><i class="bi bi-clock-history fs-3 mb-2 d-block"></i><span class="small">Belum ada riwayat aktivitas.</span></div>';
        } else {
            foreach ($recentLogs as $log) {
                $badgeClass = 'bg-gov-primary-light text-gov-primary';
                $iconClass = 'bi bi-info-circle';
                if ($log['action'] === 'create') {
                    $badgeClass = 'bg-gov-success-light text-gov-success';
                    $iconClass = 'bi bi-plus-circle';
                } elseif ($log['action'] === 'update') {
                    $badgeClass = 'bg-gov-warning-light text-gov-warning';
                    $iconClass = 'bi bi-pencil-square';
                } elseif ($log['action'] === 'delete') {
                    $badgeClass = 'bg-gov-danger-light text-gov-danger';
                    $iconClass = 'bi bi-trash3';
                }

                // Format Entity Name
                $entityMap = [
                    'aset_tanah'     => 'Aset Tanah',
                    'users'          => 'User',
                    'proses_aset'    => 'Proses Sertifikasi',
                    'dokumen_aset'   => 'Dokumen Aset',
                    'status_proses'  => 'Status Proses',
                    'kepala_desa'    => 'Kepala Desa',
                    'camat'          => 'Camat',
                    'pemohon'        => 'Pemohon',
                    'kecamatan'      => 'Kecamatan',
                    'desa'           => 'Desa',
                    'opd'            => 'OPD',
                ];
                $entityName = $entityMap[$log['entity']] ?? esc($log['entity']);

                // Format Action Name
                $actionText = '';
                if ($log['action'] === 'create') {
                    $actionText = 'ditambahkan';
                } elseif ($log['action'] === 'update') {
                    $actionText = 'diperbarui';
                } elseif ($log['action'] === 'delete') {
                    $actionText = 'dihapus';
                } else {
                    $actionText = esc($log['action']);
                }

                // Get Item Name/Identifier
                $payload = json_decode($log['new_data'] ?: ($log['old_data'] ?: '{}'), true);
                $itemName = '';
                if ($log['entity'] === 'proses_aset') {
                    $statusId = $payload['id_status'] ?? null;
                    $statusName = 'Status';
                    if ($statusId) {
                        $statusRow = $db->table('status_proses')->select('nama_status')->where('id_status', $statusId)->get()->getRowArray();
                        $statusName = $statusRow['nama_status'] ?? 'Status';
                    }
                    $asetId = $payload['id_aset'] ?? null;
                    $asetPeruntukan = '';
                    if ($asetId) {
                        $asetRow = $db->table('aset_tanah')->select('peruntukan')->where('id_aset', $asetId)->get()->getRowArray();
                        $asetPeruntukan = $asetRow['peruntukan'] ?? '';
                    }
                    $itemName = '"' . $statusName . '"' . ($asetPeruntukan ? ' pada "' . $asetPeruntukan . '"' : '');
                } elseif ($log['entity'] === 'dokumen_aset') {
                    $docName = $payload['nama_dokumen'] ?? ($payload['nama_file'] ?? 'Dokumen');
                    $asetId = $payload['id_aset'] ?? null;
                    $asetPeruntukan = '';
                    if ($asetId) {
                        $asetRow = $db->table('aset_tanah')->select('peruntukan')->where('id_aset', $asetId)->get()->getRowArray();
                        $asetPeruntukan = $asetRow['peruntukan'] ?? '';
                    }
                    $itemName = '"' . $docName . '"' . ($asetPeruntukan ? ' pada "' . $asetPeruntukan . '"' : '');
                } else {
                    $itemName = $payload['peruntukan'] ?? ($payload['nama_aset'] ?? ($payload['nama'] ?? ($payload['nama_status'] ?? ($payload['email'] ?? ($payload['nama_dokumen'] ?? ($payload['nama_file'] ?? 'ID #' . $log['entity_id']))))));
                }

                $recentLogsHtml .= '
                <div class="d-flex align-items-start gap-3">
                    <div class="'.$badgeClass.' rounded-circle d-flex align-items-center justify-content-center" style="width: 36px; height: 36px; flex-shrink: 0;">
                        <i class="'.$iconClass.'"></i>
                    </div>
                    <div class="flex-grow-1 min-width-0 text-break">
                        <h6 class="mb-1 fw-bold text-dark" style="font-size: 14px;">'.$entityName.' '.$actionText.'</h6>
                        <p class="mb-0 text-muted" style="font-size: 13px;">
                            '.esc($itemName).' oleh <strong>'.esc($log['user_name'] ?: 'Sistem').'</strong>
                        </p>
                    </div>
                    <div class="text-end" style="flex-shrink: 0;">
                        <div class="text-muted" style="font-size: 11px;">'.date('d M Y', strtotime($log['created_at'])).'</div>
                        <div class="text-muted" style="font-size: 11px;">'.date('H:i', strtotime($log['created_at'])).' WIB</div>
                    </div>
                </div>';
            }
        }

        return [
            'totalAset'         => $totalAset,
            'asetBersertifikat' => $asetBersertifikat,
            'asetKendala'       => $asetKendala,
            'asetProses'        => $asetProses,
            'asetBelumDiurus'   => $asetBelumDiurus,
            'pctBersertifikat'  => $pctBersertifikat,
            'pctProses'         => $pctProses,
            'pctKendala'        => $pctKendala,
            'pctBelumDiurus'    => $pctBelumDiurus,
            'opdStats'          => $opdStats,
            'statusCounts'      => $statusCounts,
            'statusBreakdowns'  => $statusBreakdowns,
            'recentLogs'        => $recentLogs,
            'recentLogsHtml'    => $recentLogsHtml,
            'chartSelesai'      => $chartSelesai,
            'chartProses'       => $chartProses,
            'chartBelum'        => $chartBelum,
            'chartYear'         => $year,
        ];
    }

    private function getStatusCategory(string $statusName): string
    {
        $normalized = strtolower(trim($statusName));

        if ($normalized === '' || str_contains($normalized, 'belum diurus') || str_contains($normalized, 'belum bersertifikat')) {
            return 'belum_diurus';
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
