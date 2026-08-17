<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\AsetModel;

class ArsipProxy extends BaseController
{
    // Configure this URL in your .env file: ELABEL_API_URL="https://elabel.subdomain.com/api/v1/sertifikat/"
    private function validateApiKey(): bool
    {
        $expectedKey = env('SIPAT_API_KEY', 'SIPAT-ELABEL-SECURE-KEY-2026');
        $headerKey   = $this->request->getHeaderLine('X-API-KEY');
        $queryKey    = $this->request->getGet('api_key');
        $providedKey = !empty($headerKey) ? $headerKey : $queryKey;

        return !empty($providedKey) && hash_equals($expectedKey, $providedKey);
    }

    public function cekElabel($id_aset)
    {
        if (!session()->get('is_login') && !$this->validateApiKey()) {
            return $this->response->setJSON([
                'status'  => 401,
                'message' => 'Unauthorized: Access requires valid login session or API Key'
            ])->setStatusCode(401);
        }

        $asetModel = new AsetModel();
        $aset = $asetModel->find($id_aset);

        if (!$aset) {
            return $this->response->setJSON([
                'status' => 404,
                'message' => 'Aset tidak ditemukan di SIPAT'
            ])->setStatusCode(404);
        }

        $nibar = $aset['kode_aset'];
        if (empty($nibar)) {
            return $this->response->setJSON([
                'status' => 400,
                'message' => 'Aset ini tidak memiliki Kode Aset (NIB)'
            ])->setStatusCode(400);
        }

        $client = \Config\Services::curlrequest();
        try {
            $apiUrl = env('ELABEL_API_URL', 'http://elabel.test/api/v1/sertifikat/');
            $apiKey = env('ELABEL_API_KEY', 'SIPAT-ELABEL-SECURE-KEY-2026');
            
            $response = $client->request('GET', $apiUrl . urlencode($nibar), [
                'headers' => [
                    'X-API-KEY' => $apiKey,
                    'Accept'    => 'application/json'
                ],
                'http_errors' => false,
                'connect_timeout' => 5,
                'timeout' => 10
            ]);

            $statusCode = $response->getStatusCode();
            $body = json_decode($response->getBody(), true);

            if ($statusCode === 200 && isset($body['data'])) {
                return $this->response->setJSON($body);
            }

            return $this->response->setJSON([
                'status' => $statusCode,
                'message' => $body['message'] ?? 'Sertifikat tidak ditemukan atau belum diarsipkan',
                'data' => null
            ])->setStatusCode($statusCode);

        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 500,
                'message' => 'Gagal terhubung ke server eLabel: ' . $e->getMessage()
            ])->setStatusCode(500);
        }
    }
}
