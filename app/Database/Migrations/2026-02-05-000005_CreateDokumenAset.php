<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateDokumenAset extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_dokumen' => [
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
            'id_proses' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
            'jenis_dokumen' => [
                'type'       => 'VARCHAR',
                'constraint' => 120,
            ],
            'file_path' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'status_dokumen' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
            ],
            'uploaded_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id_dokumen', true);
        $this->forge->addKey('id_aset');
        $this->forge->addKey('id_proses');
        $this->forge->addForeignKey('id_aset', 'aset_tanah', 'id_aset', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_proses', 'proses_aset', 'id_proses', 'SET NULL', 'CASCADE');
        $this->forge->createTable('dokumen_aset', true);
    }

    public function down()
    {
        $this->forge->dropTable('dokumen_aset', true);
    }
}
