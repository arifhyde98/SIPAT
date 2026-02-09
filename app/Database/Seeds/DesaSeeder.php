<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DesaSeeder extends Seeder
{
    public function run()
    {
        $rows = [
            'Balaesang' => [
                ['Kampung Baru Sibayu', 'Desa'],
                ['Labean', 'Desa'],
                ['Lombonga', 'Desa'],
                ['Malino', 'Desa'],
                ['Mapane Tambu', 'Desa'],
                ['Meli', 'Desa'],
                ['Sibayu', 'Desa'],
                ['Sibualong', 'Desa'],
                ['Simagaya', 'Desa'],
                ['Sipure', 'Desa'],
                ['Siweli', 'Desa'],
                ['Tambu', 'Desa'],
                ['Tovia Tambu', 'Desa'],
            ],
            'Balaesang Tanjung' => [
                ['Kamonji', 'Desa'],
                ['Ketong', 'Desa'],
                ['Malei', 'Desa'],
                ['Manimbaya', 'Desa'],
                ['Palau', 'Desa'],
                ['Pomolulu', 'Desa'],
                ['Rano', 'Desa'],
                ['Walandano', 'Desa'],
            ],
            'Banawa' => [
                ['Loli Dondo', 'Desa'],
                ['Loli Oge', 'Desa'],
                ['Loli Pesua', 'Desa'],
                ['Loli Saluran', 'Desa'],
                ['Loli Tasiburi', 'Desa'],
                ['Boneoge', 'Kelurahan'],
                ['Boya', 'Kelurahan'],
                ['Ganti', 'Kelurahan'],
                ['Gunung Bale', 'Kelurahan'],
                ['Kabonga Besar', 'Kelurahan'],
                ['Kabonga Kecil', 'Kelurahan'],
                ['Labuan Bajo', 'Kelurahan'],
                ['Maleni', 'Kelurahan'],
                ['Lalombi', 'Kelurahan'],
            ],
            'Banawa Selatan' => [
                ['Bambarimi', 'Desa'],
                ['Lalombi', 'Desa'],
                ['Lembasada', 'Desa'],
                ['Lumbulama', 'Desa'],
                ['Lumbumamara', 'Desa'],
                ['Lumbutarombo', 'Desa'],
                ['Malino', 'Desa'],
                ['Mbuwu', 'Desa'],
                ['Ongulara', 'Desa'],
                ['Salumpaku', 'Desa'],
                ['Salungkaenu', 'Desa'],
                ['Salusumbu', 'Desa'],
                ['Sarombaya', 'Desa'],
                ['Surumana', 'Desa'],
                ['Tanah Mea', 'Desa'],
                ['Tanampuru', 'Desa'],
                ['Tolongano', 'Desa'],
                ['Tosale', 'Desa'],
                ['Watatu', 'Desa'],
            ],
            'Banawa Tengah' => [
                ['Kola-Kola', 'Desa'],
                ['Lampo', 'Desa'],
                ['Limboro', 'Desa'],
                ['Lumbudolo', 'Desa'],
                ['Mekar Baru', 'Desa'],
                ['Powelua', 'Desa'],
                ['Salubomba', 'Desa'],
                ['Towale', 'Desa'],
            ],
            'Dampelas' => [
                ['Budi Mukti', 'Desa'],
                ['Kambayang', 'Desa'],
                ['Karya Mukti', 'Desa'],
                ['Lembah Mukti', 'Desa'],
                ['Long', 'Desa'],
                ['Malonas', 'Desa'],
                ['Pani\'i', 'Desa'],
                ['Parisan Agung', 'Desa'],
                ['Ponggerang', 'Desa'],
                ['Rerang', 'Desa'],
                ['Sabang', 'Desa'],
                ['Sioyong', 'Desa'],
                ['Talaga', 'Desa'],
            ],
            'Labuan' => [
                ['Labuan', 'Desa'],
                ['Labuan Kungguma', 'Desa'],
                ['Labuan Lelea', 'Desa'],
                ['Labuan Lumbubaka', 'Desa'],
                ['Labuan Panimba', 'Desa'],
                ['Labuan Salumbone', 'Desa'],
                ['Labuan Toposo', 'Desa'],
            ],
            'Pinembani' => [
                ['Bambakaenu', 'Desa'],
                ['Bambakanini', 'Desa'],
                ['Dangara\'a', 'Desa'],
                ['Gimpubia', 'Desa'],
                ['Kanagalongga', 'Desa'],
                ['Karavia', 'Desa'],
                ['Palintuma', 'Desa'],
                ['Tavanggeli', 'Desa'],
                ['Tomodo', 'Desa'],
            ],
            'Rio Pakava' => [
                ['Bonemarawa', 'Desa'],
                ['Bukit Indah', 'Desa'],
                ['Lalundu', 'Desa'],
                ['Minti Makmur', 'Desa'],
                ['Mbulawa', 'Desa'],
                ['Ngovi', 'Desa'],
                ['Pakava', 'Desa'],
                ['Panca Mukti', 'Desa'],
                ['Pantolobete', 'Desa'],
                ['Polando Jaya', 'Desa'],
                ['Polanto Jaya', 'Desa'],
                ['Rio Mukti', 'Desa'],
                ['Tinauka', 'Desa'],
                ['Tawiora', 'Desa'],
            ],
            'Sindue' => [
                ['Amal', 'Desa'],
                ['Dalaka', 'Desa'],
                ['Enu', 'Desa'],
                ['Kavaya', 'Desa'],
                ['Kumbasa', 'Desa'],
                ['Lero', 'Desa'],
                ['Lero Tatari', 'Desa'],
                ['Marana', 'Desa'],
                ['Masaingi', 'Desa'],
                ['Sumari', 'Desa'],
                ['Taripa', 'Desa'],
                ['Toaya', 'Desa'],
                ['Toaya Vunta', 'Desa'],
            ],
            'Sindue Tobata' => [
                ['Alindau', 'Desa'],
                ['Oti', 'Desa'],
                ['Sikara Tobata', 'Desa'],
                ['Sindosa', 'Desa'],
                ['Sipeso', 'Desa'],
                ['Tamarenja', 'Desa'],
            ],
            'Sindue Tombusabora' => [
                ['Batusuya', 'Desa'],
                ['Batusuya Go\'o', 'Desa'],
                ['Kaliburu', 'Desa'],
                ['Kaliburu Kata', 'Desa'],
                ['Saloya', 'Desa'],
                ['Tibo', 'Desa'],
            ],
            'Sirenja' => [
                ['Balintuma', 'Desa'],
                ['Damapal', 'Desa'],
                ['Jonooge', 'Desa'],
                ['Lende', 'Desa'],
                ['Lende Tovea', 'Desa'],
                ['Lompia', 'Desa'],
                ['Ombo', 'Desa'],
                ['Sibado', 'Desa'],
                ['Sipi', 'Desa'],
                ['Tanjung Padang', 'Desa'],
                ['Tompe', 'Desa'],
                ['Tondo', 'Desa'],
                ['Ujumbou', 'Desa'],
            ],
            'Sojol' => [
                ['Balukang', 'Desa'],
                ['Balukang II', 'Desa'],
                ['Bou', 'Desa'],
                ['Bukit Harapan', 'Desa'],
                ['Panggalasiang', 'Desa'],
                ['Samalili', 'Desa'],
                ['Siboang', 'Desa'],
                ['Siwelempu', 'Desa'],
                ['Tonggolobibi', 'Desa'],
            ],
            'Sojol Utara' => [
                ['Bengkoli', 'Desa'],
                ['Lenju', 'Desa'],
                ['Ogoamas I', 'Desa'],
                ['Ogoamas II', 'Desa'],
                ['Pesik', 'Desa'],
            ],
            'Tanantovea' => [
                ['Bale', 'Desa'],
                ['Guntarano', 'Desa'],
                ['Nupa Bomba', 'Desa'],
                ['Wani Dua', 'Desa'],
                ['Wani Lumbumpetigo', 'Desa'],
                ['Wani Satu', 'Desa'],
                ['Wani Tiga', 'Desa'],
                ['Wombo', 'Desa'],
                ['Wombo Kalonggo', 'Desa'],
                ['Wombo Mpanau', 'Desa'],
            ],
        ];

        $kecamatanRows = $this->db->table('kecamatan')->select('id, nama')->get()->getResultArray();
        $kecamatanMap = [];
        foreach ($kecamatanRows as $row) {
            $kecamatanMap[strtolower((string) $row['nama'])] = (int) $row['id'];
        }

        if (!$kecamatanMap) {
            return;
        }

        $existingRows = $this->db->table('desa')->select('kecamatan_id, nama')->get()->getResultArray();
        $existing = [];
        foreach ($existingRows as $row) {
            $existing[$row['kecamatan_id'] . '|' . strtolower((string) $row['nama'])] = true;
        }

        $missingKecamatan = [];
        $now = date('Y-m-d H:i:s');
        $data = [];
        foreach ($rows as $kecamatanName => $desaList) {
            $kecKey = strtolower($kecamatanName);
            $kecamatanId = $kecamatanMap[$kecKey] ?? null;
            if (!$kecamatanId) {
                $missingKecamatan[] = $kecamatanName;
                continue;
            }
            foreach ($desaList as $desa) {
                $nama = $desa[0];
                $jenis = $desa[1];
                $key = $kecamatanId . '|' . strtolower($nama);
                if (isset($existing[$key])) {
                    continue;
                }
                $data[] = [
                    'kecamatan_id' => $kecamatanId,
                    'nama' => $nama,
                    'jenis' => $jenis,
                    'created_at' => $now,
                ];
            }
        }

        if ($missingKecamatan) {
            throw new \RuntimeException('Kecamatan tidak ditemukan: ' . implode(', ', array_unique($missingKecamatan)));
        }

        if ($data) {
            $this->db->table('desa')->insertBatch($data);
        }
    }
}
