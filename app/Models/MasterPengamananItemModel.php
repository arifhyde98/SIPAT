<?php

namespace App\Models;

use CodeIgniter\Model;

class MasterPengamananItemModel extends Model
{
    protected $table            = 'master_pengamanan_items';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    protected $allowedFields    = ['label', 'is_active'];
}
