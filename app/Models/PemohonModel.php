<?php

namespace App\Models;

use CodeIgniter\Model;

class PemohonModel extends Model
{
    protected $table = 'pemohon';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'nama',
        'nik',
        'ttl',
        'jenis_kelamin',
        'warga_negara',
        'agama',
        'pekerjaan',
        'alamat',
    ];
    protected $useTimestamps = true;
}
