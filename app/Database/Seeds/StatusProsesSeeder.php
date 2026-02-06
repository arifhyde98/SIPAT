<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class StatusProsesSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['nama_status' => 'Belum Diurus', 'urutan' => 1, 'warna' => 'secondary'],
            ['nama_status' => 'Proses Pengukuran', 'urutan' => 2, 'warna' => 'info'],
            ['nama_status' => 'Selesai Ukur', 'urutan' => 3, 'warna' => 'primary'],
            ['nama_status' => 'Proses BPN', 'urutan' => 4, 'warna' => 'warning'],
            ['nama_status' => 'PKKPR', 'urutan' => 5, 'warna' => 'warning'],
            ['nama_status' => 'Sertifikat Terbit', 'urutan' => 6, 'warna' => 'success'],
            ['nama_status' => 'Selesai', 'urutan' => 7, 'warna' => 'success'],
            ['nama_status' => 'Kendala/Sengketa', 'urutan' => 99, 'warna' => 'danger'],
        ];

        $this->db->table('status_proses')->insertBatch($data);
    }
}
