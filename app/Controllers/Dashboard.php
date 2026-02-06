<?php

namespace App\Controllers;

use App\Models\AsetModel;
use App\Models\ProsesAsetModel;
use App\Models\StatusProsesModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $asetModel = new AsetModel();
        $prosesModel = new ProsesAsetModel();
        $statusModel = new StatusProsesModel();

        $totalAset = $asetModel->countAllResults();

        $statusSertifikat = $statusModel->where('nama_status', 'Sertifikat Terbit')->first();
        $statusKendala = $statusModel->where('nama_status', 'Kendala/Sengketa')->first();

        $asetBersertifikat = 0;
        $asetKendala = 0;
        $asetProses = 0;

        $asetList = $asetModel->findAll();
        $statusCounts = [];
        foreach ($asetList as $aset) {
            $latest = $prosesModel
                ->select('proses_aset.*, status_proses.nama_status, status_proses.warna')
                ->join('status_proses', 'status_proses.id_status = proses_aset.id_status', 'left')
                ->where('proses_aset.id_aset', $aset['id_aset'])
                ->orderBy('proses_aset.id_proses', 'DESC')
                ->first();

            if ($latest) {
                if ($statusSertifikat && (int) $latest['id_status'] === (int) $statusSertifikat['id_status']) {
                    $asetBersertifikat++;
                } elseif ($statusKendala && (int) $latest['id_status'] === (int) $statusKendala['id_status']) {
                    $asetKendala++;
                } else {
                    $asetProses++;
                }

                $statusName = $latest['nama_status'] ?? 'Belum Diurus';
                if (!isset($statusCounts[$statusName])) {
                    $statusCounts[$statusName] = 0;
                }
                $statusCounts[$statusName]++;
            } else {
                $asetProses++;
                $statusCounts['Belum Diurus'] = ($statusCounts['Belum Diurus'] ?? 0) + 1;
            }
        }

        $opdStats = [];
        foreach ($asetList as $aset) {
            $opdKey = $aset['opd'] ?? 'Tidak Diketahui';
            if (!isset($opdStats[$opdKey])) {
                $opdStats[$opdKey] = 0;
            }
            $opdStats[$opdKey]++;
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
