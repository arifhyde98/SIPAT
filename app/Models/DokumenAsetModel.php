<?php

namespace App\Models;

use CodeIgniter\Model;

class DokumenAsetModel extends Model
{
    protected $table            = 'dokumen_aset';
    protected $primaryKey       = 'id_dokumen';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = [
        'id_aset',
        'id_proses',
        'jenis_dokumen',
        'file_path',
        'status_dokumen',
        'uploaded_at',
    ];
}
