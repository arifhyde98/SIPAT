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

    public function bulkStore()
    {
        $asetIds = (array) ($this->request->getPost('aset_ids') ?? []);
        $idStatus = $this->request->getPost('id_status');
        $nibarListRaw = (string) $this->request->getPost('nibar_list');

        if (trim($nibarListRaw) !== '') {
            $nibarItems = array_values(array_filter(array_map('trim', preg_split('/[\r\n,]+/', $nibarListRaw))));
            if (!empty($nibarItems)) {
                $db = \Config\Database::connect();
                $rows = $db->table('aset_tanah')
                    ->select('id_aset')
                    ->whereIn('kode_aset', $nibarItems)
                    ->get()
                    ->getResultArray();
                foreach ($rows as $r) {
                    $asetIds[] = (int) $r['id_aset'];
                }
            }
        }

        $asetIds = array_values(array_unique(array_filter(array_map('intval', $asetIds))));

        if (empty($asetIds)) {
            return redirect()->back()->with('errors', ['Pilih minimal satu aset tanah atau masukkan NIBAR yang valid untuk diperbarui statusnya.']);
        }

        if (empty($idStatus)) {
            return redirect()->back()->with('errors', ['Status proses wajib dipilih.']);
        }

        $tglMulai = $this->request->getPost('tgl_mulai');
        $tglSelesai = $this->request->getPost('tgl_selesai');
        $keterangan = $this->request->getPost('keterangan');
        $durasi = null;

        if (!empty($tglMulai) && !empty($tglSelesai)) {
            $durasi = (int) floor((strtotime($tglSelesai) - strtotime($tglMulai)) / 86400);
            if ($durasi < 0) {
                $durasi = null;
            }
        }

        $model = new ProsesAsetModel();
        $insertedCount = 0;

        foreach ($asetIds as $idAset) {
            $idAset = (int) $idAset;
            if ($idAset <= 0) {
                continue;
            }

            $payload = [
                'id_aset'     => $idAset,
                'id_status'   => $idStatus,
                'tgl_mulai'   => $tglMulai ?: null,
                'tgl_selesai' => $tglSelesai ?: null,
                'keterangan'  => $keterangan ?: 'Update status massal',
                'durasi_hari' => $durasi,
            ];
            $model->insert($payload);
            $this->logAudit('create', 'proses_aset', (int) $model->getInsertID(), [], $payload);
            $insertedCount++;
        }

        return redirect()->to('/aset?bulk_updated=1')->with('success', "Berhasil memperbarui status untuk {$insertedCount} aset.");
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
