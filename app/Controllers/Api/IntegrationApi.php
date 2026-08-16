<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Libraries\SyncService;
use App\Models\AsetModel;
use App\Models\ProsesAsetModel;
use App\Models\StatusProsesModel;

class IntegrationApi extends BaseController
{
    private function validateApiKey(): bool
    {
        $expectedKey = env('SIPAT_API_KEY', 'SIPAT-ELABEL-SECURE-KEY-2026');
        $headerKey   = $this->request->getHeaderLine('X-API-KEY');
        $queryKey    = $this->request->getGet('api_key');
        $providedKey = !empty($headerKey) ? $headerKey : $queryKey;

        return !empty($providedKey) && hash_equals($expectedKey, $providedKey);
    }

    public function certificateIssued()
    {
        if (!$this->validateApiKey()) {
            return $this->response->setJSON([
                'status'  => 401,
                'message' => 'Unauthorized: Invalid or missing API Key'
            ])->setStatusCode(401);
        }

        $json = $this->request->getJSON(true) ?? $this->request->getPost();
        $eventId  = $json['event_id'] ?? null;
        $nibar    = trim((string) ($json['nibar'] ?? ''));
        $changes  = $json['changes'] ?? [];
        $reason   = $json['reason'] ?? 'Penerbitan Sertifikat Baru di eLabel';
        $operator = $json['operator'] ?? 'eLabel System';

        if (empty($nibar)) {
            return $this->response->setJSON([
                'status'  => 400,
                'message' => 'Bad Request: Field NIBAR wajib diisi'
            ])->setStatusCode(400);
        }

        // Idempotency check
        if ($eventId && SyncService::isEventProcessed($eventId)) {
            return $this->response->setJSON([
                'status'  => 200,
                'message' => 'Event already processed'
            ]);
        }

        $asetModel = new AsetModel();
        $aset = $asetModel->where('kode_aset', $nibar)->first();

        if (!$aset) {
            return $this->response->setJSON([
                'status'  => 404,
                'message' => "Aset dengan NIBAR {$nibar} tidak ditemukan di SIPAT"
            ])->setStatusCode(404);
        }

        // Prepare updates
        $updateData = [];
        if (isset($changes['luas']['new'])) {
            $updateData['luas'] = $changes['luas']['new'];
        }
        if (isset($changes['alamat']['new'])) {
            $updateData['alamat'] = $changes['alamat']['new'];
        }

        if (!empty($updateData)) {
            $asetModel->update($aset['id_aset'], $updateData);
        }

        // Add progress 'Bersertifikat' if status_proses table has it
        $statusModel = new StatusProsesModel();
        $statusBersertifikat = $statusModel
            ->like('nama_status', 'Bersertifikat')
            ->orLike('nama_status', 'Sertifikat')
            ->first();

        if ($statusBersertifikat) {
            $prosesModel = new ProsesAsetModel();
            $prosesModel->insert([
                'id_aset'     => $aset['id_aset'],
                'id_status'   => $statusBersertifikat['id_status'],
                'keterangan'  => 'Status terbukti otomatis dari pengarsipan eLabel: ' . ($json['no_sertipikat'] ?? '-'),
                'tgl_mulai'   => date('Y-m-d'),
            ]);
        }

        // Audit Log
        SyncService::logAudit([
            'event_id'       => $eventId ?: bin2hex(random_bytes(16)),
            'correlation_id' => $json['correlation_id'] ?? null,
            'nibar'          => $nibar,
            'event_name'     => 'CERTIFICATE_ISSUED',
            'source_system'  => 'elabel',
            'direction'      => 'inbound',
            'changes'        => $changes,
            'reason'         => $reason,
            'sync_status'    => 'SUCCESS',
            'created_by'     => $operator,
        ]);

        return $this->response->setJSON([
            'status'  => 200,
            'message' => 'Integrasi penerbitan sertifikat berhasil diproses di SIPAT'
        ]);
    }

