<?php

namespace App\Controllers;

use App\Models\CamatModel;
use App\Models\DesaModel;
use App\Models\KecamatanModel;
use App\Models\KepalaDesaModel;
use App\Models\PemohonModel;

class MasterData extends BaseController
{
    public function kecamatan()
    {
        $model = new KecamatanModel();
        return view('master/kecamatan', [
            'title' => 'Master Kecamatan',
            'rows' => $model->orderBy('nama', 'ASC')->findAll(),
        ]);
    }

    public function storeKecamatan()
    {
        $nama = trim((string) $this->request->getPost('nama'));
        if ($nama === '') {
            return redirect()->back()->withInput()->with('errors', ['Nama kecamatan wajib diisi.']);
        }

        $model = new KecamatanModel();
        $model->insert(['nama' => $nama]);

        return redirect()->to('/master/kecamatan')->with('success', 'Kecamatan disimpan.');
    }

    public function editKecamatan(int $id)
    {
        $model = new KecamatanModel();
        $row = $model->find($id);
        if (! $row) {
            return redirect()->to('/master/kecamatan')->with('errors', ['Kecamatan tidak ditemukan.']);
        }

        return view('master/kecamatan_edit', [
            'title' => 'Edit Kecamatan',
            'row' => $row,
        ]);
    }

    public function updateKecamatan(int $id)
    {
        $nama = trim((string) $this->request->getPost('nama'));
        if ($nama === '') {
            return redirect()->back()->withInput()->with('errors', ['Nama kecamatan wajib diisi.']);
        }

        $model = new KecamatanModel();
        $model->update($id, ['nama' => $nama]);

        return redirect()->to('/master/kecamatan')->with('success', 'Kecamatan diperbarui.');
    }

    public function deleteKecamatan(int $id)
    {
        $model = new KecamatanModel();
        $model->delete($id);
        return redirect()->to('/master/kecamatan')->with('success', 'Kecamatan dihapus.');
    }

    public function desa()
    {
        $model = new DesaModel();
        $kecamatanModel = new KecamatanModel();
        $rows = $model->select('desa.*, kecamatan.nama as kecamatan_nama')
            ->join('kecamatan', 'kecamatan.id = desa.kecamatan_id', 'left')
            ->orderBy('desa.nama', 'ASC')
            ->findAll();
        return view('master/desa', [
            'title' => 'Master Desa',
            'rows' => $rows,
            'kecamatanList' => $kecamatanModel->orderBy('nama', 'ASC')->findAll(),
        ]);
    }

    public function storeDesa()
    {
        $nama = trim((string) $this->request->getPost('nama'));
        $kecamatanId = $this->request->getPost('kecamatan_id');
        if ($nama === '' || empty($kecamatanId)) {
            return redirect()->back()->withInput()->with('errors', ['Nama desa dan kecamatan wajib diisi.']);
        }

        $model = new DesaModel();
        $model->insert([
            'nama' => $nama,
            'kecamatan_id' => $kecamatanId,
        ]);

        return redirect()->to('/master/desa')->with('success', 'Desa disimpan.');
    }

    public function editDesa(int $id)
    {
        $model = new DesaModel();
        $kecamatanModel = new KecamatanModel();
        $row = $model->find($id);
        if (! $row) {
            return redirect()->to('/master/desa')->with('errors', ['Desa tidak ditemukan.']);
        }

        return view('master/desa_edit', [
            'title' => 'Edit Desa',
            'row' => $row,
            'kecamatanList' => $kecamatanModel->orderBy('nama', 'ASC')->findAll(),
        ]);
    }

    public function updateDesa(int $id)
    {
        $nama = trim((string) $this->request->getPost('nama'));
        $kecamatanId = $this->request->getPost('kecamatan_id');
        if ($nama === '' || empty($kecamatanId)) {
            return redirect()->back()->withInput()->with('errors', ['Nama desa dan kecamatan wajib diisi.']);
        }

        $model = new DesaModel();
        $model->update($id, [
            'nama' => $nama,
            'kecamatan_id' => $kecamatanId,
        ]);

        return redirect()->to('/master/desa')->with('success', 'Desa diperbarui.');
    }

