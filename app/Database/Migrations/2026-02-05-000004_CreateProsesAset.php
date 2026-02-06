<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateProsesAset extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_proses' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_aset' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'id_status' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'tgl_mulai' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'tgl_selesai' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'keterangan' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'durasi_hari' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => true,
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

        $this->forge->addKey('id_proses', true);
        $this->forge->addKey('id_aset');
        $this->forge->addKey('id_status');
        $this->forge->addForeignKey('id_aset', 'aset_tanah', 'id_aset', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_status', 'status_proses', 'id_status', 'RESTRICT', 'CASCADE');
        $this->forge->createTable('proses_aset', true);
    }

    public function down()
    {
        $this->forge->dropTable('proses_aset', true);
    }
}
