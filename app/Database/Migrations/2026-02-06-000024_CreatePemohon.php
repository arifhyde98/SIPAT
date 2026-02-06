<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePemohon extends Migration
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
            'nama' => [
                'type' => 'VARCHAR',
                'constraint' => 150,
            ],
            'nik' => [
                'type' => 'VARCHAR',
                'constraint' => 30,
                'null' => true,
            ],
            'ttl' => [
                'type' => 'VARCHAR',
                'constraint' => 150,
                'null' => true,
            ],
            'jenis_kelamin' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => true,
            ],
            'warga_negara' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
            ],
            'agama' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
            ],
            'pekerjaan' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'alamat' => [
                'type' => 'TEXT',
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

        $this->forge->addKey('id', true);
        $this->forge->createTable('pemohon', true);
    }

    public function down()
    {
        $this->forge->dropTable('pemohon', true);
    }
}
