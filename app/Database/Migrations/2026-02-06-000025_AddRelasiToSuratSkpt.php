<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddRelasiToSuratSkpt extends Migration
{
    public function up()
    {
        $table = 'surat_skpt';

        if (! $this->db->fieldExists('desa_id', $table)) {
            $this->forge->addColumn($table, [
                'desa_id' => [
                    'type' => 'INT',
                    'constraint' => 11,
                    'unsigned' => true,
                    'null' => true,
                    'after' => 'nomor_surat',
                ],
            ]);
        }

        if (! $this->db->fieldExists('kepala_desa_id', $table)) {
            $this->forge->addColumn($table, [
                'kepala_desa_id' => [
                    'type' => 'INT',
                    'constraint' => 11,
                    'unsigned' => true,
                    'null' => true,
                    'after' => 'desa_id',
                ],
            ]);
        }

        if (! $this->db->fieldExists('camat_id', $table)) {
            $this->forge->addColumn($table, [
                'camat_id' => [
                    'type' => 'INT',
                    'constraint' => 11,
                    'unsigned' => true,
                    'null' => true,
                    'after' => 'kepala_desa_id',
                ],
            ]);
        }

        if (! $this->db->fieldExists('pemohon_id', $table)) {
            $this->forge->addColumn($table, [
                'pemohon_id' => [
                    'type' => 'INT',
                    'constraint' => 11,
                    'unsigned' => true,
                    'null' => true,
                    'after' => 'camat_id',
                ],
            ]);
        }

        $this->forge->addKey('desa_id');
        $this->forge->addKey('kepala_desa_id');
        $this->forge->addKey('camat_id');
        $this->forge->addKey('pemohon_id');
    }

    public function down()
    {
        $table = 'surat_skpt';

        if ($this->db->fieldExists('pemohon_id', $table)) {
            $this->forge->dropColumn($table, 'pemohon_id');
        }
        if ($this->db->fieldExists('camat_id', $table)) {
            $this->forge->dropColumn($table, 'camat_id');
        }
        if ($this->db->fieldExists('kepala_desa_id', $table)) {
            $this->forge->dropColumn($table, 'kepala_desa_id');
        }
        if ($this->db->fieldExists('desa_id', $table)) {
            $this->forge->dropColumn($table, 'desa_id');
        }
    }
}
