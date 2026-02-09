<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class KecamatanSeeder extends Seeder
{
    public function run()
    {
        $names = [
            'Balaesang',
            'Balaesang Tanjung',
            'Banawa',
            'Banawa Selatan',
            'Banawa Tengah',
            'Dampelas',
            'Labuan',
            'Pinembani',
            'Rio Pakava',
            'Sindue',
            'Sindue Tobata',
            'Sindue Tombusabora',
            'Sirenja',
            'Sojol',
            'Sojol Utara',
            'Tanantovea',
        ];

        $existingRows = $this->db->table('kecamatan')->select('nama')->get()->getResultArray();
        $existing = [];
        foreach ($existingRows as $row) {
            $existing[strtolower((string) $row['nama'])] = true;
        }

        $now = date('Y-m-d H:i:s');
        $data = [];
        foreach ($names as $name) {
            $key = strtolower($name);
            if (isset($existing[$key])) {
                continue;
            }
            $data[] = [
                'nama' => $name,
                'created_at' => $now,
            ];
        }

        if ($data) {
            $this->db->table('kecamatan')->insertBatch($data);
        }
    }
}
