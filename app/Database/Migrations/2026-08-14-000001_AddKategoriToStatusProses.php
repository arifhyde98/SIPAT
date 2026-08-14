<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddKategoriToStatusProses extends Migration
{
    public function up()
    {
        $db = \Config\Database::connect();
        
        // Cek jika kolom belum ada
        if (!$db->fieldExists('kategori', 'status_proses')) {
            $fields = [
                'kategori' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 50,
                    'default'    => 'proses',
                    'after'      => 'warna',
                ],
            ];
            $this->forge->addColumn('status_proses', $fields);
        }

        // Auto-backfill kategori awal berdasarkan nama status
        $rows = $db->table('status_proses')->get()->getResultArray();

        foreach ($rows as $row) {
            $id = (int) $row['id_status'];
            $norm = strtolower(trim((string) ($row['nama_status'] ?? '')));

            $cat = 'proses';
            if ($norm === '' || str_contains($norm, 'belum') || str_contains($norm, 'tanpa')) {
                $cat = 'belum_diurus';
            } elseif (str_contains($norm, 'kendala') || str_contains($norm, 'sengketa') || str_contains($norm, 'masalah') || str_contains($norm, 'batal') || str_contains($norm, 'ditolak')) {
                $cat = 'kendala';
            } elseif (((str_contains($norm, 'sertifikat') || str_contains($norm, 'sertipikat')) && !str_contains($norm, 'proses'))
                || str_contains($norm, 'terbit sertifikat') || str_contains($norm, 'terbit sertipikat') || $norm === 'selesai') {
                $cat = 'bersertifikat';
            }

            $db->table('status_proses')->where('id_status', $id)->update(['kategori' => $cat]);
        }
    }

    public function down()
    {
        $db = \Config\Database::connect();
        if ($db->fieldExists('kategori', 'status_proses')) {
            $this->forge->dropColumn('status_proses', 'kategori');
        }
    }
}
