<?php

namespace App\Models;

use CodeIgniter\Model;

class AsetModel extends Model
{
    protected $table            = 'aset_tanah';
    protected $primaryKey       = 'id_aset';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = [
        'kode_aset',
        'nama_aset',
        'peruntukan',
        'luas',
        'alamat',
        'lat',
        'lng',
        'opd',
        'dasar_perolehan',
        'harga_perolehan',
        'tanggal_perolehan',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
