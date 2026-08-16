<?php

namespace App\Models;

use CodeIgniter\Model;

class DokumenAsetModel extends Model
{
    protected $table            = 'dokumen_aset';
    protected $primaryKey       = 'id_dokumen';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = [
        'id_aset',
        'id_proses',
        'jenis_dokumen',
        'file_path',
        'status_dokumen',
        'uploaded_at',
    ];

    protected $validationRules = [
        'jenis_dokumen' => 'required',
    ];

    public static array $fileValidationRules = [
        'file' => 'uploaded[file]|max_size[file,5120]|ext_in[file,pdf,jpg,jpeg,png,gif,webp,docx,xlsx]|mime_in[file,application/pdf,image/jpeg,image/png,image/gif,image/webp,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet]',
    ];
}
