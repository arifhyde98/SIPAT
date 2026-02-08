<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DesaSeeder extends Seeder
{
    public function run()
    {
        $kecamatan = $this->db->table('kecamatan')->get()->getRowArray();
        $kecamatanId = $kecamatan['id'] ?? null;
        if (!$kecamatanId) {
            return;
        }

        $data = [
            ['nama' => 'Kabonga Kecil', 'kecamatan_id' => $kecamatanId, 'created_at' => date('Y-m-d H:i:s')],
            ['nama' => 'Kabonga Besar', 'kecamatan_id' => $kecamatanId, 'created_at' => date('Y-m-d H:i:s')],
            ['nama' => 'Loli', 'kecamatan_id' => $kecamatanId, 'created_at' => date('Y-m-d H:i:s')],
        ];

        $this->db->table('desa')->insertBatch($data);
    }
}
