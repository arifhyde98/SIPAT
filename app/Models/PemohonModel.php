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
        'umur',
        'jenis_kelamin',
        'warga_negara',
        'agama',
        'pekerjaan',
        'jabatan',
        'alamat',
    ];
    protected $useTimestamps = true;
}
