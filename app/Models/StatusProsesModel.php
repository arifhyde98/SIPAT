<?php

namespace App\Models;

use CodeIgniter\Model;

class StatusProsesModel extends Model
{
    protected $table            = 'status_proses';
    protected $primaryKey       = 'id_status';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = ['nama_status', 'urutan', 'warna', 'kategori'];

    protected $validationRules = [
        'nama_status' => 'required',
        'urutan'      => 'required|numeric',
        'kategori'    => 'required|in_list[belum_diurus,proses,kendala,bersertifikat]',
    ];
}
