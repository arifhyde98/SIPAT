<?php

namespace App\Controllers;

use App\Models\PengamananFisikModel;

class Pengamanan extends BaseController
{
    public function store($idAset)
    {
        $model = new PengamananFisikModel();
        $existing = $model->where('id_aset', $idAset)->first();

        // Simpan data parent (catatan & tanggal)
        $data = [
            'id_aset'             => $idAset,
            'catatan'             => $this->request->getPost('catatan'),
            'tgl_cek'             => $this->request->getPost('tgl_cek') ?: null,
        ];

        $idPengamanan = null;
        if ($existing) {
            $model->update($existing['id_pengamanan'], $data);
            $idPengamanan = $existing['id_pengamanan'];
            // $this->logAudit...
        } else {
            $model->insert($data);
            $idPengamanan = $model->getInsertID();
            // $this->logAudit...
        }

        // Simpan data checklist dinamis
        $valueModel = new \App\Models\PengamananFisikValueModel();
        $itemModel = new \App\Models\MasterPengamananItemModel();

        $items = $itemModel->where('is_active', 1)->findAll();

        foreach ($items as $item) {
            $isChecked = $this->request->getPost('item_' . $item['id']) ? 1 : 0;

            $existingValue = $valueModel->where(['id_pengamanan' => $idPengamanan, 'id_item' => $item['id']])->first();

            if ($existingValue) {
                $valueModel->update($existingValue['id'], ['is_checked' => $isChecked]);
            } else {
                $valueModel->insert([
                    'id_pengamanan' => $idPengamanan,
                    'id_item' => $item['id'],
                    'is_checked' => $isChecked
                ]);
            }
        }

        return redirect()->back()->with('success', 'Pengamanan fisik berhasil disimpan.');
    }
}
