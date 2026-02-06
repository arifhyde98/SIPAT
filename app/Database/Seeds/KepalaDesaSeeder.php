<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class KepalaDesaSeeder extends Seeder
{
    public function run()
    {
        $desa = $this->db->table('desa')->get()->getResultArray();
        if (empty($desa)) {
            return;
        }

        $rows = [];
        foreach ($desa as $d) {
            $rows[] = [
                'desa_id' => $d['id'],
                'nama' => 'Kepala Desa ' . $d['nama'],
                'nip' => '1975' . str_pad((string) $d['id'], 6, '0', STR_PAD_LEFT),
                'aktif' => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ];
        }

        $this->db->table('kepala_desa')->insertBatch($rows);
    }
}
