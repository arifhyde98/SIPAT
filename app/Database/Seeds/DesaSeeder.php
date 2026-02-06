<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DesaSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['nama' => 'Kabonga Kecil', 'created_at' => date('Y-m-d H:i:s')],
            ['nama' => 'Kabonga Besar', 'created_at' => date('Y-m-d H:i:s')],
            ['nama' => 'Loli', 'created_at' => date('Y-m-d H:i:s')],
        ];

        $this->db->table('desa')->insertBatch($data);
    }
}
