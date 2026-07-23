<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddKeteranganToAsetTanah extends Migration
{
    public function up()
    {
        $fields = [
            'keterangan' => [
                'type'       => 'TEXT',
                'null'       => true,
                'after'      => 'tanggal_perolehan'
            ],
        ];
        $this->forge->addColumn('aset_tanah', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('aset_tanah', 'keterangan');
    }
}
