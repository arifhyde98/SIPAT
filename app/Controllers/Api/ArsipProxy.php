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

    public function viewPdf($id_aset)
    {
        if (!session()->get('is_login') && !$this->validateApiKey()) {
            return $this->response->setStatusCode(401)->setBody('Unauthorized: Access requires valid login session or API Key');
        }

        $asetModel = new AsetModel();
        $aset = $asetModel->find($id_aset);

        if (!$aset || empty($aset['kode_aset'])) {
            return $this->response->setStatusCode(404)->setBody('Aset tidak ditemukan atau tidak memiliki Kode Aset');
        }

        $nibar = $aset['kode_aset'];
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

            if ($statusCode !== 200 || empty($body['data']['pdf_url'])) {
                return $this->response->setStatusCode(404)->setBody('File PDF Sertifikat belum tersedia di server eLabel');
            }

            $pdfUrl = $body['data']['pdf_url'];

            if (!str_starts_with($pdfUrl, 'http://') && !str_starts_with($pdfUrl, 'https://')) {
                $parsedApiUrl = parse_url($apiUrl);
                $baseUrl = ($parsedApiUrl['scheme'] ?? 'http') . '://' . ($parsedApiUrl['host'] ?? 'localhost') . (isset($parsedApiUrl['port']) ? ':' . $parsedApiUrl['port'] : '');
                $pdfUrl = $baseUrl . '/' . ltrim($pdfUrl, '/');
            }

            $pdfResponse = $client->request('GET', $pdfUrl, [
                'headers' => [
                    'X-API-KEY' => $apiKey,
                ],
                'http_errors' => false,
                'connect_timeout' => 10,
                'timeout' => 30
            ]);

            if ($pdfResponse->getStatusCode() !== 200) {
                return $this->response->setStatusCode(404)->setBody('Gagal memuat dokumen PDF dari server eLabel');
            }

            $pdfContent = $pdfResponse->getBody();
            $contentType = $pdfResponse->getHeaderLine('Content-Type') ?: 'application/pdf';

            return $this->response
                ->setHeader('Content-Type', $contentType)
                ->setHeader('Content-Disposition', 'inline; filename="Sertifikat_' . preg_replace('/[^a-zA-Z0-9_-]/', '_', $nibar) . '.pdf"')
                ->setHeader('Content-Length', (string) strlen($pdfContent))
                ->setBody($pdfContent);

        } catch (\Exception $e) {
            return $this->response->setStatusCode(500)->setBody('Gagal terhubung ke server eLabel: ' . $e->getMessage());
        }
    }
}
