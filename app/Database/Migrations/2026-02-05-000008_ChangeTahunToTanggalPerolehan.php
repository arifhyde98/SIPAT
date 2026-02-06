<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ChangeTahunToTanggalPerolehan extends Migration
{
    public function up()
    {
        if (! $this->db->fieldExists('tanggal_perolehan', 'aset_tanah')) {
            $this->forge->addColumn('aset_tanah', [
                'tanggal_perolehan' => [
                    'type' => 'DATE',
                    'null' => true,
                    'after' => 'harga_perolehan',
                ],
            ]);
        }

        if ($this->db->fieldExists('tahun_perolehan', 'aset_tanah')) {
            $this->forge->dropColumn('aset_tanah', 'tahun_perolehan');
        }
    }

    public function down()
    {
        if ($this->db->fieldExists('tanggal_perolehan', 'aset_tanah')) {
            $this->forge->dropColumn('aset_tanah', 'tanggal_perolehan');
        }

        $this->forge->addColumn('aset_tanah', [
            'tahun_perolehan' => [
                'type'       => 'INT',
                'constraint' => 4,
                'null'       => true,
                'after'      => 'harga_perolehan',
            ],
        ]);
    }
}
