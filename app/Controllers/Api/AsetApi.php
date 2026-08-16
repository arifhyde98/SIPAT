<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\AsetModel;

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

        $q = trim((string) $this->request->getGet('q'));
        $opd = trim((string) $this->request->getGet('opd'));
        $limit = (int) ($this->request->getGet('limit') ?? 5000);

        if ($limit <= 0 || $limit > 10000) {
            $limit = 5000;
        }

        $asetModel = new AsetModel();
        $results = $asetModel->getAssetsForApi(['q' => $q, 'opd' => $opd], $limit);

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

        $asetModel = new AsetModel();
        $asset = $asetModel->getAssetWithStatusForApi($nibarOrId);

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
