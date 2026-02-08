<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class EnforceKecamatanNotNull extends Migration
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

    private function firstKecamatanId(): ?int
    {
        $row = $this->db->table('kecamatan')
            ->select('id')
            ->orderBy('id', 'ASC')
            ->get(1)
            ->getRowArray();

        if (empty($row['id'])) {
            return null;
        }

        return (int) $row['id'];
    }

    public function up()
    {
        $kecId = $this->firstKecamatanId();
        if ($kecId === null) {
            return;
        }

        if ($this->hasConstraint('desa', 'fk_desa_kecamatan')) {
            $this->db->query("ALTER TABLE desa DROP FOREIGN KEY fk_desa_kecamatan");
        }
        if ($this->hasConstraint('camat', 'fk_camat_kecamatan')) {
            $this->db->query("ALTER TABLE camat DROP FOREIGN KEY fk_camat_kecamatan");
        }

        $this->db->query("UPDATE desa SET kecamatan_id = ? WHERE kecamatan_id IS NULL", [$kecId]);
        $this->db->query("UPDATE camat SET kecamatan_id = ? WHERE kecamatan_id IS NULL", [$kecId]);

        if ($this->db->fieldExists('kecamatan_id', 'desa')) {
            $this->db->query("ALTER TABLE desa MODIFY kecamatan_id INT(11) UNSIGNED NOT NULL");
        }
        if ($this->db->fieldExists('kecamatan_id', 'camat')) {
            $this->db->query("ALTER TABLE camat MODIFY kecamatan_id INT(11) UNSIGNED NOT NULL");
        }

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

        if ($this->db->fieldExists('kecamatan_id', 'desa')) {
            $this->db->query("ALTER TABLE desa MODIFY kecamatan_id INT(11) UNSIGNED NULL");
        }
        if ($this->db->fieldExists('kecamatan_id', 'camat')) {
            $this->db->query("ALTER TABLE camat MODIFY kecamatan_id INT(11) UNSIGNED NULL");
        }

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
}

