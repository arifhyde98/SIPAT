<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddHargaPerolehanToAsetTanah extends Migration
{
    public function up()
    {
        $this->forge->addColumn('aset_tanah', [
            'harga_perolehan' => [
                'type'       => 'DECIMAL',
                'constraint' => '18,2',
                'null'       => true,
                'after'      => 'dasar_perolehan',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('aset_tanah', 'harga_perolehan');
    }
}
