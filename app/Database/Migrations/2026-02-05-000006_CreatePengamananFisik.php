<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePengamananFisik extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_pengamanan' => [
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
            'sertifikat_ada' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0,
            ],
            'pagar' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0,
            ],
            'papan_nama' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0,
            ],
            'dikuasai_pihak_lain' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0,
            ],
            'catatan' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'tgl_cek' => [
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

        $this->forge->addKey('id_pengamanan', true);
        $this->forge->addUniqueKey('id_aset');
        $this->forge->addForeignKey('id_aset', 'aset_tanah', 'id_aset', 'CASCADE', 'CASCADE');
        $this->forge->createTable('pengamanan_fisik', true);
    }

    public function down()
    {
        $this->forge->dropTable('pengamanan_fisik', true);
    }
}
