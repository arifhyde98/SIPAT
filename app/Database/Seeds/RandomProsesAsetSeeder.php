<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RandomProsesAsetSeeder extends Seeder
{
    public function run()
    {
        $db = $this->db;

        $statusRows = $db->table('status_proses')
            ->select('id_status, nama_status')
            ->where('nama_status !=', 'Belum Diurus')
            ->get()
            ->getResultArray();

        if (empty($statusRows)) {
            return;
        }

        $statusIds = array_column($statusRows, 'id_status');
        $statusById = [];
        foreach ($statusRows as $row) {
            $statusById[(int) $row['id_status']] = $row['nama_status'];
        }

        $asetRows = $db->table('aset_tanah')
            ->select('id_aset')
            ->get()
            ->getResultArray();

        if (empty($asetRows)) {
            return;
        }

        $now = date('Y-m-d H:i:s');
        $today = new \DateTimeImmutable('today');

        foreach ($asetRows as $aset) {
            $idAset = (int) $aset['id_aset'];

            $exists = $db->table('proses_aset')
                ->select('id_proses')
                ->where('id_aset', $idAset)
                ->limit(1)
                ->get()
                ->getRowArray();

            if ($exists) {
                continue;
            }

            $randomStatusId = $statusIds[array_rand($statusIds)];
            $statusName = $statusById[$randomStatusId] ?? '';

            $daysBack = random_int(1, 90);
            $startDate = $today->sub(new \DateInterval('P' . $daysBack . 'D'));
            $tglMulai = $startDate->format('Y-m-d');

            $tglSelesai = null;
            $durasiHari = null;
            if (in_array($statusName, ['Sertifikat Terbit', 'Selesai'], true)) {
                $daysForward = random_int(0, 30);
                $endDate = $startDate->add(new \DateInterval('P' . $daysForward . 'D'));
                if ($endDate > $today) {
                    $endDate = $today;
                }
                $tglSelesai = $endDate->format('Y-m-d');
                $durasiHari = (int) $startDate->diff($endDate)->format('%a');
            }

            $db->table('proses_aset')->insert([
                'id_aset' => $idAset,
                'id_status' => $randomStatusId,
                'tgl_mulai' => $tglMulai,
                'tgl_selesai' => $tglSelesai,
                'keterangan' => null,
                'durasi_hari' => $durasiHari,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }
}
