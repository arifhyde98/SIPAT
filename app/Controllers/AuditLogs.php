<?php

namespace App\Controllers;

use App\Models\AuditLogModel;
use App\Models\UserModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class AuditLogs extends BaseController
{
    public function index()
    {
        $logModel = new AuditLogModel();
        $userModel = new UserModel();

        // Get filter inputs
        $filters = [
            'user_id'    => $this->request->getGet('user_id'),
            'action'     => $this->request->getGet('action'),
            'entity'     => $this->request->getGet('entity'),
            'date_start' => $this->request->getGet('date_start'),
            'date_end'   => $this->request->getGet('date_end'),
            'q'          => $this->request->getGet('q'),
        ];

        // Base query with join
        $builder = $logModel->select('audit_logs.*, users.nama as user_name')
                            ->join('users', 'users.id_user = audit_logs.user_id', 'left');

        // Apply filters
        if (!empty($filters['user_id'])) {
            $builder->where('audit_logs.user_id', $filters['user_id']);
        }
        if (!empty($filters['action'])) {
            $builder->where('audit_logs.action', $filters['action']);
        }
        if (!empty($filters['entity'])) {
            $builder->where('audit_logs.entity', $filters['entity']);
        }
        if (!empty($filters['date_start'])) {
            $builder->where('audit_logs.created_at >=', $filters['date_start'] . ' 00:00:00');
        }
        if (!empty($filters['date_end'])) {
            $builder->where('audit_logs.created_at <=', $filters['date_end'] . ' 23:59:59');
        }
        if (!empty($filters['q'])) {
            $q = $filters['q'];
            $builder->groupStart()
                    ->like('audit_logs.ip_address', $q)
                    ->orLike('audit_logs.entity_id', $q)
                    ->orLike('audit_logs.old_data', $q)
                    ->orLike('audit_logs.new_data', $q)
                    ->orLike('audit_logs.user_agent', $q)
                    ->groupEnd();
        }

        // Get paginated results
        $logs = $builder->orderBy('audit_logs.id', 'DESC')->paginate(20, 'logs');
        $pager = $logModel->pager;

        // Get lists for filter select options
        $users = $userModel->orderBy('nama', 'ASC')->findAll();
        
        $db = \Config\Database::connect();
        $distinctActions = $db->table('audit_logs')->select('action')->distinct()->orderBy('action', 'ASC')->get()->getResultArray();
        $distinctEntities = $db->table('audit_logs')->select('entity')->distinct()->orderBy('entity', 'ASC')->get()->getResultArray();

        return view('logs/index', [
            'logs'             => $logs,
            'pager'            => $pager,
            'users'            => $users,
            'distinctActions'  => array_column($distinctActions, 'action'),
            'distinctEntities' => array_column($distinctEntities, 'entity'),
            'filters'          => $filters,
            'title'            => 'Log Aktivitas - SIPAT',
        ]);
    }

    public function detail($id)
    {
        $logModel = new AuditLogModel();
        
        $log = $logModel->select('audit_logs.*, users.nama as user_name, users.email as user_email')
                        ->join('users', 'users.id_user = audit_logs.user_id', 'left')
                        ->where('audit_logs.id', $id)
                        ->first();

        if (!$log) {
            throw new PageNotFoundException('Log aktivitas tidak ditemukan.');
        }

        if ($this->request->isAJAX()) {
            return view('logs/modal-detail', ['log' => $log]);
        }

        return view('logs/detail', ['log' => $log]);
    }

    public function clear()
    {
        $logModel = new AuditLogModel();
        $logModel->truncate();

        return redirect()->to('/logs')->with('success', 'Semua log aktivitas berhasil dibersihkan.');
    }
}
