<?php

namespace App\Controllers;

use App\Models\CamatModel;
use App\Models\DesaModel;
use App\Models\KepalaDesaModel;
use App\Models\PemohonModel;

class MasterData extends BaseController
{
    public function desa()
    {
        $model = new DesaModel();
        return view('master/desa', [
            'title' => 'Master Desa',
            'rows' => $model->orderBy('nama', 'ASC')->findAll(),
        ]);
    }

    public function storeDesa()
    {
        $nama = trim((string) $this->request->getPost('nama'));
        if ($nama === '') {
            return redirect()->back()->withInput()->with('errors', ['Nama desa wajib diisi.']);
        }

        $model = new DesaModel();
        $model->insert(['nama' => $nama]);

        return redirect()->to('/master/desa')->with('success', 'Desa disimpan.');
    }

    public function editDesa(int $id)
    {
        $model = new DesaModel();
        $row = $model->find($id);
        if (! $row) {
            return redirect()->to('/master/desa')->with('errors', ['Desa tidak ditemukan.']);
        }

        return view('master/desa_edit', [
            'title' => 'Edit Desa',
            'row' => $row,
        ]);
    }

    public function updateDesa(int $id)
    {
        $nama = trim((string) $this->request->getPost('nama'));
        if ($nama === '') {
            return redirect()->back()->withInput()->with('errors', ['Nama desa wajib diisi.']);
        }

        $model = new DesaModel();
        $model->update($id, ['nama' => $nama]);

        return redirect()->to('/master/desa')->with('success', 'Desa diperbarui.');
    }

    public function deleteDesa(int $id)
    {
        $model = new DesaModel();
        $model->delete($id);
        return redirect()->to('/master/desa')->with('success', 'Desa dihapus.');
    }

    public function kepalaDesa()
    {
        $desaModel = new DesaModel();
        $model = new KepalaDesaModel();
        $rows = $model->select('kepala_desa.*, desa.nama as desa_nama')
            ->join('desa', 'desa.id = kepala_desa.desa_id', 'left')
            ->orderBy('kepala_desa.aktif', 'DESC')
            ->orderBy('kepala_desa.nama', 'ASC')
            ->findAll();

        return view('master/kepala_desa', [
            'title' => 'Master Kepala Desa',
            'rows' => $rows,
            'desaList' => $desaModel->orderBy('nama', 'ASC')->findAll(),
        ]);
    }

    public function storeKepalaDesa()
    {
        $post = $this->request->getPost();
        $nama = trim((string) ($post['nama'] ?? ''));
        $desaId = $post['desa_id'] ?? null;

        if ($nama === '' || empty($desaId)) {
            return redirect()->back()->withInput()->with('errors', ['Nama dan desa wajib diisi.']);
        }

        $model = new KepalaDesaModel();
        $model->insert([
            'desa_id' => $desaId,
            'nama' => $nama,
            'nip' => $post['nip'] ?? null,
            'aktif' => isset($post['aktif']) ? 1 : 0,
        ]);

        return redirect()->to('/master/kepala-desa')->with('success', 'Kepala desa disimpan.');
    }

    public function editKepalaDesa(int $id)
    {
        $desaModel = new DesaModel();
        $model = new KepalaDesaModel();
        $row = $model->find($id);
        if (! $row) {
            return redirect()->to('/master/kepala-desa')->with('errors', ['Data tidak ditemukan.']);
        }

        return view('master/kepala_desa_edit', [
            'title' => 'Edit Kepala Desa',
            'row' => $row,
            'desaList' => $desaModel->orderBy('nama', 'ASC')->findAll(),
        ]);
    }

    public function updateKepalaDesa(int $id)
    {
        $post = $this->request->getPost();
        $nama = trim((string) ($post['nama'] ?? ''));
        $desaId = $post['desa_id'] ?? null;

        if ($nama === '' || empty($desaId)) {
            return redirect()->back()->withInput()->with('errors', ['Nama dan desa wajib diisi.']);
        }

        $model = new KepalaDesaModel();
        $model->update($id, [
            'desa_id' => $desaId,
            'nama' => $nama,
            'nip' => $post['nip'] ?? null,
            'aktif' => isset($post['aktif']) ? 1 : 0,
        ]);

        return redirect()->to('/master/kepala-desa')->with('success', 'Kepala desa diperbarui.');
    }

    public function deleteKepalaDesa(int $id)
    {
        $model = new KepalaDesaModel();
        $model->delete($id);
        return redirect()->to('/master/kepala-desa')->with('success', 'Kepala desa dihapus.');
    }

