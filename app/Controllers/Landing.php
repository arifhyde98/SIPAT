<?php

namespace App\Controllers;

use App\Models\AsetModel;
use App\Models\SettingModel;

class Landing extends BaseController
{
    public function index()
    {
        $asetModel = new AsetModel();
        $db = \Config\Database::connect();
        $settings = $this->getLandingSettings();

        $totalAset = $asetModel->countAllResults();
        $statusCounts = [];

        $sertifikatRow = $db->table('status_proses')->select('id_status')->where('nama_status', 'Sertifikat Terbit')->get()->getRowArray();
        $kendalaRow = $db->table('status_proses')->select('id_status')->where('nama_status', 'Kendala/Sengketa')->get()->getRowArray();
        $sertifikatId = $sertifikatRow ? (int) $sertifikatRow['id_status'] : null;
        $kendalaId = $kendalaRow ? (int) $kendalaRow['id_status'] : null;

        $latestRows = $db->query(
            "SELECT p1.id_aset, p1.id_status, sp.nama_status
             FROM proses_aset p1
             JOIN (
                 SELECT id_aset, MAX(id_proses) AS max_id
                 FROM proses_aset
                 GROUP BY id_aset
             ) p2 ON p1.id_aset = p2.id_aset AND p1.id_proses = p2.max_id
             JOIN status_proses sp ON sp.id_status = p1.id_status"
        )->getResultArray();

        $latestMap = [];
        foreach ($latestRows as $row) {
            $latestMap[(int) $row['id_aset']] = [
                'id_status' => (int) $row['id_status'],
                'nama_status' => $row['nama_status'],
            ];
        }

        $asetIds = $asetModel->select('id_aset')->findAll();
        $asetBersertifikat = 0;
        $asetKendala = 0;
        $asetProses = 0;

        foreach ($asetIds as $row) {
            $idAset = (int) $row['id_aset'];
            $latest = $latestMap[$idAset] ?? null;
            $statusName = $latest['nama_status'] ?? 'Belum Diurus';
            $statusCounts[$statusName] = ($statusCounts[$statusName] ?? 0) + 1;

            if ($latest && $sertifikatId !== null && $latest['id_status'] === $sertifikatId) {
                $asetBersertifikat++;
            } elseif ($latest && $kendalaId !== null && $latest['id_status'] === $kendalaId) {
                $asetKendala++;
            } else {
                $asetProses++;
            }
        }

        $opdRows = $asetModel
            ->select('opd, COUNT(*) AS jumlah')
            ->where('opd IS NOT NULL', null, false)
            ->groupBy('opd')
            ->orderBy('jumlah', 'DESC')
            ->findAll();

        $opdStats = [];
        foreach ($opdRows as $row) {
            if (!empty($row['opd'])) {
                $opdStats[$row['opd']] = (int) $row['jumlah'];
            }
        }

        return view('landing/index', [
            'totalAset' => $totalAset,
            'asetBersertifikat' => $asetBersertifikat,
            'asetKendala' => $asetKendala,
            'asetProses' => $asetProses,
            'statusCounts' => $statusCounts,
            'opdStats' => $opdStats,
            'landing' => $settings,
        ]);
    }

    public function media(string $filename)
    {
        $safeName = basename($filename);
        $path = WRITEPATH . 'uploads/landing/' . $safeName;
        if (!is_file($path)) {
            return $this->response->setStatusCode(404);
        }

        $mime = mime_content_type($path) ?: 'application/octet-stream';
        return $this->response->setHeader('Content-Type', $mime)
            ->setBody(file_get_contents($path));
    }

    private function getLandingSettings(): array
    {
        $model = new SettingModel();
        $rows = $model->whereIn('key', [
            'landing_hero_title',
            'landing_hero_subtitle',
            'landing_cta_text',
            'landing_footer_text',
            'landing_logo_header',
            'landing_logo_footer',
            'landing_hero_image',
            'landing_gallery_1',
            'landing_gallery_2',
            'landing_gallery_3',
        ])->findAll();

        $map = [];
        foreach ($rows as $row) {
            $map[$row['key']] = $row['value'];
        }

        return $map;
    }
}
