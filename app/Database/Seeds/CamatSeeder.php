<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CamatSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nama' => 'Camat Banawa',
                'nip' => '197802021999031001',
                'aktif' => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('camat')->insertBatch($data);
    }
}