    public function camat()
    {
        $model = new CamatModel();
        return view('master/camat', [
            'title' => 'Master Camat',
            'rows' => $model->orderBy('aktif', 'DESC')->orderBy('nama', 'ASC')->findAll(),
        ]);
    }

    public function storeCamat()
    {
        $post = $this->request->getPost();
        $nama = trim((string) ($post['nama'] ?? ''));
        if ($nama === '') {
            return redirect()->back()->withInput()->with('errors', ['Nama camat wajib diisi.']);
        }

        $model = new CamatModel();
        $model->insert([
            'nama' => $nama,
            'nip' => $post['nip'] ?? null,
            'aktif' => isset($post['aktif']) ? 1 : 0,
        ]);

        return redirect()->to('/master/camat')->with('success', 'Camat disimpan.');
    }

    public function editCamat(int $id)
    {
        $model = new CamatModel();
        $row = $model->find($id);
        if (! $row) {
            return redirect()->to('/master/camat')->with('errors', ['Camat tidak ditemukan.']);
        }

        return view('master/camat_edit', [
            'title' => 'Edit Camat',
            'row' => $row,
        ]);
    }

    public function updateCamat(int $id)
    {
        $post = $this->request->getPost();
        $nama = trim((string) ($post['nama'] ?? ''));
        if ($nama === '') {
            return redirect()->back()->withInput()->with('errors', ['Nama camat wajib diisi.']);
        }

        $model = new CamatModel();
        $model->update($id, [
            'nama' => $nama,
            'nip' => $post['nip'] ?? null,
            'aktif' => isset($post['aktif']) ? 1 : 0,
        ]);

        return redirect()->to('/master/camat')->with('success', 'Camat diperbarui.');
    }

    public function deleteCamat(int $id)
    {
        $model = new CamatModel();
        $model->delete($id);
        return redirect()->to('/master/camat')->with('success', 'Camat dihapus.');
    }

    public function pemohon()
    {
        $model = new PemohonModel();
        return view('master/pemohon', [
            'title' => 'Master Pemohon',
            'rows' => $model->orderBy('nama', 'ASC')->findAll(),
        ]);
    }

    public function storePemohon()
    {
        $post = $this->request->getPost();
        $nama = trim((string) ($post['nama'] ?? ''));
        if ($nama === '') {
            return redirect()->back()->withInput()->with('errors', ['Nama pemohon wajib diisi.']);
        }

        $model = new PemohonModel();
        $model->insert([
            'nama' => $nama,
            'nik' => $post['nik'] ?? null,
            'ttl' => $post['ttl'] ?? null,
            'jenis_kelamin' => $post['jenis_kelamin'] ?? null,
            'warga_negara' => $post['warga_negara'] ?? null,
            'agama' => $post['agama'] ?? null,
            'pekerjaan' => $post['pekerjaan'] ?? null,
            'alamat' => $post['alamat'] ?? null,
        ]);

        return redirect()->to('/master/pemohon')->with('success', 'Pemohon disimpan.');
    }

    public function editPemohon(int $id)
    {
        $model = new PemohonModel();
        $row = $model->find($id);
        if (! $row) {
            return redirect()->to('/master/pemohon')->with('errors', ['Pemohon tidak ditemukan.']);
        }

        return view('master/pemohon_edit', [
            'title' => 'Edit Pemohon',
            'row' => $row,
        ]);
    }

    public function updatePemohon(int $id)
    {
        $post = $this->request->getPost();
        $nama = trim((string) ($post['nama'] ?? ''));
        if ($nama === '') {
            return redirect()->back()->withInput()->with('errors', ['Nama pemohon wajib diisi.']);
        }

        $model = new PemohonModel();
        $model->update($id, [
            'nama' => $nama,
            'nik' => $post['nik'] ?? null,
            'ttl' => $post['ttl'] ?? null,
            'jenis_kelamin' => $post['jenis_kelamin'] ?? null,
            'warga_negara' => $post['warga_negara'] ?? null,
            'agama' => $post['agama'] ?? null,
            'pekerjaan' => $post['pekerjaan'] ?? null,
            'alamat' => $post['alamat'] ?? null,
        ]);

        return redirect()->to('/master/pemohon')->with('success', 'Pemohon diperbarui.');
    }

    public function deletePemohon(int $id)
    {
        $model = new PemohonModel();
        $model->delete($id);
        return redirect()->to('/master/pemohon')->with('success', 'Pemohon dihapus.');
    }
}
