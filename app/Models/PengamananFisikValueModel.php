<?php

namespace App\Models;

use CodeIgniter\Model;

class PengamananFisikValueModel extends Model
{
    protected $table            = 'pengamanan_fisik_values';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    protected $allowedFields    = ['id_pengamanan', 'id_item', 'is_checked'];
}
