<?php

namespace App\Controllers;

use App\Models\CamatModel;
use App\Models\DesaModel;
use App\Models\KepalaDesaModel;
use App\Models\SuratSkptModel;
use App\Models\PemohonModel;

class SuratTanah extends BaseController
{
    public function skpt()
    {
        $model = new SuratSkptModel();
        $recent = $model->orderBy('id', 'DESC')->findAll(10);
        $desaModel = new DesaModel();
        $kepalaModel = new KepalaDesaModel();
        $camatModel = new CamatModel();
        $pemohonModel = new PemohonModel();

        return view('surat/skpt', [
            'title' => 'Generate SKPT',
            'skpt' => null,
            'recent' => $recent,
            'desaList' => $desaModel->orderBy('nama', 'ASC')->findAll(),
            'kepalaList' => $kepalaModel->where('aktif', 1)->orderBy('nama', 'ASC')->findAll(),
            'camatList' => $camatModel->where('aktif', 1)->orderBy('nama', 'ASC')->findAll(),
            'pemohonList' => $pemohonModel->orderBy('nama', 'ASC')->findAll(),
        ]);
    }

    public function showSkpt(int $id)
    {
        $model = new SuratSkptModel();
        $skpt = $model->find($id);

        if (! $skpt) {
            return redirect()->to('/surat/skpt')->with('errors', ['Data SKPT tidak ditemukan.']);
        }

        $recent = $model->orderBy('id', 'DESC')->findAll(10);
        $desaModel = new DesaModel();
        $kepalaModel = new KepalaDesaModel();
        $camatModel = new CamatModel();
        $pemohonModel = new PemohonModel();

        return view('surat/skpt', [
            'title' => 'Generate SKPT',
            'skpt' => $skpt,
            'recent' => $recent,
            'desaList' => $desaModel->orderBy('nama', 'ASC')->findAll(),
            'kepalaList' => $kepalaModel->where('aktif', 1)->orderBy('nama', 'ASC')->findAll(),
            'camatList' => $camatModel->where('aktif', 1)->orderBy('nama', 'ASC')->findAll(),
            'pemohonList' => $pemohonModel->orderBy('nama', 'ASC')->findAll(),
        ]);
    }

    public function storeSkpt()
    {
        $model = new SuratSkptModel();
        $kepalaModel = new KepalaDesaModel();
        $camatModel = new CamatModel();
        $pemohonModel = new PemohonModel();
        $post = $this->request->getPost();

        $nomor = trim((string) ($post['nomor_surat'] ?? ''));
        if ($nomor === '') {
            $nomor = 'SKPT-' . date('Ymd') . '-' . random_int(1000, 9999);
        }

        $data = [
            'nomor_surat' => $nomor,
            'desa_id' => $post['desa_id'] ?? null,
            'kepala_desa_id' => $post['kepala_desa_id'] ?? null,
            'camat_id' => $post['camat_id'] ?? null,
            'pemohon_id' => $post['pemohon_id'] ?? null,
            'nama_pemohon' => $post['nama_pemohon'] ?? '',
            'nik' => $post['nik'] ?? null,
            'ttl' => $post['ttl'] ?? null,
            'jenis_kelamin' => $post['jenis_kelamin'] ?? null,
            'warga_negara' => $post['warga_negara'] ?? null,
            'agama' => $post['agama'] ?? null,
            'pekerjaan' => $post['pekerjaan'] ?? null,
            'alamat_pemohon' => $post['alamat_pemohon'] ?? null,
            'lokasi_tanah' => $post['lokasi_tanah'] ?? null,
            'luas_tanah' => $post['luas_tanah'] ?? null,
            'dasar_perolehan' => $post['dasar_perolehan'] ?? null,
            'batas_utara' => $post['batas_utara'] ?? null,
            'batas_timur' => $post['batas_timur'] ?? null,
            'batas_selatan' => $post['batas_selatan'] ?? null,
            'batas_barat' => $post['batas_barat'] ?? null,
            'keterangan' => $post['keterangan'] ?? null,
            'tanggal_surat' => $post['tanggal_surat'] ?? null,
            'kepala_desa_nama' => $post['kepala_desa_nama'] ?? null,
            'kepala_desa_nip' => $post['kepala_desa_nip'] ?? null,
            'camat_nama' => $post['camat_nama'] ?? null,
            'camat_nip' => $post['camat_nip'] ?? null,
        ];

        if (!empty($data['pemohon_id'])) {
            $pemohon = $pemohonModel->find($data['pemohon_id']);
            if ($pemohon) {
                $data['nama_pemohon'] = $pemohon['nama'];
                $data['nik'] = $pemohon['nik'] ?? null;
                $data['ttl'] = $pemohon['ttl'] ?? null;
                $data['jenis_kelamin'] = $pemohon['jenis_kelamin'] ?? null;
                $data['warga_negara'] = $pemohon['warga_negara'] ?? null;
                $data['agama'] = $pemohon['agama'] ?? null;
                $data['pekerjaan'] = $pemohon['pekerjaan'] ?? null;
                $data['alamat_pemohon'] = $pemohon['alamat'] ?? null;
            }
        }

        if (trim((string) $data['nama_pemohon']) === '') {
            return redirect()->back()->withInput()->with('errors', ['Nama pemohon wajib diisi.']);
        }
        if (empty($data['tanggal_surat'])) {
            return redirect()->back()->withInput()->with('errors', ['Tanggal surat wajib diisi.']);
        }
        if (empty($data['desa_id'])) {
            return redirect()->back()->withInput()->with('errors', ['Desa wajib dipilih.']);
        }
        if (empty($data['kepala_desa_id'])) {
            return redirect()->back()->withInput()->with('errors', ['Kepala desa wajib dipilih.']);
        }
        if (empty($data['camat_id'])) {
            return redirect()->back()->withInput()->with('errors', ['Camat wajib dipilih.']);
        }

        if (!empty($data['kepala_desa_id']) && !empty($data['desa_id'])) {
            $kepala = $kepalaModel->find($data['kepala_desa_id']);
            if ($kepala && (int) $kepala['desa_id'] !== (int) $data['desa_id']) {
                return redirect()->back()->withInput()->with('errors', ['Kepala desa tidak sesuai dengan desa yang dipilih.']);
            }
        }

        if (!empty($data['kepala_desa_id'])) {
            $kepala = $kepalaModel->find($data['kepala_desa_id']);
            if ($kepala) {
                $data['kepala_desa_nama'] = $kepala['nama'];
                $data['kepala_desa_nip'] = $kepala['nip'] ?? null;
            }
        }

        if (!empty($data['camat_id'])) {
            $camat = $camatModel->find($data['camat_id']);
            if ($camat) {
                $data['camat_nama'] = $camat['nama'];
                $data['camat_nip'] = $camat['nip'] ?? null;
            }
        }

        $id = $model->insert($data, true);

        return redirect()->to('/surat/skpt/' . $id)->with('success', 'Data SKPT tersimpan.');
    }

    public function pernyataanBatas()
    {
        return view('surat/pernyataan_batas', [
            'title' => 'Generate Pernyataan Batas',
        ]);
    }
}
