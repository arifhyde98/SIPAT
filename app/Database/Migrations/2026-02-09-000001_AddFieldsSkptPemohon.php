<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddFieldsSkptPemohon extends Migration
{
    public function up()
    {
        if (! $this->db->fieldExists('umur', 'pemohon')) {
            $this->forge->addColumn('pemohon', [
                'umur' => [
                    'type' => 'VARCHAR',
                    'constraint' => 50,
                    'null' => true,
                    'after' => 'ttl',
                ],
            ]);
        }
        if (! $this->db->fieldExists('jabatan', 'pemohon')) {
            $this->forge->addColumn('pemohon', [
                'jabatan' => [
                    'type' => 'VARCHAR',
                    'constraint' => 150,
                    'null' => true,
                    'after' => 'pekerjaan',
                ],
            ]);
        }

        if (! $this->db->fieldExists('alamat_kantor', 'surat_skpt')) {
            $this->forge->addColumn('surat_skpt', [
                'alamat_kantor' => [
                    'type' => 'VARCHAR',
                    'constraint' => 255,
                    'null' => true,
                    'after' => 'nomor_surat',
                ],
            ]);
        }
        if (! $this->db->fieldExists('jenis_tanah', 'surat_skpt')) {
            $this->forge->addColumn('surat_skpt', [
                'jenis_tanah' => [
                    'type' => 'VARCHAR',
                    'constraint' => 150,
                    'null' => true,
                    'after' => 'lokasi_tanah',
                ],
            ]);
        }
        if (! $this->db->fieldExists('status_tanah', 'surat_skpt')) {
            $this->forge->addColumn('surat_skpt', [
                'status_tanah' => [
                    'type' => 'VARCHAR',
                    'constraint' => 255,
                    'null' => true,
                    'after' => 'jenis_tanah',
                ],
            ]);
        }
        if (! $this->db->fieldExists('asal_tanah', 'surat_skpt')) {
            $this->forge->addColumn('surat_skpt', [
                'asal_tanah' => [
                    'type' => 'TEXT',
                    'null' => true,
                    'after' => 'status_tanah',
                ],
            ]);
        }
        if (! $this->db->fieldExists('pernyataan_tanah', 'surat_skpt')) {
            $this->forge->addColumn('surat_skpt', [
                'pernyataan_tanah' => [
                    'type' => 'TEXT',
                    'null' => true,
                    'after' => 'asal_tanah',
                ],
            ]);
        }
    }

    public function down()
    {
        if ($this->db->fieldExists('umur', 'pemohon')) {
            $this->forge->dropColumn('pemohon', 'umur');
        }
        if ($this->db->fieldExists('jabatan', 'pemohon')) {
            $this->forge->dropColumn('pemohon', 'jabatan');
        }

        if ($this->db->fieldExists('alamat_kantor', 'surat_skpt')) {
            $this->forge->dropColumn('surat_skpt', 'alamat_kantor');
        }
        if ($this->db->fieldExists('jenis_tanah', 'surat_skpt')) {
            $this->forge->dropColumn('surat_skpt', 'jenis_tanah');
        }
        if ($this->db->fieldExists('status_tanah', 'surat_skpt')) {
            $this->forge->dropColumn('surat_skpt', 'status_tanah');
        }
        if ($this->db->fieldExists('asal_tanah', 'surat_skpt')) {
            $this->forge->dropColumn('surat_skpt', 'asal_tanah');
        }
        if ($this->db->fieldExists('pernyataan_tanah', 'surat_skpt')) {
            $this->forge->dropColumn('surat_skpt', 'pernyataan_tanah');
        }
    }
}

