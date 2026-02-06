<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nama'       => 'Admin SIPAT',
                'role'       => 'Admin',
                'opd'        => 'Sekretariat',
                'email'      => 'admin@sipat.test',
                'password'   => password_hash('admin123', PASSWORD_BCRYPT),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nama'       => 'Pengelola Aset',
                'role'       => 'Pengelola Aset',
                'opd'        => 'BPKAD',
                'email'      => 'pengelola@sipat.test',
                'password'   => password_hash('admin123', PASSWORD_BCRYPT),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nama'       => 'Petugas Lapangan',
                'role'       => 'Petugas Lapangan',
                'opd'        => 'Dinas Teknis',
                'email'      => 'petugas@sipat.test',
                'password'   => password_hash('admin123', PASSWORD_BCRYPT),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nama'       => 'Pimpinan',
                'role'       => 'Pimpinan',
                'opd'        => 'Pimpinan',
                'email'      => 'pimpinan@sipat.test',
                'password'   => password_hash('admin123', PASSWORD_BCRYPT),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('users')->insertBatch($data);
    }
}
