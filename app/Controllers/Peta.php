<?php

namespace App\Controllers;


class Peta extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();
        $query = $db->query(
            "SELECT a.id_aset, a.kode_aset, a.nama_aset, a.lat, a.lng, sp.nama_status, sp.warna
             FROM aset_tanah a
             LEFT JOIN (
                 SELECT p1.id_aset, p1.id_status
                 FROM proses_aset p1
                 JOIN (
                     SELECT id_aset, MAX(id_proses) AS max_id
                     FROM proses_aset
                     GROUP BY id_aset
                 ) p2 ON p1.id_aset = p2.id_aset AND p1.id_proses = p2.max_id
             ) p ON p.id_aset = a.id_aset
             LEFT JOIN status_proses sp ON sp.id_status = p.id_status
             WHERE a.lat IS NOT NULL AND a.lng IS NOT NULL"
        );

        $markers = [];
        foreach ($query->getResultArray() as $row) {
            $markers[] = [
                'id'           => $row['id_aset'],
                'kode'         => $row['kode_aset'],
                'nama'         => $row['nama_aset'],
                'lat'          => (float) $row['lat'],
                'lng'          => (float) $row['lng'],
                'status'       => $row['nama_status'] ?? 'Belum Diurus',
                'warna_status' => $row['warna'] ?? 'secondary',
            ];
        }

        return view('peta/index', [
            'markers' => $markers,
        ]);
    }
}
