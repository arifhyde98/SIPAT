<?php

namespace App\Models;

use CodeIgniter\Model;

class SuratSkptModel extends Model
{
    protected $table = 'surat_skpt';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'nomor_surat',
        'alamat_kantor',
        'desa_id',
        'kepala_desa_id',
        'camat_id',
        'pemohon_id',
        'lokasi_tanah',
        'jenis_tanah',
        'status_tanah',
        'asal_tanah',
        'pernyataan_tanah',
        'luas_tanah',
        'dasar_perolehan',
        'batas_utara',
        'batas_timur',
        'batas_selatan',
        'batas_barat',
        'keterangan',
        'tanggal_surat',
    ];
    protected $useTimestamps = true;

    /**
     * Mengambil detail SKPT lengkap beserta relasi desa, kecamatan, pemohon, kepala desa, dan camat.
     */
    public function fetchDetail(int $id): ?array
    {
        $row = $this->db->table('surat_skpt s')
            ->select('s.*, d.nama as desa_nama, d.jenis as desa_jenis, kec.nama as kecamatan_nama, p.nama as pemohon_nama, p.nik as pemohon_nik, p.ttl as pemohon_ttl, p.umur as pemohon_umur, p.jenis_kelamin as pemohon_jk, p.warga_negara as pemohon_wn, p.agama as pemohon_agama, p.pekerjaan as pemohon_pekerjaan, p.jabatan as pemohon_jabatan, p.alamat as pemohon_alamat, k.nama as kepala_desa_nama, k.nip as kepala_desa_nip, c.nama as camat_nama, c.nip as camat_nip')
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

    /**
     * Mengambil daftar SKPT terbaru.
     */
    public function fetchRecent(?int $kecamatanId = null, int $limit = 10): array
    {
        $builder = $this->db->table('surat_skpt s')
            ->select('s.id, s.nomor_surat, s.tanggal_surat, p.nama as pemohon_nama, kec.nama as kecamatan_nama')
            ->join('pemohon p', 'p.id = s.pemohon_id', 'left')
            ->join('desa d', 'd.id = s.desa_id', 'left')
            ->join('kecamatan kec', 'kec.id = d.kecamatan_id', 'left')
            ->orderBy('s.id', 'DESC')
            ->limit($limit);

        if (!empty($kecamatanId)) {
            $builder->where('d.kecamatan_id', $kecamatanId);
        }

        return $builder->get()->getResultArray();
    }
}
