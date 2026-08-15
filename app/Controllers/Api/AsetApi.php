<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;

class AsetApi extends BaseController
{
    private function validateApiKey(): bool
    {
        $expectedKey = env('SIPAT_API_KEY', 'SIPAT-ELABEL-SECURE-KEY-2026');
        $headerKey = $this->request->getHeaderLine('X-API-KEY');
        $queryKey  = $this->request->getGet('api_key');

        $providedKey = !empty($headerKey) ? $headerKey : $queryKey;

        return !empty($providedKey) && hash_equals($expectedKey, $providedKey);
    }

    public function index()
    {
        if (!$this->validateApiKey()) {
            return $this->response->setJSON([
                'status'  => 401,
                'message' => 'Unauthorized: Invalid or missing API Key'
            ])->setStatusCode(401);
        }

        $db = \Config\Database::connect();
        $q = trim((string) $this->request->getGet('q'));
        $opd = trim((string) $this->request->getGet('opd'));
        $limit = (int) ($this->request->getGet('limit') ?? 5000);

        if ($limit <= 0 || $limit > 10000) {
            $limit = 5000;
        }

        $builder = $db->table('aset_tanah a')
            ->select('a.*, sp.nama_status as status_terkini, sp.warna as warna_status, sp.kategori as kategori_status')
            ->join('(
                SELECT p1.id_aset, p1.id_status
                FROM proses_aset p1
                JOIN (
                    SELECT id_aset, MAX(id_proses) AS max_id
                    FROM proses_aset
                    GROUP BY id_aset
                ) p2 ON p1.id_aset = p2.id_aset AND p1.id_proses = p2.max_id
            ) r', 'r.id_aset = a.id_aset', 'left')
            ->join('status_proses sp', 'sp.id_status = r.id_status', 'left');

        if (!empty($q)) {
            $builder->groupStart()
                ->like('a.kode_aset', $q)
                ->orLike('a.nama_aset', $q)
                ->orLike('a.peruntukan', $q)
                ->groupEnd();
        }

        if (!empty($opd)) {
            $builder->where('a.opd', $opd);
        }

        $builder->orderBy('a.id_aset', 'DESC')
            ->limit($limit);

        $results = $builder->get()->getResultArray();

        return $this->response->setJSON([
            'status' => 200,
            'total'  => count($results),
            'data'   => $results
        ]);
    }

    public function show($nibarOrId)
    {
        if (!$this->validateApiKey()) {
            return $this->response->setJSON([
                'status'  => 401,
                'message' => 'Unauthorized: Invalid or missing API Key'
            ])->setStatusCode(401);
        }

        $db = \Config\Database::connect();
        $builder = $db->table('aset_tanah a')
            ->select('a.*, sp.nama_status as status_terkini, sp.warna as warna_status, sp.kategori as kategori_status')
            ->join('(
                SELECT p1.id_aset, p1.id_status
                FROM proses_aset p1
                JOIN (
                    SELECT id_aset, MAX(id_proses) AS max_id
                    FROM proses_aset
                    GROUP BY id_aset
                ) p2 ON p1.id_aset = p2.id_aset AND p1.id_proses = p2.max_id
            ) r', 'r.id_aset = a.id_aset', 'left')
            ->join('status_proses sp', 'sp.id_status = r.id_status', 'left');

        if (is_numeric($nibarOrId)) {
            $builder->where('a.id_aset', $nibarOrId)->orWhere('a.kode_aset', $nibarOrId);
        } else {
            $builder->where('a.kode_aset', urldecode($nibarOrId));
        }

        $asset = $builder->get()->getRowArray();

        if (!$asset) {
            return $this->response->setJSON([
                'status'  => 404,
                'message' => 'Aset tanah tidak ditemukan di SIPAT'
            ])->setStatusCode(404);
        }

        return $this->response->setJSON([
            'status' => 200,
            'data'   => $asset
        ]);
    }
}