    public function assetUpdated()
    {
        if (!$this->validateApiKey()) {
            return $this->response->setJSON([
                'status'  => 401,
                'message' => 'Unauthorized: Invalid or missing API Key'
            ])->setStatusCode(401);
        }

        $json = $this->request->getJSON(true) ?? $this->request->getPost();
        $eventId  = $json['event_id'] ?? null;
        $nibar    = trim((string) ($json['nibar'] ?? ''));
        $source   = $json['source'] ?? 'elabel';
        $changes  = $json['changes'] ?? [];
        $reason   = $json['reason'] ?? 'Pembaruan data dari eLabel';
        $operator = $json['operator'] ?? 'eLabel System';

        // Loop prevention check
        if ($source === 'sipat') {
            return $this->response->setJSON([
                'status'  => 200,
                'message' => 'Loop prevention: Source is sipat. Ignored.'
            ]);
        }

        if (empty($nibar)) {
            return $this->response->setJSON([
                'status'  => 400,
                'message' => 'Bad Request: Field NIBAR wajib diisi'
            ])->setStatusCode(400);
        }

        // Idempotency check
        if ($eventId && SyncService::isEventProcessed($eventId)) {
            return $this->response->setJSON([
                'status'  => 200,
                'message' => 'Event already processed'
            ]);
        }

        $asetModel = new AsetModel();
        $aset = $asetModel->where('kode_aset', $nibar)->first();

        if (!$aset) {
            return $this->response->setJSON([
                'status'  => 404,
                'message' => "Aset dengan NIBAR {$nibar} tidak ditemukan di SIPAT"
            ])->setStatusCode(404);
        }

        // Whitelist allowed fields for SIPAT
        $allowedMap = [
            'luas'              => 'luas',
            'alamat'            => 'alamat',
            'nilai_perolehan'   => 'harga_perolehan',
            'tanggal_perolehan' => 'tanggal_perolehan',
            'cara_perolehan'    => 'dasar_perolehan',
            'opd'               => 'opd',
            'status_penggunaan' => 'peruntukan',
            'spesifikasi'       => 'nama_aset'
        ];

        $updateData = [];
        foreach ($changes as $field => $val) {
            if (isset($allowedMap[$field])) {
                $dbField = $allowedMap[$field];
                $updateData[$dbField] = is_array($val) ? ($val['new'] ?? null) : $val;
            }
        }

        if (!empty($updateData)) {
            $asetModel->update($aset['id_aset'], $updateData);
        }

        // Audit Log
        SyncService::logAudit([
            'event_id'       => $eventId ?: bin2hex(random_bytes(16)),
            'correlation_id' => $json['correlation_id'] ?? null,
            'nibar'          => $nibar,
            'event_name'     => 'ASSET_DATA_CHANGED',
            'source_system'  => $source,
            'direction'      => 'inbound',
            'changes'        => $changes,
            'reason'         => $reason,
            'sync_status'    => 'SUCCESS',
            'created_by'     => $operator,
        ]);

        return $this->response->setJSON([
            'status'  => 200,
            'message' => 'Sinkronisasi data aset berhasil diperbarui di SIPAT'
        ]);
    }

    public function certificateDeleted()
    {
        if (!$this->validateApiKey()) {
            return $this->response->setJSON([
                'status'  => 401,
                'message' => 'Unauthorized: Invalid or missing API Key'
            ])->setStatusCode(401);
        }

        $json = $this->request->getJSON(true) ?? $this->request->getPost();
        $eventId  = $json['event_id'] ?? null;
        $nibar    = trim((string) ($json['nibar'] ?? ''));
        $reason   = $json['reason'] ?? 'Penghapusan sertifikat di eLabel';
        $operator = $json['operator'] ?? 'eLabel System';

        if (empty($nibar)) {
            return $this->response->setJSON([
                'status'  => 400,
                'message' => 'Bad Request: Field NIBAR wajib diisi'
            ])->setStatusCode(400);
        }

        // Idempotency check
        if ($eventId && SyncService::isEventProcessed($eventId)) {
            return $this->response->setJSON([
                'status'  => 200,
                'message' => 'Event already processed'
            ]);
        }

        $asetModel = new AsetModel();
        $aset = $asetModel->where('kode_aset', $nibar)->first();

        if ($aset) {
            $statusModel = new StatusProsesModel();
            $statusBersertifikat = $statusModel
                ->like('nama_status', 'Bersertifikat')
                ->orLike('nama_status', 'Sertifikat')
                ->first();

            if ($statusBersertifikat) {
                // Delete the latest proses_aset entry matching this status for this asset to revert back to previous status
                $prosesModel = new ProsesAsetModel();
                $prosesModel
                    ->where('id_aset', $aset['id_aset'])
                    ->where('id_status', $statusBersertifikat['id_status'])
                    ->delete();
            }
        }

        // Audit Log
        SyncService::logAudit([
            'event_id'       => $eventId ?: bin2hex(random_bytes(16)),
            'correlation_id' => $json['correlation_id'] ?? null,
            'nibar'          => $nibar,
            'event_name'     => 'CERTIFICATE_DELETED',
            'source_system'  => 'elabel',
            'direction'      => 'inbound',
            'changes'        => ['status' => ['old' => 'Bersertifikat', 'new' => 'Dikembalikan ke Status Sebelumnya']],
            'reason'         => $reason,
            'sync_status'    => 'SUCCESS',
            'created_by'     => $operator,
        ]);

        return $this->response->setJSON([
            'status'  => 200,
            'message' => 'Penghapusan sertifikat diproses. Status proses SIPAT dikembalikan ke status sebelumnya.'
        ]);
    }
}
