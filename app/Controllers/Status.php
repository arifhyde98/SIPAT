<?php

namespace App\Controllers;

use App\Models\StatusProsesModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Status extends BaseController
{
    public function index()
    {
        $model = new StatusProsesModel();
        $status = $model->orderBy('urutan', 'ASC')->findAll();

        return view('status/index', ['status' => $status]);
    }

    public function create()
    {
        return view('status/create');
    }

    public function modalCreate()
    {
        return view('status/modal-create');
    }

    public function store()
    {
        $rules = [
            'nama_status' => 'required',
            'urutan'      => 'required|numeric',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $model = new StatusProsesModel();
        $payload = [
            'nama_status' => $this->request->getPost('nama_status'),
            'urutan'      => $this->request->getPost('urutan'),
            'warna'       => $this->request->getPost('warna'),
        ];
        $model->insert($payload);
        $this->logAudit('create', 'status_proses', (int) $model->getInsertID(), [], $payload);

        return redirect()->to('/status')->with('success', 'Status berhasil dibuat.');
    }

    public function edit($id)
    {
        $model = new StatusProsesModel();
        $row = $model->find($id);
        if (!$row) {
            throw new PageNotFoundException('Status tidak ditemukan');
        }

        return view('status/edit', ['row' => $row]);
    }

    public function modalEdit($id)
    {
        $model = new StatusProsesModel();
        $row = $model->find($id);
        if (!$row) {
            throw new PageNotFoundException('Status tidak ditemukan');
        }

        return view('status/modal-edit', ['row' => $row]);
    }

    public function update($id)
    {
        $rules = [
            'nama_status' => 'required',
            'urutan'      => 'required|numeric',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $model = new StatusProsesModel();
        $old = $model->find($id) ?? [];
        $payload = [
            'nama_status' => $this->request->getPost('nama_status'),
            'urutan'      => $this->request->getPost('urutan'),
            'warna'       => $this->request->getPost('warna'),
        ];
        $model->update($id, $payload);
        $this->logAudit('update', 'status_proses', (int) $id, $old, $payload);

        return redirect()->to('/status')->with('success', 'Status berhasil diperbarui.');
    }

    public function delete($id)
    {
        $model = new StatusProsesModel();
        $old = $model->find($id) ?? [];
        $model->delete($id);
        $this->logAudit('delete', 'status_proses', (int) $id, $old, []);

        return redirect()->to('/status')->with('success', 'Status berhasil dihapus.');
    }
}
