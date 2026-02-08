<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CamatSeeder extends Seeder
{
    public function run()
    {
        $kecamatan = $this->db->table('kecamatan')->get()->getRowArray();
        $kecamatanId = $kecamatan['id'] ?? null;
        if (!$kecamatanId) {
            return;
        }

        $data = [
            [
                'kecamatan_id' => $kecamatanId,
                'nama' => 'Camat Banawa',
                'nip' => '197802021999031001',
                'aktif' => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('camat')->insertBatch($data);
    }
}