    public function deleteDesa(int $id)
    {
        $model = new DesaModel();
        $model->delete($id);
        return redirect()->to('/master/desa')->with('success', 'Desa dihapus.');
    }

    public function bulkUpdateDesaKecamatan()
    {
        $ids = (array) $this->request->getPost('ids');
        $kecamatanId = $this->request->getPost('kecamatan_id');
        $ids = array_values(array_filter($ids, static function ($id) {
            return ctype_digit((string) $id);
        }));

        if (empty($kecamatanId) || empty($ids)) {
            return redirect()->back()->with('errors', ['Pilih desa dan kecamatan untuk diperbarui.']);
        }

        $kecamatanModel = new KecamatanModel();
        if (! $kecamatanModel->find($kecamatanId)) {
            return redirect()->back()->with('errors', ['Kecamatan tidak ditemukan.']);
        }

        $model = new DesaModel();
        $model->whereIn('id', $ids)->set(['kecamatan_id' => $kecamatanId])->update();

        return redirect()->to('/master/desa')->with('success', 'Kecamatan desa diperbarui.');
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
        $kecamatanModel = new KecamatanModel();
        $rows = $model->select('camat.*, kecamatan.nama as kecamatan_nama')
            ->join('kecamatan', 'kecamatan.id = camat.kecamatan_id', 'left')
            ->orderBy('camat.aktif', 'DESC')
            ->orderBy('camat.nama', 'ASC')
            ->findAll();
        return view('master/camat', [
            'title' => 'Master Camat',
            'rows' => $rows,
            'kecamatanList' => $kecamatanModel->orderBy('nama', 'ASC')->findAll(),
        ]);
    }

    public function storeCamat()
    {
        $post = $this->request->getPost();
        $nama = trim((string) ($post['nama'] ?? ''));
        $kecamatanId = $post['kecamatan_id'] ?? null;
        if ($nama === '' || empty($kecamatanId)) {
            return redirect()->back()->withInput()->with('errors', ['Nama camat dan kecamatan wajib diisi.']);
        }

        $model = new CamatModel();
        $model->insert([
            'kecamatan_id' => $kecamatanId,
            'nama' => $nama,
            'nip' => $post['nip'] ?? null,
            'aktif' => isset($post['aktif']) ? 1 : 0,
        ]);

        return redirect()->to('/master/camat')->with('success', 'Camat disimpan.');
    }

    public function editCamat(int $id)
    {
        $model = new CamatModel();
        $kecamatanModel = new KecamatanModel();
        $row = $model->find($id);
        if (! $row) {
            return redirect()->to('/master/camat')->with('errors', ['Camat tidak ditemukan.']);
        }

        return view('master/camat_edit', [
            'title' => 'Edit Camat',
            'row' => $row,
            'kecamatanList' => $kecamatanModel->orderBy('nama', 'ASC')->findAll(),
        ]);
    }

    public function updateCamat(int $id)
    {
        $post = $this->request->getPost();
        $nama = trim((string) ($post['nama'] ?? ''));
        $kecamatanId = $post['kecamatan_id'] ?? null;
        if ($nama === '' || empty($kecamatanId)) {
            return redirect()->back()->withInput()->with('errors', ['Nama camat dan kecamatan wajib diisi.']);
        }

        $model = new CamatModel();
        $model->update($id, [
            'kecamatan_id' => $kecamatanId,
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

    public function bulkUpdateCamatKecamatan()
    {
        $ids = (array) $this->request->getPost('ids');
        $kecamatanId = $this->request->getPost('kecamatan_id');
        $ids = array_values(array_filter($ids, static function ($id) {
            return ctype_digit((string) $id);
        }));

        if (empty($kecamatanId) || empty($ids)) {
            return redirect()->back()->with('errors', ['Pilih camat dan kecamatan untuk diperbarui.']);
        }

        $kecamatanModel = new KecamatanModel();
        if (! $kecamatanModel->find($kecamatanId)) {
            return redirect()->back()->with('errors', ['Kecamatan tidak ditemukan.']);
        }

        $model = new CamatModel();
        $model->whereIn('id', $ids)->set(['kecamatan_id' => $kecamatanId])->update();

        return redirect()->to('/master/camat')->with('success', 'Kecamatan camat diperbarui.');
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
