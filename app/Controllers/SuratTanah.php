<?php

namespace App\Controllers;

use App\Models\CamatModel;
use App\Models\DesaModel;
use App\Models\KecamatanModel;
use App\Models\KepalaDesaModel;
use App\Models\SuratSkptModel;
use App\Models\PemohonModel;

class SuratTanah extends BaseController
{
    private function fetchSkptDetail(int $id): ?array
    {
        $db = \Config\Database::connect();
        $row = $db->table('surat_skpt s')
            ->select('s.*, d.nama as desa_nama, kec.nama as kecamatan_nama, p.nama as pemohon_nama, p.nik as pemohon_nik, p.ttl as pemohon_ttl, p.jenis_kelamin as pemohon_jk, p.warga_negara as pemohon_wn, p.agama as pemohon_agama, p.pekerjaan as pemohon_pekerjaan, p.alamat as pemohon_alamat, k.nama as kepala_desa_nama, k.nip as kepala_desa_nip, c.nama as camat_nama, c.nip as camat_nip')
            ->join('desa d', 'd.id = s.desa_id', 'left')
            ->join('kecamatan kec', 'kec.id = d.kecamatan_id', 'left')
            ->join('pemohon p', 'p.id = s.pemohon_id', 'left')
            ->join('kepala_desa k', 'k.id = s.kepala_desa_id', 'left')
            ->join('camat c', 'c.id = s.camat_id', 'left')
            ->where('s.id', $id)
            ->get()
            ->getRowArray();

        return $row ?: null;
    }

    private function fetchRecentSkpt(?int $kecamatanId = null): array
    {
        $db = \Config\Database::connect();
        $builder = $db->table('surat_skpt s')
            ->select('s.id, s.nomor_surat, s.tanggal_surat, p.nama as pemohon_nama, kec.nama as kecamatan_nama')
            ->join('pemohon p', 'p.id = s.pemohon_id', 'left')
            ->join('desa d', 'd.id = s.desa_id', 'left')
            ->join('kecamatan kec', 'kec.id = d.kecamatan_id', 'left')
            ->orderBy('s.id', 'DESC')
            ->limit(10);

        if (!empty($kecamatanId)) {
            $builder->where('d.kecamatan_id', $kecamatanId);
        }

        return $builder->get()->getResultArray();
    }

    public function skpt()
    {
        $filterKecamatan = (int) $this->request->getGet('kecamatan_id');
        $filterKecamatan = $filterKecamatan > 0 ? $filterKecamatan : null;
        $recent = $this->fetchRecentSkpt($filterKecamatan);
        $kecamatanModel = new KecamatanModel();
        $desaModel = new DesaModel();
        $kepalaModel = new KepalaDesaModel();
        $camatModel = new CamatModel();
        $pemohonModel = new PemohonModel();

        return view('surat/skpt', [
            'title' => 'Generate SKPT',
            'skpt' => null,
            'recent' => $recent,
            'filterKecamatan' => $filterKecamatan,
            'kecamatanList' => $kecamatanModel->orderBy('nama', 'ASC')->findAll(),
            'desaList' => $desaModel->orderBy('nama', 'ASC')->findAll(),
            'kepalaList' => $kepalaModel->where('aktif', 1)->orderBy('nama', 'ASC')->findAll(),
            'camatList' => $camatModel->where('aktif', 1)->orderBy('nama', 'ASC')->findAll(),
            'pemohonList' => $pemohonModel->orderBy('nama', 'ASC')->findAll(),
        ]);
    }

    public function showSkpt(int $id)
    {
        $skpt = $this->fetchSkptDetail($id);

        if (! $skpt) {
            return redirect()->to('/surat/skpt')->with('errors', ['Data SKPT tidak ditemukan.']);
        }

        $filterKecamatan = (int) $this->request->getGet('kecamatan_id');
        $filterKecamatan = $filterKecamatan > 0 ? $filterKecamatan : null;
        $recent = $this->fetchRecentSkpt($filterKecamatan);
        $kecamatanModel = new KecamatanModel();
        $desaModel = new DesaModel();
        $kepalaModel = new KepalaDesaModel();
        $camatModel = new CamatModel();
        $pemohonModel = new PemohonModel();

        return view('surat/skpt', [
            'title' => 'Generate SKPT',
            'skpt' => $skpt,
            'recent' => $recent,
            'filterKecamatan' => $filterKecamatan,
            'kecamatanList' => $kecamatanModel->orderBy('nama', 'ASC')->findAll(),
            'desaList' => $desaModel->orderBy('nama', 'ASC')->findAll(),
            'kepalaList' => $kepalaModel->where('aktif', 1)->orderBy('nama', 'ASC')->findAll(),
            'camatList' => $camatModel->where('aktif', 1)->orderBy('nama', 'ASC')->findAll(),
            'pemohonList' => $pemohonModel->orderBy('nama', 'ASC')->findAll(),
        ]);
    }

