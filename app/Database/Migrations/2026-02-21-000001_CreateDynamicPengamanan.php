<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateDynamicPengamanan extends Migration
{
    public function up()
    {
        // 1. Master Items Table
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'label' => ['type' => 'VARCHAR', 'constraint' => 255],
            'is_active' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('master_pengamanan_items');

        // 2. Values Table
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'id_pengamanan' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'id_item' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'is_checked' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('id_pengamanan', 'pengamanan_fisik', 'id_pengamanan', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_item', 'master_pengamanan_items', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('pengamanan_fisik_values');

        // 3. Seed Default Items
        $db = \Config\Database::connect();
        $items = [
            ['label' => 'Sertifikat Ada', 'is_active' => 1],
            ['label' => 'Pagar', 'is_active' => 1],
            ['label' => 'Papan Nama', 'is_active' => 1],
            ['label' => 'Dikuasai Pihak Lain', 'is_active' => 1],
        ];
        $db->table('master_pengamanan_items')->insertBatch($items);

        // 4. Migrate Existing Data (Optional: memindahkan data lama ke struktur baru)
        $existing = $db->table('pengamanan_fisik')->get()->getResultArray();
        $masterItems = $db->table('master_pengamanan_items')->get()->getResultArray();

        $itemMap = [];
        foreach ($masterItems as $m) $itemMap[$m['label']] = $m['id'];

        $valuesBatch = [];
        foreach ($existing as $row) {
            if (isset($itemMap['Sertifikat Ada'])) {
                $valuesBatch[] = ['id_pengamanan' => $row['id_pengamanan'], 'id_item' => $itemMap['Sertifikat Ada'], 'is_checked' => $row['sertifikat_ada'] ?? 0];
            }
            if (isset($itemMap['Pagar'])) {
                $valuesBatch[] = ['id_pengamanan' => $row['id_pengamanan'], 'id_item' => $itemMap['Pagar'], 'is_checked' => $row['pagar'] ?? 0];
            }
            if (isset($itemMap['Papan Nama'])) {
                $valuesBatch[] = ['id_pengamanan' => $row['id_pengamanan'], 'id_item' => $itemMap['Papan Nama'], 'is_checked' => $row['papan_nama'] ?? 0];
            }
            if (isset($itemMap['Dikuasai Pihak Lain'])) {
                $valuesBatch[] = ['id_pengamanan' => $row['id_pengamanan'], 'id_item' => $itemMap['Dikuasai Pihak Lain'], 'is_checked' => $row['dikuasai_pihak_lain'] ?? 0];
            }
        }

        if (!empty($valuesBatch)) {
            $chunks = array_chunk($valuesBatch, 100);
            foreach ($chunks as $chunk) {
                $db->table('pengamanan_fisik_values')->insertBatch($chunk);
            }
        }
    }

    public function down()
    {
        $this->forge->dropTable('pengamanan_fisik_values');
        $this->forge->dropTable('master_pengamanan_items');
    }
}
