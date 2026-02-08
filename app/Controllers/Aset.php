<?php

namespace App\Controllers;

use App\Models\AsetModel;
use App\Models\DokumenAsetModel;
use App\Models\PengamananFisikModel;
use App\Models\ProsesAsetModel;
use App\Models\StatusProsesModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Aset extends BaseController
{
    public function index()
    {
        $asetModel = new AsetModel();
        $statusModel = new StatusProsesModel();
        $db = \Config\Database::connect();

        $filterOpd = $this->request->getGet('opd');
        $filterStatus = $this->request->getGet('status');
        $filterTahun = $this->request->getGet('tanggal_perolehan');
        $filterKeyword = trim((string) $this->request->getGet('q'));

        $asetQuery = $asetModel;
        if (!empty($filterOpd)) {
            $asetQuery = $asetQuery->where('opd', $filterOpd);
        }
        if (!empty($filterTahun)) {
            $asetQuery = $asetQuery->where('tanggal_perolehan', $filterTahun);
        }
        if ($filterKeyword !== '') {
            $asetQuery = $asetQuery->groupStart()
                ->like('kode_aset', $filterKeyword)
                ->orLike('nama_aset', $filterKeyword)
                ->orLike('peruntukan', $filterKeyword)
                ->orLike('opd', $filterKeyword)
                ->groupEnd();
        }

        if (!empty($filterStatus)) {
            $statusRows = $db->query(
                "SELECT p1.id_aset
                 FROM proses_aset p1
                 JOIN (
                    SELECT id_aset, MAX(id_proses) AS max_id
                    FROM proses_aset
                    GROUP BY id_aset
                 ) p2 ON p1.id_aset = p2.id_aset AND p1.id_proses = p2.max_id
                 WHERE p1.id_status = ?",
                [$filterStatus]
            )->getResultArray();

            $statusIds = array_values(array_filter(array_map(
                static fn ($row) => (int) ($row['id_aset'] ?? 0),
                $statusRows
            )));

            if (empty($statusIds)) {
                $statusIds = [0];
            }
            $asetQuery = $asetQuery->whereIn('id_aset', $statusIds);
        }

        $perPage = 25;
        $asetList = $asetQuery->orderBy('id_aset', 'DESC')->paginate($perPage, 'aset');
        $pager = $asetModel->pager;
        $statusList = $statusModel->orderBy('urutan', 'ASC')->findAll();

        $results = [];
        $statusMap = [];
        if (!empty($asetList)) {
            $ids = implode(',', array_map('intval', array_column($asetList, 'id_aset')));
            $sql = "SELECT p1.id_aset, p1.durasi_hari, s.nama_status, s.warna
                    FROM proses_aset p1
                    JOIN status_proses s ON s.id_status = p1.id_status
                    JOIN (
                        SELECT id_aset, MAX(id_proses) AS max_id
                        FROM proses_aset
                        WHERE id_aset IN ($ids)
                        GROUP BY id_aset
                    ) p2 ON p1.id_aset = p2.id_aset AND p1.id_proses = p2.max_id";
            foreach ($db->query($sql)->getResultArray() as $row) {
                $statusMap[(int) $row['id_aset']] = $row;
            }
        }
        foreach ($asetList as $aset) {
            $latest = $statusMap[(int) $aset['id_aset']] ?? null;

            $aset['status_terkini'] = $latest['nama_status'] ?? 'Belum Diurus';
            $aset['warna_status'] = $latest['warna'] ?? 'secondary';
            $aset['durasi_hari'] = $latest['durasi_hari'] ?? '-';
            $results[] = $aset;
        }

        $opdRows = $asetModel->select('opd')->distinct()->orderBy('opd', 'ASC')->findAll();
        $opdList = array_values(array_filter(array_map(
            static fn ($item) => $item['opd'] ?? null,
            $opdRows
        )));

        $queryParams = array_filter([
            'opd' => $filterOpd,
            'status' => $filterStatus,
            'tanggal_perolehan' => $filterTahun,
            'q' => $filterKeyword,
        ], static fn ($v) => $v !== null && $v !== '');
        $queryString = http_build_query($queryParams);
        $pager->setPath(base_url('aset') . ($queryString ? '?' . $queryString : ''));

        return view('aset/index', [
            'data'       => $results,
            'statusList' => $statusList,
            'opdList'    => $opdList,
            'pager'      => $pager,
            'perPage'    => $perPage,
            'filters'    => [
                'opd'    => $filterOpd,
                'status' => $filterStatus,
                'tanggal_perolehan'  => $filterTahun,
                'q'      => $filterKeyword,
            ],
        ]);
    }


    public function exportCsv()
    {
        $db = \Config\Database::connect();
        $query = $db->query(
            "SELECT a.kode_aset, a.nama_aset, a.peruntukan, a.opd, a.luas, a.harga_perolehan,
                    a.tanggal_perolehan, sp.nama_status, p.durasi_hari
             FROM aset_tanah a
             LEFT JOIN (
                 SELECT p1.id_aset, p1.id_status, p1.durasi_hari
                 FROM proses_aset p1
                 JOIN (
                     SELECT id_aset, MAX(id_proses) AS max_id
                     FROM proses_aset
                     GROUP BY id_aset
                 ) p2 ON p1.id_aset = p2.id_aset AND p1.id_proses = p2.max_id
             ) p ON p.id_aset = a.id_aset
             LEFT JOIN status_proses sp ON sp.id_status = p.id_status
             ORDER BY a.id_aset DESC"
        );

        $filename = 'aset_export_' . date('Ymd_His') . '.csv';
        $this->response->setHeader('Content-Type', 'text/csv');
        $this->response->setHeader('Content-Disposition', 'attachment; filename="' . $filename . '"');

        $out = fopen('php://temp', 'r+');
        fputcsv($out, [
            'kode_aset', 'nama_aset', 'peruntukan', 'opd', 'luas', 'harga_perolehan',
            'tanggal_perolehan', 'status_terkini', 'durasi_hari',
        ]);
        while ($row = $query->getUnbufferedRow('array')) {
            fputcsv($out, [
                $row['kode_aset'],
                $row['nama_aset'],
                $row['peruntukan'],
                $row['opd'],
                $row['luas'],
                $row['harga_perolehan'],
                $row['tanggal_perolehan'],
                $row['nama_status'] ?? 'Belum Diurus',
                $row['durasi_hari'] ?? '',
            ]);
        }
        rewind($out);
        $csv = stream_get_contents($out);
        fclose($out);

        return $this->response->setBody($csv);
    }

    public function printReport()
    {
        $db = \Config\Database::connect();
        $rows = $db->query(
            "SELECT a.kode_aset, a.nama_aset, a.opd, a.luas, a.harga_perolehan,
                    a.tanggal_perolehan, sp.nama_status, p.durasi_hari
             FROM aset_tanah a
             LEFT JOIN (
                 SELECT p1.id_aset, p1.id_status, p1.durasi_hari
                 FROM proses_aset p1
                 JOIN (
                     SELECT id_aset, MAX(id_proses) AS max_id
                     FROM proses_aset
                     GROUP BY id_aset
                 ) p2 ON p1.id_aset = p2.id_aset AND p1.id_proses = p2.max_id
             ) p ON p.id_aset = a.id_aset
             LEFT JOIN status_proses sp ON sp.id_status = p.id_status
             ORDER BY a.id_aset DESC"
        )->getResultArray();

        return view('aset/print', [
            'rows' => $rows,
        ]);
    }

    public function show($id)
    {
        $asetModel = new AsetModel();
        $prosesModel = new ProsesAsetModel();
        $statusModel = new StatusProsesModel();
        $dokumenModel = new DokumenAsetModel();
        $pengamananModel = new PengamananFisikModel();

        $aset = $asetModel->find($id);
        if (!$aset) {
            throw new PageNotFoundException('Aset tidak ditemukan');
        }

        $prosesList = $prosesModel
            ->select('proses_aset.*, status_proses.nama_status, status_proses.warna')
            ->join('status_proses', 'status_proses.id_status = proses_aset.id_status', 'left')
            ->where('proses_aset.id_aset', $id)
            ->orderBy('proses_aset.id_proses', 'ASC')
            ->findAll();

        $dokumenList = $dokumenModel
            ->where('id_aset', $id)
            ->orderBy('uploaded_at', 'DESC')
            ->findAll();

        $pengamanan = $pengamananModel->where('id_aset', $id)->first();
        $statusList = $statusModel->orderBy('urutan', 'ASC')->findAll();

        return view('aset/show', [
            'aset'        => $aset,
            'prosesList'  => $prosesList,
            'dokumenList' => $dokumenList,
            'pengamanan'  => $pengamanan,
            'statusList'  => $statusList,
        ]);
    }

    public function modal($id)
    {
        $asetModel = new AsetModel();
        $prosesModel = new ProsesAsetModel();
        $statusModel = new StatusProsesModel();
        $dokumenModel = new DokumenAsetModel();
        $pengamananModel = new PengamananFisikModel();

        $aset = $asetModel->find($id);
        if (!$aset) {
            throw new PageNotFoundException('Aset tidak ditemukan');
        }

        $prosesList = $prosesModel
            ->select('proses_aset.*, status_proses.nama_status, status_proses.warna')
            ->join('status_proses', 'status_proses.id_status = proses_aset.id_status', 'left')
            ->where('proses_aset.id_aset', $id)
            ->orderBy('proses_aset.id_proses', 'ASC')
            ->findAll();

        $dokumenList = $dokumenModel
            ->where('id_aset', $id)
            ->orderBy('uploaded_at', 'DESC')
            ->findAll();

        $pengamanan = $pengamananModel->where('id_aset', $id)->first();
        $statusList = $statusModel->orderBy('urutan', 'ASC')->findAll();

        return view('aset/modal', [
            'aset'        => $aset,
            'prosesList'  => $prosesList,
            'dokumenList' => $dokumenList,
            'pengamanan'  => $pengamanan,
            'statusList'  => $statusList,
        ]);
    }

    public function create()
    {
        return view('aset/create');
    }

    public function importForm()
    {
        return view('aset/import');
    }

    public function importProcess()
    {
        $rules = [
            'file' => 'uploaded[file]|ext_in[file,csv,xlsx]|max_size[file,10240]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $file = $this->request->getFile('file');
        if (!$file || !$file->isValid()) {
            return redirect()->back()->withInput()->with('errors', ['File tidak valid.']);
        }

        $targetDir = WRITEPATH . 'uploads/sipat_import';
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0775, true);
        }

        $newName = $file->getRandomName();
        $file->move($targetDir, $newName);
        $filePath = $targetDir . DIRECTORY_SEPARATOR . $newName;

        $extension = strtolower($file->getClientExtension());
        $rows = [];

        if ($extension === 'xlsx') {
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($filePath);
            $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, false);
            $rows = $sheetData;
        } else {
            $handle = fopen($filePath, 'r');
            if (!$handle) {
                return redirect()->back()->with('errors', ['Gagal membaca file.']);
            }
            while (($line = fgetcsv($handle)) !== false) {
                $rows[] = $line;
            }
            fclose($handle);
        }

        if (empty($rows)) {
            return redirect()->back()->with('errors', ['File kosong.']);
        }

        $header = array_shift($rows);
        if (!$header) {
            return redirect()->back()->with('errors', ['Header file tidak ditemukan.']);
        }

        $header = array_map(static fn ($h) => strtolower(trim((string) $h)), $header);
        $required = ['kode_aset', 'nama_aset'];
        foreach ($required as $req) {
            if (!in_array($req, $header, true)) {
                return redirect()->back()->with('errors', ["Kolom wajib tidak ada: {$req}."]);
            }
        }

        $db = \Config\Database::connect();
        $db->transBegin();

        try {
            $model = new AsetModel();
            $statusModel = new StatusProsesModel();
            $prosesModel = new ProsesAsetModel();
            $existing = $model->select('kode_aset')->findAll();
            $existingSet = [];
            foreach ($existing as $row) {
                $existingSet[$row['kode_aset']] = true;
            }

            $inserted = 0;
            $skipped = 0;
            $batch = [];
            $statusMap = [];
            foreach ($statusModel->select('id_status,nama_status')->findAll() as $st) {
                $statusMap[strtolower($st['nama_status'])] = (int) $st['id_status'];
            }

            foreach ($rows as $row) {
                if (count(array_filter($row, static fn ($v) => trim((string) $v) !== '')) === 0) {
                    continue;
                }

                $data = [];
                foreach ($header as $i => $col) {
                    $data[$col] = isset($row[$i]) ? trim((string) $row[$i]) : null;
                }

                $kode = $data['kode_aset'] ?? '';
                $nama = $data['nama_aset'] ?? '';
                if ($kode === '' || $nama === '') {
                    $skipped++;
                    continue;
                }

                if (isset($existingSet[$kode])) {
                    $skipped++;
                    continue;
                }

                $luas = $data['luas'] ?? null;
                $harga = $data['harga_perolehan'] ?? null;
                $luas = $luas !== null ? str_replace(',', '', $luas) : null;
                $harga = $harga !== null ? str_replace(',', '', $harga) : null;

                $tanggal = $data['tanggal_perolehan'] ?? null;
                if ($tanggal !== null && $tanggal !== '') {
                    if (is_numeric($tanggal)) {
                        try {
                            $dt = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject((float) $tanggal);
                            $tanggal = $dt->format('Y-m-d');
                        } catch (\Throwable $e) {
                            $tanggal = (string) $tanggal;
                        }
                    } elseif (strpos($tanggal, '/') !== false) {
                        $dt = \DateTime::createFromFormat('d/m/Y', $tanggal);
                        $tanggal = $dt ? $dt->format('Y-m-d') : $tanggal;
                    }
                }

                $rowData = [
                    'kode_aset'         => $kode,
                    'nama_aset'         => $nama,
                    'peruntukan'        => $data['peruntukan'] ?? null,
                    'luas'              => $luas ?: null,
                    'alamat'            => $data['alamat'] ?? null,
                    'lat'               => $data['lat'] ?? null,
                    'lng'               => $data['lng'] ?? null,
                    'opd'               => $data['opd'] ?? null,
                    'dasar_perolehan'   => $data['dasar_perolehan'] ?? null,
                    'harga_perolehan'   => $harga ?: null,
                    'tanggal_perolehan' => $tanggal ?: null,
                ];

                $statusName = $data['status_proses'] ?? null;
                $tglMulai = $data['tgl_mulai'] ?? null;
                $tglSelesai = $data['tgl_selesai'] ?? null;
                $keterangan = $data['keterangan'] ?? null;

                if (!empty($statusName)) {
                    $statusId = $statusMap[strtolower($statusName)] ?? null;
                    if ($statusId) {
                        $model->insert($rowData);
                        $idAset = $model->getInsertID();

                        $durasi = null;
                        if (!empty($tglMulai) && !empty($tglSelesai)) {
                            $durasi = (int) floor((strtotime($tglSelesai) - strtotime($tglMulai)) / 86400);
                            if ($durasi < 0) {
                                $durasi = null;
                            }
                        }

                        $prosesModel->insert([
                            'id_aset'     => $idAset,
                            'id_status'   => $statusId,
                            'tgl_mulai'   => $tglMulai ?: ($tanggal ?: null),
                            'tgl_selesai' => $tglSelesai ?: null,
                            'keterangan'  => $keterangan,
                            'durasi_hari' => $durasi,
                        ]);

                        $inserted++;
                    } else {
                        $skipped++;
                    }
                } else {
                    $batch[] = $rowData;
                }

                $existingSet[$kode] = true;

                if (count($batch) >= 200) {
                    $model->insertBatch($batch);
                    $inserted += count($batch);
                    $batch = [];
                }
            }

            if (!empty($batch)) {
                $model->insertBatch($batch);
                $inserted += count($batch);
            }

            if ($db->transStatus() === false) {
                throw new \RuntimeException('Transaksi import gagal.');
            }
            $db->transCommit();
        } catch (\Throwable $e) {
            if ($db->transStatus()) {
                $db->transRollback();
            }
            return redirect()->back()->with('errors', ['Import gagal: ' . $e->getMessage()]);
        }

        return redirect()->to('/aset')->with('success', "Import selesai. Berhasil: {$inserted}, Dilewati: {$skipped}.");
    }

    public function store()
    {
        $rules = [
            'kode_aset' => 'required',
            'nama_aset' => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $asetModel = new AsetModel();
        $payload = [
            'kode_aset'       => $this->request->getPost('kode_aset'),
            'nama_aset'       => $this->request->getPost('nama_aset'),
            'peruntukan'      => $this->request->getPost('peruntukan'),
            'luas'            => $this->request->getPost('luas'),
            'alamat'          => $this->request->getPost('alamat'),
            'lat'             => $this->request->getPost('lat'),
            'lng'             => $this->request->getPost('lng'),
            'opd'             => $this->request->getPost('opd'),
            'dasar_perolehan' => $this->request->getPost('dasar_perolehan'),
            'harga_perolehan' => $this->request->getPost('harga_perolehan'),
            'tanggal_perolehan' => $this->request->getPost('tanggal_perolehan'),
        ];
        $asetModel->insert($payload);
        $this->logAudit('create', 'aset_tanah', (int) $asetModel->getInsertID(), [], $payload);

        return redirect()->to('/aset')->with('success', 'Aset berhasil dibuat.');
    }

    public function edit($id)
    {
        $asetModel = new AsetModel();
        $aset = $asetModel->find($id);
        if (!$aset) {
            throw new PageNotFoundException('Aset tidak ditemukan');
        }

        return view('aset/edit', ['aset' => $aset]);
    }

    public function update($id)
    {
        $rules = [
            'kode_aset' => 'required',
            'nama_aset' => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $asetModel = new AsetModel();
        $old = $asetModel->find($id) ?? [];
        $payload = [
            'kode_aset'       => $this->request->getPost('kode_aset'),
            'nama_aset'       => $this->request->getPost('nama_aset'),
            'peruntukan'      => $this->request->getPost('peruntukan'),
            'luas'            => $this->request->getPost('luas'),
            'alamat'          => $this->request->getPost('alamat'),
            'lat'             => $this->request->getPost('lat'),
            'lng'             => $this->request->getPost('lng'),
            'opd'             => $this->request->getPost('opd'),
            'dasar_perolehan' => $this->request->getPost('dasar_perolehan'),
            'harga_perolehan' => $this->request->getPost('harga_perolehan'),
            'tanggal_perolehan' => $this->request->getPost('tanggal_perolehan'),
        ];
        $asetModel->update($id, $payload);
        $this->logAudit('update', 'aset_tanah', (int) $id, $old, $payload);

        return redirect()->to('/aset')->with('success', 'Aset berhasil diperbarui.');
    }

    public function delete($id)
    {
        $asetModel = new AsetModel();
        $old = $asetModel->find($id) ?? [];
        $asetModel->delete($id);
        $this->logAudit('delete', 'aset_tanah', (int) $id, $old, []);

        return redirect()->to('/aset')->with('success', 'Aset berhasil dihapus.');
    }
}
