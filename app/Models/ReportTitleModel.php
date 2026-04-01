<?php

namespace App\Models;

use CodeIgniter\Model;

class ReportTitleModel extends Model
{
    protected $table = 'report_titles';
    protected $primaryKey = 'id';
    protected $allowedFields = ['judul', 'aktif'];
    protected $useTimestamps = true;
    protected $returnType = 'array';
}
