<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateKepalaDesa extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'desa_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'nama' => [
                'type' => 'VARCHAR',
                'constraint' => 150,
            ],
            'nip' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
            ],
            'aktif' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 1,
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

        $this->forge->addKey('id', true);
        $this->forge->addKey('desa_id');
        $this->forge->createTable('kepala_desa', true);
    }

    public function down()
    {
        $this->forge->dropTable('kepala_desa', true);
    }
}
