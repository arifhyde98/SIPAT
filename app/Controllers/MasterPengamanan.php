<?php

namespace App\Controllers;

use App\Models\MasterPengamananItemModel;

class MasterPengamanan extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new MasterPengamananItemModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Master Item Pengamanan Fisik',
            'items' => $this->model->findAll(),
        ];
        return view('master/pengamanan/index', $data);
    }

    public function store()
    {
        if (!$this->validate([
            'label' => 'required|min_length[3]|max_length[255]'
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->insert([
            'label'     => $this->request->getPost('label'),
            'is_active' => $this->request->getPost('is_active') ? 1 : 0,
        ]);

        return redirect()->to('/master/pengamanan')->with('success', 'Item berhasil ditambahkan.');
    }

    public function update($id)
    {
        if (!$this->validate([
            'label' => 'required|min_length[3]|max_length[255]'
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->update($id, [
            'label'     => $this->request->getPost('label'),
            'is_active' => $this->request->getPost('is_active') ? 1 : 0,
        ]);

        return redirect()->to('/master/pengamanan')->with('success', 'Item berhasil diperbarui.');
    }

    public function delete($id)
    {
        // Hapus item master. 
        // Note: Data checklist yang sudah tersimpan di aset (pengamanan_fisik_values) 
        // akan ikut terhapus karena constraint ON DELETE CASCADE di database.
        $this->model->delete($id);
        return redirect()->to('/master/pengamanan')->with('success', 'Item berhasil dihapus.');
    }
}
