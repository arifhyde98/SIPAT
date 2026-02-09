<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddJenisToDesa extends Migration
{
    public function up()
    {
        if (! $this->db->fieldExists('jenis', 'desa')) {
            $this->forge->addColumn('desa', [
                'jenis' => [
                    'type' => 'VARCHAR',
                    'constraint' => 20,
                    'null' => true,
                    'after' => 'nama',
                ],
            ]);
        }

        $this->db->query("UPDATE desa SET jenis = 'Kelurahan' WHERE jenis IS NULL OR jenis = ''");
        $this->db->query("ALTER TABLE desa MODIFY jenis VARCHAR(20) NOT NULL DEFAULT 'Kelurahan'");
    }

    public function down()
    {
        if ($this->db->fieldExists('jenis', 'desa')) {
            $this->forge->dropColumn('desa', 'jenis');
        }
    }
}

