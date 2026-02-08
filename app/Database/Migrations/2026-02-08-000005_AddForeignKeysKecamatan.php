<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddForeignKeysKecamatan extends Migration
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
        if (!$this->hasConstraint('desa', 'fk_desa_kecamatan')) {
            $this->db->query(
                "ALTER TABLE desa
                 ADD CONSTRAINT fk_desa_kecamatan
                 FOREIGN KEY (kecamatan_id) REFERENCES kecamatan(id)
                 ON UPDATE CASCADE ON DELETE RESTRICT"
            );
        }

        if (!$this->hasConstraint('camat', 'fk_camat_kecamatan')) {
            $this->db->query(
                "ALTER TABLE camat
                 ADD CONSTRAINT fk_camat_kecamatan
                 FOREIGN KEY (kecamatan_id) REFERENCES kecamatan(id)
                 ON UPDATE CASCADE ON DELETE RESTRICT"
            );
        }
    }

    public function down()
    {
        if ($this->hasConstraint('desa', 'fk_desa_kecamatan')) {
            $this->db->query("ALTER TABLE desa DROP FOREIGN KEY fk_desa_kecamatan");
        }
        if ($this->hasConstraint('camat', 'fk_camat_kecamatan')) {
            $this->db->query("ALTER TABLE camat DROP FOREIGN KEY fk_camat_kecamatan");
        }
    }
}
