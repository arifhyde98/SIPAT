<?php

namespace App\Controllers;

use App\Models\ProsesAsetModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Proses extends BaseController
{
    public function store($idAset)
    {
        $rules = [
            'id_status' => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $tglMulai = $this->request->getPost('tgl_mulai');
        $tglSelesai = $this->request->getPost('tgl_selesai');
        $durasi = null;

        if (!empty($tglMulai) && !empty($tglSelesai)) {
            $durasi = (int) floor((strtotime($tglSelesai) - strtotime($tglMulai)) / 86400);
            if ($durasi < 0) {
                $durasi = null;
            }
        }

        $model = new ProsesAsetModel();
        $payload = [
            'id_aset'     => $idAset,
            'id_status'   => $this->request->getPost('id_status'),
            'tgl_mulai'   => $tglMulai ?: null,
            'tgl_selesai' => $tglSelesai ?: null,
            'keterangan'  => $this->request->getPost('keterangan'),
            'durasi_hari' => $durasi,
        ];
        $model->insert($payload);
        $this->logAudit('create', 'proses_aset', (int) $model->getInsertID(), [], $payload);

        return redirect()->back()->with('success', 'Proses berhasil ditambahkan.');
    }

    public function delete($id)
    {
        $model = new ProsesAsetModel();
        $proses = $model->find($id);
        if (!$proses) {
            throw new PageNotFoundException('Data proses tidak ditemukan');
        }

        $model->delete($id);
        $this->logAudit('delete', 'proses_aset', (int) $id, $proses, []);
        return redirect()->back()->with('success', 'Proses berhasil dihapus.');
    }
}
