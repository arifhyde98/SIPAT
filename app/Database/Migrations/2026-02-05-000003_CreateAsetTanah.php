<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAsetTanah extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_aset' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'kode_aset' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
            ],
            'nama_aset' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
            ],
            'peruntukan' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
                'null'       => true,
            ],
            'luas' => [
                'type'       => 'DECIMAL',
                'constraint' => '15,2',
                'null'       => true,
            ],
            'alamat' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'lat' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,7',
                'null'       => true,
            ],
            'lng' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,7',
                'null'       => true,
            ],
            'opd' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
                'null'       => true,
            ],
            'dasar_perolehan' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
                'null'       => true,
            ],
            'tanggal_perolehan' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id_aset', true);
        $this->forge->addUniqueKey('kode_aset');
        $this->forge->createTable('aset_tanah', true);
    }

    public function down()
    {
        $this->forge->dropTable('aset_tanah', true);
    }
}
