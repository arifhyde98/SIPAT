<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AsetModel;

class Rekonsiliasi extends BaseController
{
    private const API_KEY = 'SIPAT-ELABEL-SECURE-KEY-2026';

    public function __construct()
    {
        // Pastikan hanya admin atau pengelola aset yang bisa mengakses
        $role = session()->get('user_role');
        if (!in_array($role, ['Admin', 'Pengelola Aset'], true)) {
            echo view('errors/html/error_403');
            exit;
        }
    }

    public function index()
    {
        // 1. Ambil semua NIB dari eLabel melalui API
        $eLabelNibarList = $this->fetchElabelNibarList();

        // 2. Ambil aset dari SIPAT yang berstatus "Bersertifikat" atau "Bersertifikat (Duplikat)"
        // Status ID untuk Bersertifikat biasanya adalah 1 (tapi kita cek berdasarkan nama di DB atau join, 
        // lebih aman cari dengan keyword di join jika mungkin, atau asumsikan ID status tertentu.
        // Di SIPAT, kita akan query aset_tanah dan mengambil yang statusnya relevan.
        // Mari kita ambil semua aset saja dan filter di PHP, atau query join dengan status.
        $db = \Config\Database::connect();
        
        $builder = $db->table('aset_tanah a');
        $builder->select('a.id_aset, a.kode_aset, a.nama_aset, a.alamat, sp.nama_status as status_saat_ini');
        $builder->join(
            '(SELECT p1.id_aset, p1.id_status
              FROM proses_aset p1
              JOIN (
                  SELECT id_aset, MAX(id_proses) AS max_id
                  FROM proses_aset
                  GROUP BY id_aset
              ) p2 ON p1.id_aset = p2.id_aset AND p1.id_proses = p2.max_id) p',
            'p.id_aset = a.id_aset',
            'left',
            false
        );
        $builder->join('status_proses sp', 'sp.id_status = p.id_status', 'left');
        
        // Hanya yang bersertifikat (mencakup Bersertifikat dan Bersertifikat Duplikat)
        $builder->like('sp.nama_status', 'Bersertifikat');
        $builder->where('a.kode_aset !=', '');
        $builder->where('a.kode_aset IS NOT NULL');
        
        $asetSipat = $builder->get()->getResultArray();

        $matchList = [];
        $missList = [];

        foreach ($asetSipat as $aset) {
            $nibar = trim($aset['kode_aset']);
            if (in_array($nibar, $eLabelNibarList, true)) {
                $matchList[] = $aset;
            } else {
                $missList[] = $aset;
            }
        }

        $data = [
            'title'     => 'Rekonsiliasi Sertifikat',
            'matchList' => $matchList,
            'missList'  => $missList,
            'totalElabel' => count($eLabelNibarList)
        ];

        return view('rekonsiliasi/index', $data);
    }

    private function fetchElabelNibarList(): array
    {
        $client = \Config\Services::curlrequest();
        $apiUrl = env('ELABEL_API_URL', 'http://elabel.test/api/v1/sertifikat/');
        
        // Sesuaikan dengan endpoint baru (hapus trailing slash dan tambahkan -all-nibar)
        $baseUrl = str_replace('sertifikat/', '', $apiUrl);
        $endpoint = rtrim($baseUrl, '/') . '/sertifikat-all-nibar';

        try {
            $response = $client->request('GET', $endpoint, [
                'headers' => [
                    'X-API-KEY' => self::API_KEY,
                    'Accept'    => 'application/json'
                ],
                'http_errors' => false,
                'connect_timeout' => 5,
                'timeout' => 15
            ]);

            if ($response->getStatusCode() === 200) {
                $body = json_decode($response->getBody(), true);
                if (isset($body['data']) && is_array($body['data'])) {
                    return $body['data'];
                }
            }
            return [];
        } catch (\Exception $e) {
            log_message('error', 'Gagal fetch eLabel Nibar List: ' . $e->getMessage());
            return [];
        }
    }
}
