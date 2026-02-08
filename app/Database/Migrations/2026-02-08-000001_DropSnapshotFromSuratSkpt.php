<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DropSnapshotFromSuratSkpt extends Migration
{
    public function up()
    {
        $table = 'surat_skpt';
        $columns = [
            'nama_pemohon',
            'nik',
            'ttl',
            'jenis_kelamin',
            'warga_negara',
            'agama',
            'pekerjaan',
            'alamat_pemohon',
            'kepala_desa_nama',
            'kepala_desa_nip',
            'camat_nama',
            'camat_nip',
        ];

        $existing = [];
        foreach ($columns as $col) {
            if ($this->db->fieldExists($col, $table)) {
                $existing[] = $col;
            }
        }
        if ($existing) {
            $this->forge->dropColumn($table, $existing);
        }
    }

    public function down()
    {
        $table = 'surat_skpt';
        if (!$this->db->fieldExists('nama_pemohon', $table)) {
            $this->forge->addColumn($table, [
                'nama_pemohon' => [
                    'type' => 'VARCHAR',
                    'constraint' => 150,
                ],
            ]);
        }
        if (!$this->db->fieldExists('nik', $table)) {
            $this->forge->addColumn($table, [
                'nik' => [
                    'type' => 'VARCHAR',
                    'constraint' => 30,
                    'null' => true,
                ],
            ]);
        }
        if (!$this->db->fieldExists('ttl', $table)) {
            $this->forge->addColumn($table, [
                'ttl' => [
                    'type' => 'VARCHAR',
                    'constraint' => 150,
                    'null' => true,
                ],
            ]);
        }
        if (!$this->db->fieldExists('jenis_kelamin', $table)) {
            $this->forge->addColumn($table, [
                'jenis_kelamin' => [
                    'type' => 'VARCHAR',
                    'constraint' => 20,
                    'null' => true,
                ],
            ]);
        }
        if (!$this->db->fieldExists('warga_negara', $table)) {
            $this->forge->addColumn($table, [
                'warga_negara' => [
                    'type' => 'VARCHAR',
                    'constraint' => 50,
                    'null' => true,
                ],
            ]);
        }
        if (!$this->db->fieldExists('agama', $table)) {
            $this->forge->addColumn($table, [
                'agama' => [
                    'type' => 'VARCHAR',
                    'constraint' => 50,
                    'null' => true,
                ],
            ]);
        }
        if (!$this->db->fieldExists('pekerjaan', $table)) {
            $this->forge->addColumn($table, [
                'pekerjaan' => [
                    'type' => 'VARCHAR',
                    'constraint' => 100,
                    'null' => true,
                ],
            ]);
        }
        if (!$this->db->fieldExists('alamat_pemohon', $table)) {
            $this->forge->addColumn($table, [
                'alamat_pemohon' => [
                    'type' => 'TEXT',
                    'null' => true,
                ],
            ]);
        }
        if (!$this->db->fieldExists('kepala_desa_nama', $table)) {
            $this->forge->addColumn($table, [
                'kepala_desa_nama' => [
                    'type' => 'VARCHAR',
                    'constraint' => 150,
                    'null' => true,
                ],
            ]);
        }
        if (!$this->db->fieldExists('kepala_desa_nip', $table)) {
            $this->forge->addColumn($table, [
                'kepala_desa_nip' => [
                    'type' => 'VARCHAR',
                    'constraint' => 50,
                    'null' => true,
                ],
            ]);
        }
        if (!$this->db->fieldExists('camat_nama', $table)) {
            $this->forge->addColumn($table, [
                'camat_nama' => [
                    'type' => 'VARCHAR',
                    'constraint' => 150,
                    'null' => true,
                ],
            ]);
        }
        if (!$this->db->fieldExists('camat_nip', $table)) {
            $this->forge->addColumn($table, [
                'camat_nip' => [
                    'type' => 'VARCHAR',
                    'constraint' => 50,
                    'null' => true,
                ],
            ]);
        }
    }
}
