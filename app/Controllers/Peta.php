<?php

namespace App\Controllers;

use App\Models\AsetModel;
use App\Models\ProsesAsetModel;

class Peta extends BaseController
{
    public function index()
    {
        $asetModel = new AsetModel();
        $prosesModel = new ProsesAsetModel();

        $asetList = $asetModel->findAll();
        $markers = [];

        foreach ($asetList as $aset) {
            if (empty($aset['lat']) || empty($aset['lng'])) {
                continue;
            }

            $latest = $prosesModel
                ->select('proses_aset.*, status_proses.nama_status, status_proses.warna')
                ->join('status_proses', 'status_proses.id_status = proses_aset.id_status', 'left')
                ->where('proses_aset.id_aset', $aset['id_aset'])
                ->orderBy('proses_aset.id_proses', 'DESC')
                ->first();

            $markers[] = [
                'id'           => $aset['id_aset'],
                'kode'         => $aset['kode_aset'],
                'nama'         => $aset['nama_aset'],
                'lat'          => (float) $aset['lat'],
                'lng'          => (float) $aset['lng'],
                'status'       => $latest['nama_status'] ?? 'Belum Diurus',
                'warna_status' => $latest['warna'] ?? 'secondary',
            ];
        }

        return view('peta/index', [
            'markers' => $markers,
        ]);
    }
}
