<?php

namespace App\Models;

use CodeIgniter\Model;

class ProsesAsetModel extends Model
{
    protected $table            = 'proses_aset';
    protected $primaryKey       = 'id_proses';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = [
        'id_aset',
        'id_status',
        'tgl_mulai',
        'tgl_selesai',
        'keterangan',
        'durasi_hari',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
