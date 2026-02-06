<?php

namespace App\Models;

use CodeIgniter\Model;

class PengamananFisikModel extends Model
{
    protected $table            = 'pengamanan_fisik';
    protected $primaryKey       = 'id_pengamanan';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = [
        'id_aset',
        'sertifikat_ada',
        'pagar',
        'papan_nama',
        'dikuasai_pihak_lain',
        'catatan',
        'tgl_cek',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
