<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSuratSkpt extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'nomor_surat' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'desa_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
            ],
            'kepala_desa_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
            ],
            'camat_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
            ],
            'pemohon_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
            ],
            'nama_pemohon' => [
                'type' => 'VARCHAR',
                'constraint' => 150,
            ],
            'nik' => [
                'type' => 'VARCHAR',
                'constraint' => 30,
                'null' => true,
            ],
            'ttl' => [
                'type' => 'VARCHAR',
                'constraint' => 150,
                'null' => true,
            ],
            'jenis_kelamin' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => true,
            ],
            'warga_negara' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
            ],
            'agama' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
            ],
            'pekerjaan' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'alamat_pemohon' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'lokasi_tanah' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'luas_tanah' => [
                'type' => 'DECIMAL',
                'constraint' => '15,2',
                'null' => true,
            ],
            'dasar_perolehan' => [
                'type' => 'VARCHAR',
                'constraint' => 150,
                'null' => true,
            ],
            'batas_utara' => [
                'type' => 'VARCHAR',
                'constraint' => 150,
                'null' => true,
            ],
            'batas_timur' => [
                'type' => 'VARCHAR',
                'constraint' => 150,
                'null' => true,
            ],
            'batas_selatan' => [
                'type' => 'VARCHAR',
                'constraint' => 150,
                'null' => true,
            ],
            'batas_barat' => [
                'type' => 'VARCHAR',
                'constraint' => 150,
                'null' => true,
            ],
            'keterangan' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'tanggal_surat' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'kepala_desa_nama' => [
                'type' => 'VARCHAR',
                'constraint' => 150,
                'null' => true,
            ],
            'kepala_desa_nip' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
            ],
            'camat_nama' => [
                'type' => 'VARCHAR',
                'constraint' => 150,
                'null' => true,
            ],
            'camat_nip' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
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

        $this->forge->addKey('id', true);
        $this->forge->createTable('surat_skpt', true);
    }

    public function down()
    {
        $this->forge->dropTable('surat_skpt', true);
    }
}
