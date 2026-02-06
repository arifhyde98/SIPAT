<?php

namespace App\Models;

use CodeIgniter\Model;

class CamatModel extends Model
{
    protected $table = 'camat';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'nama',
        'nip',
        'aktif',
    ];
    protected $useTimestamps = true;
}
