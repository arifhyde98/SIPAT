<?php

namespace App\Models;

use CodeIgniter\Model;

class AuditLogModel extends Model
{
    protected $table            = 'audit_logs';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = [
        'user_id',
        'action',
        'entity',
        'entity_id',
        'old_data',
        'new_data',
        'ip_address',
        'user_agent',
        'created_at',
    ];

    protected $useTimestamps = false;
}
