<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateStatusProses extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_status' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nama_status' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'urutan' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'warna' => [
                'type'       => 'VARCHAR',
                'constraint' => 30,
                'null'       => true,
            ],
        ]);

        $this->forge->addKey('id_status', true);
        $this->forge->createTable('status_proses', true);
    }

    public function down()
    {
        $this->forge->dropTable('status_proses', true);
    }
}
