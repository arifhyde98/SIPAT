<?php

namespace App\Models;

use CodeIgniter\Model;

class SuratSkptModel extends Model
{
    protected $table = 'surat_skpt';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'nomor_surat',
        'desa_id',
        'kepala_desa_id',
        'camat_id',
        'pemohon_id',
        'lokasi_tanah',
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