    public function printSkpt(int $id)
    {
        $skpt = $this->fetchSkptDetail($id);
        if (! $skpt) {
            return redirect()->to('/surat/skpt')->with('errors', ['Data SKPT tidak ditemukan.']);
        }

        return view('surat/skpt_print', [
            'title' => 'Cetak SKPT',
            'skpt' => $skpt,
        ]);
    }

    public function pdfSkpt(int $id)
    {
        $skpt = $this->fetchSkptDetail($id);
        if (! $skpt) {
            return redirect()->to('/surat/skpt')->with('errors', ['Data SKPT tidak ditemukan.']);
        }

        if (!class_exists(\Mpdf\Mpdf::class)) {
            return redirect()->to('/surat/skpt/' . $id)->with('errors', ['PDF belum tersedia (library mPDF belum terpasang).']);
        }

        $html = view('surat/skpt_pdf', ['skpt' => $skpt]);
        $mpdf = new \Mpdf\Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'margin_top' => 12,
            'margin_bottom' => 12,
            'margin_left' => 12,
            'margin_right' => 12,
        ]);
        $mpdf->WriteHTML($html);

        $filename = 'SKPT_' . preg_replace('/[^A-Za-z0-9_-]/', '_', (string) ($skpt['nomor_surat'] ?? $id)) . '.pdf';
        $content = $mpdf->Output($filename, 'S');

        return $this->response
            ->setHeader('Content-Type', 'application/pdf')
            ->setHeader('Content-Disposition', 'attachment; filename="' . $filename . '"')
            ->setBody($content);
    }

    public function exportWordSkpt(int $id)
    {
        $skpt = $this->fetchSkptDetail($id);
        if (! $skpt) {
            return redirect()->to('/surat/skpt')->with('errors', ['Data SKPT tidak ditemukan.']);
        }

        if (!class_exists(\PhpOffice\PhpWord\PhpWord::class)) {
            $html = view('surat/skpt_word', ['skpt' => $skpt]);
            $filename = 'SKPT_' . preg_replace('/[^A-Za-z0-9_-]/', '_', (string) ($skpt['nomor_surat'] ?? $id)) . '.doc';
            return $this->response
                ->setHeader('Content-Type', 'application/msword')
                ->setHeader('Content-Disposition', 'attachment; filename="' . $filename . '"')
                ->setBody($html);
        }

        $phpWord = new \PhpOffice\PhpWord\PhpWord();
        $section = $phpWord->addSection([
            'marginTop' => 720,
            'marginBottom' => 720,
            'marginLeft' => 720,
            'marginRight' => 720,
        ]);

        $bold = ['bold' => true];
        $center = ['alignment' => 'center'];

        $section->addText('PEMERINTAH KABUPATEN DONGGALA', $bold, $center);
        $section->addText('KECAMATAN ' . ($skpt['kecamatan_nama'] ?? '-'), $bold, $center);
        $section->addText('DESA/KELURAHAN ' . ($skpt['desa_nama'] ?? '-'), $bold, $center);
        $section->addText('SURAT KETERANGAN PENGUASAAN TANAH', $bold, $center);
        $section->addText('NOMOR : ' . ($skpt['nomor_surat'] ?? '-'), null, $center);

        $section->addTextBreak(1);
        $section->addText(
            'Yang bertanda tangan di bawah ini Kepala Desa/Lurah ' .
            ($skpt['desa_nama'] ?? '-') .
            ' Kecamatan ' . ($skpt['kecamatan_nama'] ?? '-') .
            ' Kabupaten Donggala menerangkan bahwa yang bersangkutan:'
        );

        $section->addText('Nama: ' . ($skpt['pemohon_nama'] ?? '-'));
        $section->addText('NIK: ' . ($skpt['pemohon_nik'] ?? '-'));
        $section->addText('TTL: ' . ($skpt['pemohon_ttl'] ?? '-'));
        $section->addText('Jenis Kelamin: ' . ($skpt['pemohon_jk'] ?? '-'));
        $section->addText('Warga Negara: ' . ($skpt['pemohon_wn'] ?? '-'));
        $section->addText('Agama: ' . ($skpt['pemohon_agama'] ?? '-'));
        $section->addText('Pekerjaan: ' . ($skpt['pemohon_pekerjaan'] ?? '-'));
        $section->addText('Alamat: ' . ($skpt['pemohon_alamat'] ?? '-'));

        $section->addTextBreak(1);
        $section->addText('Menguasai sebidang tanah yang terletak di:');
        $section->addText($skpt['lokasi_tanah'] ?? '-');
        $section->addText('Luas: ' . ($skpt['luas_tanah'] ?? '-') . ' m2');
        $section->addText('Dasar Perolehan: ' . ($skpt['dasar_perolehan'] ?? '-'));

        $section->addTextBreak(1);
        $section->addText('Dengan batas-batas:');
        $section->addText('Sebelah Utara: ' . ($skpt['batas_utara'] ?? '-'));
        $section->addText('Sebelah Timur: ' . ($skpt['batas_timur'] ?? '-'));
        $section->addText('Sebelah Selatan: ' . ($skpt['batas_selatan'] ?? '-'));
        $section->addText('Sebelah Barat: ' . ($skpt['batas_barat'] ?? '-'));

        $section->addTextBreak(1);
        $section->addText('Keterangan: ' . ($skpt['keterangan'] ?? '-'));
        $section->addTextBreak(1);
        $section->addText(($skpt['desa_nama'] ?? '-') . ', ' . ($skpt['tanggal_surat'] ?? '-'));

        $section->addTextBreak(2);
        $table = $section->addTable();
        $table->addRow();
        $table->addCell(4500)->addText('Mengetahui,');
        $table->addCell(4500)->addText('Kepala Desa ' . ($skpt['desa_nama'] ?? '-'));
        $table->addRow();
        $table->addCell(4500)->addText('Camat ' . ($skpt['kecamatan_nama'] ?? '-'));
        $table->addCell(4500)->addText('');
        $table->addRow();
        $table->addCell(4500)->addText('');
        $table->addCell(4500)->addText('');
        $table->addRow();
        $table->addCell(4500)->addText(($skpt['camat_nama'] ?? '-') . PHP_EOL . ($skpt['camat_nip'] ?? ''));
        $table->addCell(4500)->addText(($skpt['kepala_desa_nama'] ?? '-') . PHP_EOL . ($skpt['kepala_desa_nip'] ?? ''));

        $filename = 'SKPT_' . preg_replace('/[^A-Za-z0-9_-]/', '_', (string) ($skpt['nomor_surat'] ?? $id)) . '.docx';

        $writer = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        ob_start();
        $writer->save('php://output');
        $content = ob_get_clean();

        return $this->response
            ->setHeader('Content-Type', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document')
            ->setHeader('Content-Disposition', 'attachment; filename="' . $filename . '"')
            ->setBody($content);
    }

    public function storeSkpt()
    {
        $model = new SuratSkptModel();
        $kepalaModel = new KepalaDesaModel();
        $desaModel = new DesaModel();
        $camatModel = new CamatModel();
        $pemohonModel = new PemohonModel();
        $post = $this->request->getPost();

        $nomor = trim((string) ($post['nomor_surat'] ?? ''));
        if ($nomor === '') {
            $nomor = 'SKPT-' . date('Ymd') . '-' . random_int(1000, 9999);
        }

        $kecamatanId = $post['kecamatan_id'] ?? null;
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
        if (empty($kecamatanId)) {
            return redirect()->back()->withInput()->with('errors', ['Kecamatan wajib dipilih.']);
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

        $desa = $desaModel->find($data['desa_id']);
        if (! $desa) {
            return redirect()->back()->withInput()->with('errors', ['Desa tidak ditemukan.']);
        }
        if (!empty($kecamatanId) && (int) $desa['kecamatan_id'] !== (int) $kecamatanId) {
            return redirect()->back()->withInput()->with('errors', ['Desa tidak sesuai dengan kecamatan yang dipilih.']);
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
            if (!empty($kecamatanId) && (int) $camat['kecamatan_id'] !== (int) $kecamatanId) {
                return redirect()->back()->withInput()->with('errors', ['Camat tidak sesuai dengan kecamatan yang dipilih.']);
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
