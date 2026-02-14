<?php

namespace App\Database\Seeds;

use CodeIgniter\CLI\CLI;
use CodeIgniter\Database\Seeder;

class AsetTanahDummySeeder extends Seeder
{
    private const TOTAL_DATA = 1000;

    public function run()
    {
        $db = $this->db;

        $statusRows = $db->table('status_proses')
            ->select('id_status, nama_status')
            ->orderBy('urutan', 'ASC')
            ->get()
            ->getResultArray();

        if (empty($statusRows)) {
            $this->call('StatusProsesSeeder');
            $statusRows = $db->table('status_proses')
                ->select('id_status, nama_status')
                ->orderBy('urutan', 'ASC')
                ->get()
                ->getResultArray();
        }

        if (empty($statusRows)) {
            CLI::error('Seeder dibatalkan: tabel status_proses kosong.');
            return;
        }

        $existingKodeRows = $db->table('aset_tanah')->select('kode_aset')->get()->getResultArray();
        $existingKode = [];
        foreach ($existingKodeRows as $row) {
            $kode = (string) ($row['kode_aset'] ?? '');
            if ($kode !== '') {
                $existingKode[$kode] = true;
            }
        }

        $opdList = [
            'BPKAD',
            'Dinas PU',
            'Dinas Pendidikan',
            'Dinas Kesehatan',
            'Dinas Perhubungan',
            'Dinas Sosial',
            'Sekretariat Daerah',
            'Dinas Pertanian',
        ];

        $peruntukanList = [
            'Perkantoran',
            'Sekolah',
            'Puskesmas',
            'Jalan',
            'RTH',
            'Pasar',
            'Gudang',
            'Fasilitas Umum',
        ];

        $dasarPerolehanList = [
            'Pembelian',
            'Hibah',
            'Pelepasan Hak',
            'Tukar Menukar',
            'Putusan Pengadilan',
        ];

        $keteranganByStatus = [
            'Belum Diurus' => 'Belum ada tindak lanjut dokumen.',
            'Proses Pengukuran' => 'Menunggu jadwal ukur lapangan.',
            'Selesai Ukur' => 'Pengukuran lapangan telah selesai.',
            'Proses BPN' => 'Berkas sedang diproses di BPN.',
            'PKKPR' => 'Tahap verifikasi PKKPR.',
            'Sertifikat Terbit' => 'Sertifikat telah diterbitkan.',
            'Selesai' => 'Proses administrasi dinyatakan selesai.',
            'Kendala/Sengketa' => 'Terdapat kendala pada status lahan.',
        ];

        $today = new \DateTimeImmutable('today');
        $now = date('Y-m-d H:i:s');
        $counter = count($existingKode) + 1;
        $inserted = 0;

        $db->transBegin();

        try {
            for ($i = 1; $i <= self::TOTAL_DATA; $i++) {
                do {
                    $kodeAset = sprintf('AST-%06d', $counter++);
                } while (isset($existingKode[$kodeAset]));

                $existingKode[$kodeAset] = true;

                $randomDaysBack = random_int(30, 3650);
                $tanggalPerolehan = $today->sub(new \DateInterval('P' . $randomDaysBack . 'D'));

                $luas = number_format(random_int(120, 25000) + (random_int(0, 99) / 100), 2, '.', '');
                $harga = number_format(random_int(100000000, 5000000000), 2, '.', '');

                $lat = number_format(-0.95 + (random_int(0, 5500000) / 10000000), 7, '.', '');
                $lng = number_format(119.40 + (random_int(0, 13000000) / 10000000), 7, '.', '');

                $opd = $opdList[array_rand($opdList)];
                $peruntukan = $peruntukanList[array_rand($peruntukanList)];
                $dasarPerolehan = $dasarPerolehanList[array_rand($dasarPerolehanList)];

                $asetPayload = [
                    'kode_aset' => $kodeAset,
                    'nama_aset' => 'Aset Tanah Dummy ' . str_pad((string) $i, 4, '0', STR_PAD_LEFT),
                    'peruntukan' => $peruntukan,
                    'luas' => $luas,
                    'alamat' => 'Jl. Dummy Blok ' . random_int(1, 200) . ', Kec. Dummy, Kab. Donggala',
                    'lat' => $lat,
                    'lng' => $lng,
                    'opd' => $opd,
                    'dasar_perolehan' => $dasarPerolehan,
                    'harga_perolehan' => $harga,
                    'tanggal_perolehan' => $tanggalPerolehan->format('Y-m-d'),
                    'created_at' => $now,
                    'updated_at' => $now,
                ];

                $db->table('aset_tanah')->insert($asetPayload);
                $idAset = (int) $db->insertID();

                $status = $statusRows[array_rand($statusRows)];
                $statusId = (int) $status['id_status'];
                $statusName = (string) ($status['nama_status'] ?? '');

                $tglMulai = $tanggalPerolehan->add(new \DateInterval('P' . random_int(0, 180) . 'D'));
                if ($tglMulai > $today) {
                    $tglMulai = $today;
                }

                $tglSelesai = null;
                $durasiHari = null;
                if (in_array($statusName, ['Sertifikat Terbit', 'Selesai'], true)) {
                    $endDate = $tglMulai->add(new \DateInterval('P' . random_int(7, 240) . 'D'));
                    if ($endDate > $today) {
                        $endDate = $today;
                    }
                    $tglSelesai = $endDate->format('Y-m-d');
                    $durasiHari = (int) $tglMulai->diff($endDate)->format('%a');
                }

                $db->table('proses_aset')->insert([
                    'id_aset' => $idAset,
                    'id_status' => $statusId,
                    'tgl_mulai' => $tglMulai->format('Y-m-d'),
                    'tgl_selesai' => $tglSelesai,
                    'keterangan' => $keteranganByStatus[$statusName] ?? null,
                    'durasi_hari' => $durasiHari,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);

                $inserted++;
            }

            if ($db->transStatus() === false) {
                throw new \RuntimeException('Transaksi insert dummy gagal.');
            }

            $db->transCommit();
            CLI::write('Seeder selesai: ' . $inserted . ' aset + proses acak berhasil ditambahkan.', 'green');
        } catch (\Throwable $e) {
            if ($db->transStatus()) {
                $db->transRollback();
            }
            CLI::error('Seeder gagal: ' . $e->getMessage());
        }
    }
}
