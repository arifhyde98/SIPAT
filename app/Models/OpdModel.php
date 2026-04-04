<?php

namespace App\Models;

use CodeIgniter\Model;

class OpdModel extends Model
{
    protected $table = 'opd';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nama', 'aktif'];
    protected $useTimestamps = true;
    protected $returnType = 'array';
}
