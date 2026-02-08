<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class KecamatanSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['nama' => 'Banawa', 'created_at' => date('Y-m-d H:i:s')],
            ['nama' => 'Banawa Selatan', 'created_at' => date('Y-m-d H:i:s')],
            ['nama' => 'Banawa Tengah', 'created_at' => date('Y-m-d H:i:s')],
        ];

        $this->db->table('kecamatan')->insertBatch($data);
    }
}
