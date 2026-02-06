<?php

namespace App\Models;

use CodeIgniter\Model;

class KepalaDesaModel extends Model
{
    protected $table = 'kepala_desa';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'desa_id',
        'nama',
        'nip',
        'aktif',
    ];
    protected $useTimestamps = true;
}
