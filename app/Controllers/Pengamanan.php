<?php

namespace App\Controllers;

use App\Models\PengamananFisikModel;

class Pengamanan extends BaseController
{
    public function store($idAset)
    {
        $model = new PengamananFisikModel();
        $existing = $model->where('id_aset', $idAset)->first();

        $data = [
            'id_aset'             => $idAset,
            'sertifikat_ada'      => $this->request->getPost('sertifikat_ada') ? 1 : 0,
            'pagar'               => $this->request->getPost('pagar') ? 1 : 0,
            'papan_nama'          => $this->request->getPost('papan_nama') ? 1 : 0,
            'dikuasai_pihak_lain' => $this->request->getPost('dikuasai_pihak_lain') ? 1 : 0,
            'catatan'             => $this->request->getPost('catatan'),
            'tgl_cek'             => $this->request->getPost('tgl_cek') ?: null,
        ];

        if ($existing) {
            $model->update($existing['id_pengamanan'], $data);
            $this->logAudit('update', 'pengamanan_fisik', (int) $existing['id_pengamanan'], $existing, $data);
        } else {
            $model->insert($data);
            $this->logAudit('create', 'pengamanan_fisik', (int) $model->getInsertID(), [], $data);
        }

        return redirect()->back()->with('success', 'Pengamanan fisik berhasil disimpan.');
    }
}
