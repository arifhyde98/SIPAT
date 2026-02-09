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
}
