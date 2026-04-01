<?php

namespace App\Controllers;

use App\Models\AsetModel;
use App\Models\DokumenAsetModel;
use App\Models\PengamananFisikModel;
use App\Models\ProsesAsetModel;
use App\Models\SettingModel;
use App\Models\StatusProsesModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Aset extends BaseController
{
    public function index()
    {
        $asetModel = new AsetModel();
        $statusModel = new StatusProsesModel();
        $db = \Config\Database::connect();
        $filters = $this->getAsetFilters();

        $asetQuery = $this->applyAsetFilters($asetModel, $filters);

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

        $queryParams = $this->buildFilterQueryParams($filters);
        $queryString = http_build_query($queryParams);
        $pager->setPath(base_url('aset') . ($queryString ? '?' . $queryString : ''));

        return view('aset/index', [
            'data'       => $results,
            'statusList' => $statusList,
            'opdList'    => $opdList,
            'pager'      => $pager,
            'perPage'    => $perPage,
            'filters'    => $filters,
            'exportQueryString' => $queryString ? '?' . $queryString : '',
        ]);
    }


    public function exportCsv()
    {
        $query = $this->buildExportQuery($this->getAsetFilters())->get();

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
                $this->formatHargaPerolehan($row['harga_perolehan'] ?? null),
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
        return $this->renderReportPdf(false);
    }

    public function downloadReportPdf()
    {
        return $this->renderReportPdf(true);
    }

    private function renderReportPdf(bool $download)
    {
        $filters = $this->getAsetFilters();
        $rows = $this->buildExportQuery($filters)->get()->getResultArray();
        $report = $this->buildReportContext($rows, $filters);

        if (!class_exists(\Mpdf\Mpdf::class)) {
            return view('aset/print', $report);
        }

        $html = view('aset/report_pdf', $report);
        $mpdf = new \Mpdf\Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4-L',
            'margin_top' => 10,
            'margin_bottom' => 26,
            'margin_left' => 10,
            'margin_right' => 10,
        ]);
        $mpdf->SetTitle($report['reportTitle']);
        $mpdf->SetHTMLFooter('<div style="font-size:9pt;color:#64748b;border-top:1px solid #dbe3ef;padding-top:6px;text-align:center;">Halaman {PAGENO} dari {nbpg} | ' . htmlspecialchars((string) ($report['kop']['kop_footer'] ?? ''), ENT_QUOTES, 'UTF-8') . '</div>');
        $mpdf->WriteHTML($html);

        $filename = 'Laporan_Aset_Tanah_' . date('Ymd_His') . '.pdf';
        $content = $mpdf->Output($filename, 'S');
        $disposition = $download ? 'attachment' : 'inline';

        return $this->response
            ->setHeader('Content-Type', 'application/pdf')
            ->setHeader('Content-Disposition', $disposition . '; filename="' . $filename . '"')
            ->setBody($content);
    }
    private function getAsetFilters(): array
    {
        return [
            'opd' => trim((string) $this->request->getGet('opd')),
            'status' => trim((string) $this->request->getGet('status')),
            'tanggal_perolehan' => trim((string) $this->request->getGet('tanggal_perolehan')),
            'q' => trim((string) $this->request->getGet('q')),
        ];
    }

    private function buildFilterQueryParams(array $filters): array
    {
        return array_filter($filters, static fn ($value) => $value !== null && $value !== '');
    }

    private function applyAsetFilters(AsetModel $asetQuery, array $filters): AsetModel
    {
        if ($filters['opd'] !== '') {
            $asetQuery = $asetQuery->where('opd', $filters['opd']);
        }
        if ($filters['tanggal_perolehan'] !== '') {
            $asetQuery = $asetQuery->where('tanggal_perolehan', $filters['tanggal_perolehan']);
        }
        if ($filters['q'] !== '') {
            $asetQuery = $asetQuery->groupStart()
                ->like('kode_aset', $filters['q'])
                ->orLike('nama_aset', $filters['q'])
                ->orLike('peruntukan', $filters['q'])
                ->orLike('opd', $filters['q'])
                ->groupEnd();
        }
        if ($filters['status'] !== '') {
            $asetQuery = $asetQuery->whereIn('id_aset', $this->getLatestStatusAssetIds($filters['status']));
        }

        return $asetQuery;
    }

    private function buildExportQuery(array $filters)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('aset_tanah a')
            ->select('a.kode_aset, a.nama_aset, a.peruntukan, a.opd, a.luas, a.harga_perolehan, a.tanggal_perolehan, sp.nama_status, p.durasi_hari')
            ->join(
                '(SELECT p1.id_aset, p1.id_status, p1.durasi_hari
                  FROM proses_aset p1
                  JOIN (
                      SELECT id_aset, MAX(id_proses) AS max_id
                      FROM proses_aset
                      GROUP BY id_aset
                  ) p2 ON p1.id_aset = p2.id_aset AND p1.id_proses = p2.max_id) p',
                'p.id_aset = a.id_aset',
                'left',
                false
            )
            ->join('status_proses sp', 'sp.id_status = p.id_status', 'left')
            ->orderBy('a.id_aset', 'DESC');

        if ($filters['opd'] !== '') {
            $builder->where('a.opd', $filters['opd']);
        }
        if ($filters['tanggal_perolehan'] !== '') {
            $builder->where('a.tanggal_perolehan', $filters['tanggal_perolehan']);
        }
        if ($filters['q'] !== '') {
            $builder->groupStart()
                ->like('a.kode_aset', $filters['q'])
                ->orLike('a.nama_aset', $filters['q'])
                ->orLike('a.peruntukan', $filters['q'])
                ->orLike('a.opd', $filters['q'])
                ->groupEnd();
        }
        if ($filters['status'] !== '') {
            $builder->whereIn('a.id_aset', $this->getLatestStatusAssetIds($filters['status']));
        }

        return $builder;
    }

    private function getLatestStatusAssetIds(string $statusId): array
    {
        $db = \Config\Database::connect();
        $statusRows = $db->query(
            "SELECT p1.id_aset
             FROM proses_aset p1
             JOIN (
                SELECT id_aset, MAX(id_proses) AS max_id
                FROM proses_aset
                GROUP BY id_aset
             ) p2 ON p1.id_aset = p2.id_aset AND p1.id_proses = p2.max_id
             WHERE p1.id_status = ?",
            [$statusId]
        )->getResultArray();

        $statusIds = array_values(array_filter(array_map(
            static fn ($row) => (int) ($row['id_aset'] ?? 0),
            $statusRows
        )));

        return $statusIds !== [] ? $statusIds : [0];
    }

    private function formatHargaPerolehan($value): string
    {
        if ($value === null || $value === '') {
            return '-';
        }

        return number_format((float) $value, 2, '.', ',');
    }

    private function buildReportContext(array $rows, array $filters): array
    {
        $statusModel = new StatusProsesModel();
        $statusName = '';
        if ($filters['status'] !== '') {
            $statusRow = $statusModel->find((int) $filters['status']);
            $statusName = trim((string) ($statusRow['nama_status'] ?? ''));
        }

        $kop = $this->getKopSettings();
        $generatedAt = date('d-m-Y H:i');
        $totalNilai = 0.0;
        $formattedRows = [];

        foreach ($rows as $index => $row) {
            $harga = $row['harga_perolehan'] ?? null;
            $luas = $row['luas'] ?? null;
            if ($harga !== null && $harga !== '') {
                $totalNilai += (float) $harga;
            }

            $formattedRows[] = $row + [
                'no' => $index + 1,
                'harga_perolehan_formatted' => $this->formatHargaPerolehan($harga),
                'luas_formatted' => $this->formatLuas($luas),
                'tanggal_perolehan_formatted' => $this->formatTanggalIndonesia($row['tanggal_perolehan'] ?? null),
            ];
        }

        $activeFilters = [];
        if ($filters['opd'] !== '') {
            $activeFilters[] = ['label' => 'OPD', 'value' => $filters['opd']];
        }
        if ($statusName !== '') {
            $activeFilters[] = ['label' => 'Status', 'value' => $statusName];
        }
        if ($filters['tanggal_perolehan'] !== '') {
            $activeFilters[] = ['label' => 'Tanggal Perolehan', 'value' => $this->formatTanggalIndonesia($filters['tanggal_perolehan'])];
        }
        if ($filters['q'] !== '') {
            $activeFilters[] = ['label' => 'Kata Kunci', 'value' => $filters['q']];
        }

        return [
            'rows' => $formattedRows,
            'filters' => $filters,
            'activeFilters' => $activeFilters,
            'generatedAt' => $generatedAt,
            'reportTitle' => $kop['kop_nama_laporan_aset'],
            'kop' => $kop,
            'summary' => [
                'total_data' => count($formattedRows),
                'total_nilai' => $this->formatHargaPerolehan($totalNilai),
                'total_berstatus' => count(array_filter($formattedRows, static fn ($row) => ($row['nama_status'] ?? '') !== '' && ($row['nama_status'] ?? '') !== 'Belum Diurus')),
            ],
        ];
    }

    private function getKopSettings(): array
    {
        $defaults = [
            'kop_nama_instansi' => 'PEMERINTAH KABUPATEN DONGGALA',
            'kop_nama_unit' => 'SISTEM INFORMASI PENSERTIFIKATAN TANAH',
            'kop_subunit' => 'Bidang Pengelolaan Aset Daerah',
            'kop_alamat' => 'Jl. Trans Sulawesi, Donggala, Sulawesi Tengah',
            'kop_kontak' => 'Telp. (0457) 000000 | Email: aset@donggalakab.go.id',
            'kop_logo' => '',
            'kop_nama_laporan_aset' => 'LAPORAN ASET TANAH',
            'kop_footer' => 'Dokumen ini dihasilkan otomatis oleh SIPAT.',
            'kop_kota_ttd' => 'Donggala',
            'kop_pejabat_jabatan' => 'Mengetahui, Kepala Bidang Pengelolaan Aset Daerah',
            'kop_pejabat_nama' => 'Nama Pejabat',
            'kop_pejabat_nip' => 'NIP. 000000000000000000',
        ];

        $model = new SettingModel();
        $rows = $model->whereIn('key', array_keys($defaults))->findAll();
        $map = $defaults;
        foreach ($rows as $row) {
            $value = trim((string) ($row['value'] ?? ''));
            if ($value !== '') {
                $map[$row['key']] = $value;
            }
        }

        $map['kop_logo_data_uri'] = $this->getKopLogoDataUri($map['kop_logo'] ?? '');

        return $map;
    }

    private function getKopLogoDataUri(string $filename): ?string
    {
        $safeName = basename($filename);
        if ($safeName === '') {
            return null;
        }

        $path = WRITEPATH . 'uploads/kop/' . $safeName;
        if (!is_file($path)) {
            return null;
        }

        $mime = mime_content_type($path) ?: 'image/png';

        return 'data:' . $mime . ';base64,' . base64_encode((string) file_get_contents($path));
    }

    private function formatTanggalIndonesia(?string $value): string
    {
        $value = trim((string) $value);
        if ($value === '') {
            return '-';
        }

        try {
            $date = new \DateTime($value);
        } catch (\Throwable $e) {
            return $value;
        }

        return $date->format('d-m-Y');
    }

    private function formatLuas($value): string
    {
        if ($value === null || $value === '') {
            return '-';
        }

        return number_format((float) $value, 2, '.', ',');
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

        return redirect()->to('/aset?imported=1')->with('success', "Import selesai. Berhasil: {$inserted}, Dilewati: {$skipped}.");
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

        return redirect()->to('/aset?created=1')->with('success', 'Aset berhasil dibuat.');
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

        return redirect()->to('/aset?updated=1')->with('success', 'Aset berhasil diperbarui.');
    }

    public function delete($id)
    {
        $asetModel = new AsetModel();
        $old = $asetModel->find($id) ?? [];
        $asetModel->delete($id);
        $this->logAudit('delete', 'aset_tanah', (int) $id, $old, []);

        return redirect()->to('/aset?deleted=1')->with('success', 'Aset berhasil dihapus.');
    }
}

