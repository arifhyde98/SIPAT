<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddForeignKeysSkpt extends Migration
{
    private function hasConstraint(string $table, string $constraint): bool
    {
        $row = $this->db->query(
            "SELECT CONSTRAINT_NAME
             FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE
             WHERE TABLE_SCHEMA = DATABASE()
               AND TABLE_NAME = ?
               AND CONSTRAINT_NAME = ?",
            [$table, $constraint]
        )->getRowArray();

        return !empty($row);
    }

    public function up()
    {
        if (!$this->hasConstraint('kepala_desa', 'fk_kepala_desa_desa')) {
            $this->db->query(
                "ALTER TABLE kepala_desa
                 ADD CONSTRAINT fk_kepala_desa_desa
                 FOREIGN KEY (desa_id) REFERENCES desa(id)
                 ON UPDATE CASCADE ON DELETE RESTRICT"
            );
        }

        if (!$this->hasConstraint('surat_skpt', 'fk_skpt_desa')) {
            $this->db->query(
                "ALTER TABLE surat_skpt
                 ADD CONSTRAINT fk_skpt_desa
                 FOREIGN KEY (desa_id) REFERENCES desa(id)
                 ON UPDATE CASCADE ON DELETE RESTRICT"
            );
        }
        if (!$this->hasConstraint('surat_skpt', 'fk_skpt_kepala_desa')) {
            $this->db->query(
                "ALTER TABLE surat_skpt
                 ADD CONSTRAINT fk_skpt_kepala_desa
                 FOREIGN KEY (kepala_desa_id) REFERENCES kepala_desa(id)
                 ON UPDATE CASCADE ON DELETE RESTRICT"
            );
        }
        if (!$this->hasConstraint('surat_skpt', 'fk_skpt_camat')) {
            $this->db->query(
                "ALTER TABLE surat_skpt
                 ADD CONSTRAINT fk_skpt_camat
                 FOREIGN KEY (camat_id) REFERENCES camat(id)
                 ON UPDATE CASCADE ON DELETE RESTRICT"
            );
        }
        if (!$this->hasConstraint('surat_skpt', 'fk_skpt_pemohon')) {
            $this->db->query(
                "ALTER TABLE surat_skpt
                 ADD CONSTRAINT fk_skpt_pemohon
                 FOREIGN KEY (pemohon_id) REFERENCES pemohon(id)
                 ON UPDATE CASCADE ON DELETE RESTRICT"
            );
        }
    }

    public function down()
    {
        $drops = [
            'surat_skpt' => [
                'fk_skpt_pemohon',
                'fk_skpt_camat',
                'fk_skpt_kepala_desa',
                'fk_skpt_desa',
            ],
            'kepala_desa' => [
                'fk_kepala_desa_desa',
            ],
        ];

        foreach ($drops as $table => $constraints) {
            foreach ($constraints as $constraint) {
                if ($this->hasConstraint($table, $constraint)) {
                    $this->db->query("ALTER TABLE {$table} DROP FOREIGN KEY {$constraint}");
                }
            }
        }
    }
}
