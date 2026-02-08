<?php

namespace App\Controllers;

use App\Models\CamatModel;
use App\Models\DesaModel;
use App\Models\KepalaDesaModel;
use App\Models\SuratSkptModel;
use App\Models\PemohonModel;

class SuratTanah extends BaseController
{
    private function fetchRecentSkpt(): array
    {
        $db = \Config\Database::connect();
        return $db->table('surat_skpt s')
            ->select('s.id, s.nomor_surat, s.tanggal_surat, p.nama as pemohon_nama')
            ->join('pemohon p', 'p.id = s.pemohon_id', 'left')
            ->orderBy('s.id', 'DESC')
            ->limit(10)
            ->get()
            ->getResultArray();
    }

    public function skpt()
    {
        $recent = $this->fetchRecentSkpt();
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
        $db = \Config\Database::connect();
        $skpt = $db->table('surat_skpt s')
            ->select('s.*, d.nama as desa_nama, p.nama as pemohon_nama, p.nik as pemohon_nik, p.ttl as pemohon_ttl, p.jenis_kelamin as pemohon_jk, p.warga_negara as pemohon_wn, p.agama as pemohon_agama, p.pekerjaan as pemohon_pekerjaan, p.alamat as pemohon_alamat, k.nama as kepala_desa_nama, k.nip as kepala_desa_nip, c.nama as camat_nama, c.nip as camat_nip')
            ->join('desa d', 'd.id = s.desa_id', 'left')
            ->join('pemohon p', 'p.id = s.pemohon_id', 'left')
            ->join('kepala_desa k', 'k.id = s.kepala_desa_id', 'left')
            ->join('camat c', 'c.id = s.camat_id', 'left')
            ->where('s.id', $id)
            ->get()
            ->getRowArray();

        if (! $skpt) {
            return redirect()->to('/surat/skpt')->with('errors', ['Data SKPT tidak ditemukan.']);
        }

        $recent = $this->fetchRecentSkpt();
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
            'lokasi_tanah' => $post['lokasi_tanah'] ?? null,
            'luas_tanah' => $post['luas_tanah'] ?? null,
            'dasar_perolehan' => $post['dasar_perolehan'] ?? null,
            'batas_utara' => $post['batas_utara'] ?? null,
            'batas_timur' => $post['batas_timur'] ?? null,
            'batas_selatan' => $post['batas_selatan'] ?? null,
            'batas_barat' => $post['batas_barat'] ?? null,
            'keterangan' => $post['keterangan'] ?? null,
            'tanggal_surat' => $post['tanggal_surat'] ?? null,
        ];

        if (empty($data['pemohon_id'])) {
            return redirect()->back()->withInput()->with('errors', ['Pemohon wajib dipilih.']);
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

        $pemohon = $pemohonModel->find($data['pemohon_id']);
        if (! $pemohon) {
            return redirect()->back()->withInput()->with('errors', ['Pemohon tidak ditemukan.']);
        }

        if (!empty($data['kepala_desa_id'])) {
            $kepala = $kepalaModel->find($data['kepala_desa_id']);
            if (! $kepala) {
                return redirect()->back()->withInput()->with('errors', ['Kepala desa tidak ditemukan.']);
            }
        }

        if (!empty($data['camat_id'])) {
            $camat = $camatModel->find($data['camat_id']);
            if (! $camat) {
                return redirect()->back()->withInput()->with('errors', ['Camat tidak ditemukan.']);
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
