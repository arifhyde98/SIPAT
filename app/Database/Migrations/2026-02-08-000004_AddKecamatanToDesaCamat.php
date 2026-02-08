<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddKecamatanToDesaCamat extends Migration
{
    public function up()
    {
        if (! $this->db->fieldExists('kecamatan_id', 'desa')) {
            $this->forge->addColumn('desa', [
                'kecamatan_id' => [
                    'type' => 'INT',
                    'constraint' => 11,
                    'unsigned' => true,
                    'null' => true,
                    'after' => 'id',
                ],
            ]);
        }

        if (! $this->db->fieldExists('kecamatan_id', 'camat')) {
            $this->forge->addColumn('camat', [
                'kecamatan_id' => [
                    'type' => 'INT',
                    'constraint' => 11,
                    'unsigned' => true,
                    'null' => true,
                    'after' => 'id',
                ],
            ]);
        }

        $this->forge->addKey('kecamatan_id');
    }

    public function down()
    {
        if ($this->db->fieldExists('kecamatan_id', 'desa')) {
            $this->forge->dropColumn('desa', 'kecamatan_id');
        }
        if ($this->db->fieldExists('kecamatan_id', 'camat')) {
            $this->forge->dropColumn('camat', 'kecamatan_id');
        }
    }
}
