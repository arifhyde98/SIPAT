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
    protected $allowedFields    = ['nama_status', 'urutan', 'warna'];
}
