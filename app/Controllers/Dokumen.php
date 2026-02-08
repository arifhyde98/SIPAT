<?php

namespace App\Controllers;

use App\Models\DokumenAsetModel;
use App\Models\ProsesAsetModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Dokumen extends BaseController
{
    public function store($idAset)
    {
        $rules = [
            'jenis_dokumen' => 'required',
            'file'          => 'uploaded[file]|max_size[file,5120]|ext_in[file,pdf,jpg,jpeg,png,gif,webp,docx,xlsx]|mime_in[file,application/pdf,image/jpeg,image/png,image/gif,image/webp,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $idProses = $this->request->getPost('id_proses') ?: null;
        if (!empty($idProses)) {
            $prosesModel = new ProsesAsetModel();
            $proses = $prosesModel->where('id_proses', $idProses)->where('id_aset', $idAset)->first();
            if (!$proses) {
                return redirect()->back()->withInput()->with('errors', ['Proses tidak valid untuk aset ini.']);
            }
        }

        $file = $this->request->getFile('file');
        $path = null;
        if ($file && $file->isValid()) {
            $targetDir = WRITEPATH . 'uploads/sipat';
            if (!is_dir($targetDir)) {
                mkdir($targetDir, 0775, true);
            }
            $newName = $file->getRandomName();
            $file->move($targetDir, $newName);
            $path = 'uploads/sipat/' . $newName;
        }

        $model = new DokumenAsetModel();
        $payload = [
            'id_aset'        => $idAset,
            'id_proses'      => $idProses ?: null,
            'jenis_dokumen'  => $this->request->getPost('jenis_dokumen'),
            'file_path'      => $path,
            'status_dokumen' => $this->request->getPost('status_dokumen'),
            'uploaded_at'    => date('Y-m-d H:i:s'),
        ];
        $model->insert($payload);
        $this->logAudit('create', 'dokumen_aset', (int) $model->getInsertID(), [], $payload);

        return redirect()->back()->with('success', 'Dokumen berhasil diunggah.');
    }

    public function download($id)
    {
        $model = new DokumenAsetModel();
        $dok = $model->find($id);
        if (!$dok || empty($dok['file_path'])) {
            throw new PageNotFoundException('Dokumen tidak ditemukan');
        }

        return $this->response->download(WRITEPATH . $dok['file_path'], null);
    }

    public function view($id)
    {
        $model = new DokumenAsetModel();
        $dok = $model->find($id);
        if (!$dok || empty($dok['file_path'])) {
            throw new PageNotFoundException('Dokumen tidak ditemukan');
        }

        $fullPath = WRITEPATH . $dok['file_path'];
        if (!is_file($fullPath)) {
            throw new PageNotFoundException('File dokumen tidak ditemukan');
        }

        $mime = mime_content_type($fullPath) ?: 'application/octet-stream';
        $filename = basename($fullPath);

        // Hanya tipe tertentu yang aman untuk ditampilkan inline
        $inlineMimes = [
            'application/pdf',
            'image/jpeg',
            'image/png',
            'image/gif',
            'image/webp',
        ];

        if (!in_array($mime, $inlineMimes, true)) {
            return $this->response->download($fullPath, null);
        }

        return $this->response
            ->setHeader('Content-Type', $mime)
            ->setHeader('Content-Disposition', 'inline; filename="' . $filename . '"')
            ->setHeader('Content-Length', (string) filesize($fullPath))
            ->setBody(file_get_contents($fullPath));
    }

    public function delete($id)
    {
        $model = new DokumenAsetModel();
        $dok = $model->find($id);
        if (!$dok) {
            throw new PageNotFoundException('Dokumen tidak ditemukan');
        }

        if (!empty($dok['file_path'])) {
            $fullPath = WRITEPATH . $dok['file_path'];
            if (is_file($fullPath)) {
                unlink($fullPath);
            }
        }

        $model->delete($id);
        $this->logAudit('delete', 'dokumen_aset', (int) $id, $dok, []);
        return redirect()->back()->with('success', 'Dokumen berhasil dihapus.');
    }
}
