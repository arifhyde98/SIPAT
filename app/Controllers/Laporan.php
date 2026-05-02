<?php

namespace App\Controllers;

use App\Models\AsetModel;
use App\Models\OpdModel;
use App\Models\ReportTitleModel;
use App\Models\SettingModel;
use App\Models\StatusProsesModel;

class Laporan extends BaseController
{
    public function index()
    {
        $asetModel = new AsetModel();
        $statusModel = new StatusProsesModel();
        $reportTitleModel = new ReportTitleModel();
        $filters = $this->getAsetFilters();

        $opdList = $this->getOpdList();

        $rows = $this->buildExportQuery($filters)->get()->getResultArray();
        $summary = $this->buildReportContext($rows, $filters);
        $queryString = http_build_query($this->buildFilterQueryParams($filters));

        return view('laporan/index', [
            'title' => 'Laporan',
            'filters' => $filters,
            'opdList' => $opdList,
            'statusList' => $statusModel->orderBy('urutan', 'ASC')->findAll(),
            'reportTitleList' => $reportTitleModel->where('aktif', 1)->orderBy('judul', 'ASC')->findAll(),
            'exportQueryString' => $queryString ? '?' . $queryString : '',
            'summary' => $summary['summary'],
            'activeFilters' => $summary['activeFilters'],
            'reportTitle' => $summary['reportTitle'],
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

    public function exportXlsx()
    {
        if (!class_exists(\PhpOffice\PhpSpreadsheet\Spreadsheet::class)) {
            return redirect()->to('/laporan')->with('errors', ['Export Excel belum tersedia karena library PhpSpreadsheet belum terpasang.']);
        }

        $filters = $this->getAsetFilters();
        $rows = $this->buildExportQuery($filters)->get()->getResultArray();
        $report = $this->buildReportContext($rows, $filters);

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Laporan Aset');
        $summarySheet = $spreadsheet->createSheet();
        $summarySheet->setTitle('Ringkasan');

        $startColumn = 'A';
        $endColumn = 'J';
        $titleStartColumn = 'B';
        $sheet->mergeCells($titleStartColumn . '1:' . $endColumn . '1');
        $sheet->mergeCells($titleStartColumn . '2:' . $endColumn . '2');
        $sheet->mergeCells($titleStartColumn . '3:' . $endColumn . '3');
        $sheet->mergeCells($titleStartColumn . '4:' . $endColumn . '4');
        $sheet->mergeCells($startColumn . '5:' . $endColumn . '5');
        $sheet->mergeCells($startColumn . '6:' . $endColumn . '6');

        $sheet->setCellValue($titleStartColumn . '1', (string) ($report['kop']['kop_nama_instansi'] ?? ''));
        $sheet->setCellValue($titleStartColumn . '2', (string) ($report['kop']['kop_nama_unit'] ?? ''));
        $sheet->setCellValue($titleStartColumn . '3', (string) ($report['kop']['kop_subunit'] ?? ''));
        $sheet->setCellValue($titleStartColumn . '4', (string) ($report['reportTitle'] ?? 'Laporan Aset Tanah'));
        $sheet->setCellValue('A5', trim((string) (($report['kop']['kop_alamat'] ?? '') . ' | ' . ($report['kop']['kop_kontak'] ?? '')), ' |'));
        $sheet->setCellValue('A6', 'Dicetak pada: ' . ($report['generatedAt'] ?? '-'));

        $logoPath = $this->getKopLogoPath((string) ($report['kop']['kop_logo'] ?? ''));
        if ($logoPath && class_exists(\PhpOffice\PhpSpreadsheet\Worksheet\Drawing::class)) {
            $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
            $drawing->setName('Logo KOP');
            $drawing->setDescription('Logo KOP');
            $drawing->setPath($logoPath, true);
            $drawing->setCoordinates('A1');
            $drawing->setHeight(78);
            $drawing->setWorksheet($sheet);
        }

        $filterText = 'Filter aktif: ';
        if (!empty($report['activeFilters'])) {
            $filterText .= implode(' | ', array_map(
                static fn (array $item): string => ($item['label'] ?? '') . ': ' . ($item['value'] ?? ''),
                $report['activeFilters']
            ));
        } else {
            $filterText .= 'Semua data aset tanah';
        }
        $sheet->mergeCells('A8:J8');
        $sheet->setCellValue('A8', $filterText);

        $sheet->mergeCells('A10:B10');
        $sheet->mergeCells('D10:E10');
        $sheet->mergeCells('G10:H10');
        $sheet->setCellValue('A10', 'Total Data');
        $sheet->setCellValue('C10', (int) ($report['summary']['total_data'] ?? 0));
        $sheet->setCellValue('D10', 'Total Nilai');
        $sheet->setCellValue('F10', (float) $this->parseNumericValue($report['summary']['total_nilai'] ?? '0'));
        $sheet->setCellValue('G10', 'Sudah Berstatus');
        $sheet->setCellValue('I10', (int) ($report['summary']['total_berstatus'] ?? 0));

        $headers = ['No', 'Kode Aset', 'Nama Aset', 'Peruntukan', 'OPD', 'Luas (m2)', 'Nilai Perolehan', 'Tanggal Perolehan', 'Status', 'Durasi'];
        $headerRow = 12;
        foreach ($headers as $index => $header) {
            $column = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($index + 1);
            $sheet->setCellValue($column . $headerRow, $header);
        }

        $rowNumber = $headerRow + 1;
        foreach ($report['rows'] as $row) {
            $sheet->setCellValue('A' . $rowNumber, (int) ($row['no'] ?? 0));
            $sheet->setCellValue('B' . $rowNumber, (string) ($row['kode_aset'] ?? ''));
            $sheet->setCellValue('C' . $rowNumber, (string) ($row['nama_aset'] ?? ''));
            $sheet->setCellValue('D' . $rowNumber, (string) ($row['peruntukan'] ?? '-'));
            $sheet->setCellValue('E' . $rowNumber, (string) ($row['opd'] ?? '-'));
            $sheet->setCellValue('F' . $rowNumber, $this->parseNumericValue($row['luas_formatted'] ?? '0'));
            $sheet->setCellValue('G' . $rowNumber, $this->parseNumericValue($row['harga_perolehan_formatted'] ?? '0'));
            $sheet->setCellValue('H' . $rowNumber, (string) ($row['tanggal_perolehan_formatted'] ?? '-'));
            $sheet->setCellValue('I' . $rowNumber, (string) ($row['nama_status'] ?? 'Belum Diurus'));
            $sheet->setCellValue('J' . $rowNumber, (string) ($row['durasi_hari'] ?? '-'));
            $rowNumber++;
        }

        $lastDataRow = max($headerRow + 1, $rowNumber - 1);

        $sheet->getStyle('B1:J1')->applyFromArray([
            'font' => ['bold' => true, 'size' => 14],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
        ]);
        $sheet->getStyle('B2:J2')->applyFromArray([
            'font' => ['bold' => true, 'size' => 16, 'color' => ['rgb' => '0B4F84']],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
        ]);
        $sheet->getStyle('B3:J3')->applyFromArray([
            'font' => ['size' => 11],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
        ]);
        $sheet->getStyle('B4:J4')->applyFromArray([
            'font' => ['bold' => true, 'size' => 15],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
        ]);
        $sheet->getStyle('A5:J8')->applyFromArray([
            'font' => ['size' => 10, 'color' => ['rgb' => '334155']],
        ]);
        $sheet->getStyle('A10:I10')->applyFromArray([
            'font' => ['bold' => true],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'color' => ['rgb' => 'E8EEF5'],
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => '9FB3C8'],
                ],
            ],
        ]);
        $sheet->getStyle('A12:J12')->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'color' => ['rgb' => '163A63'],
            ],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
        ]);
        $sheet->getStyle('A12:J' . $lastDataRow)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => 'AAB7C4'],
                ],
            ],
        ]);
        for ($row = $headerRow + 1; $row <= $lastDataRow; $row++) {
            if (($row - ($headerRow + 1)) % 2 === 0) {
                $sheet->getStyle('A' . $row . ':J' . $row)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
                $sheet->getStyle('A' . $row . ':J' . $row)->getFill()->getStartColor()->setRGB('F8FAFC');
            }
        }

        $sheet->getStyle('F13:G' . $lastDataRow)->getNumberFormat()->setFormatCode('#,##0.00');
        $sheet->getStyle('F10')->getNumberFormat()->setFormatCode('#,##0.00');
        $sheet->getStyle('A13:A' . $lastDataRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('F13:G' . $lastDataRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle('H13:H' . $lastDataRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('J13:J' . $lastDataRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1:J' . $lastDataRow)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

        foreach (range('A', 'J') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        $sheet->getRowDimension(1)->setRowHeight(26);
        $sheet->getRowDimension(2)->setRowHeight(28);
        $sheet->getRowDimension(3)->setRowHeight(22);
        $sheet->getRowDimension(4)->setRowHeight(24);
        $sheet->freezePane('A13');

        $this->buildSummarySheet($summarySheet, $report);
        $spreadsheet->setActiveSheetIndex(0);

        $filename = 'Laporan_Aset_Tanah_' . date('Ymd_His') . '.xlsx';
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        ob_start();
        $writer->save('php://output');
        $content = ob_get_clean();

        return $this->response
            ->setHeader('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet')
            ->setHeader('Content-Disposition', 'attachment; filename="' . $filename . '"')
            ->setBody($content ?: '');
    }

    public function previewPdf()
    {
        return $this->renderReportPdf(false);
    }

    public function downloadPdf()
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
        $pdfTempDir = WRITEPATH . 'cache/mpdf';
        if (!is_dir($pdfTempDir)) {
            mkdir($pdfTempDir, 0775, true);
        }

        $mpdf = new \Mpdf\Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4-L',
            'tempDir' => $pdfTempDir,
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
            'title_mode' => trim((string) $this->request->getGet('title_mode')) ?: 'master',
            'report_title_id' => trim((string) $this->request->getGet('report_title_id')),
            'manual_title' => trim((string) $this->request->getGet('manual_title')),
        ];
    }

    private function buildFilterQueryParams(array $filters): array
    {
        return array_filter($filters, static fn ($value) => $value !== null && $value !== '');
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

        $selectedTitle = $this->resolveReportTitle($filters, $kop['kop_nama_laporan_aset']);
        if ($filters['title_mode'] === 'manual' && $filters['manual_title'] !== '') {
            $activeFilters[] = ['label' => 'Judul Manual', 'value' => $filters['manual_title']];
        } elseif ($filters['report_title_id'] !== '') {
            $titleRow = (new ReportTitleModel())->find((int) $filters['report_title_id']);
            if (!empty($titleRow['judul'])) {
                $activeFilters[] = ['label' => 'Judul Master', 'value' => $titleRow['judul']];
            }
        }

        return [
            'rows' => $formattedRows,
            'filters' => $filters,
            'activeFilters' => $activeFilters,
            'generatedAt' => $generatedAt,
            'reportTitle' => $selectedTitle,
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

    private function formatHargaPerolehan($value): string
    {
        if ($value === null || $value === '') {
            return '-';
        }

        return number_format((float) $value, 2, '.', ',');
    }

    private function resolveReportTitle(array $filters, string $defaultTitle): string
    {
        if (($filters['title_mode'] ?? 'master') === 'manual') {
            $manual = trim((string) ($filters['manual_title'] ?? ''));
            if ($manual !== '') {
                return $manual;
            }
        }

        $reportTitleId = (int) ($filters['report_title_id'] ?? 0);
        if ($reportTitleId > 0) {
            $row = (new ReportTitleModel())->find($reportTitleId);
            if (!empty($row['judul'])) {
                return trim((string) $row['judul']);
            }
        }

        return $defaultTitle;
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

    private function parseNumericValue(string $value): float
    {
        $normalized = str_replace(',', '', trim($value));
        if ($normalized === '' || $normalized === '-') {
            return 0.0;
        }

        return (float) $normalized;
    }

    private function getOpdList(): array
    {
        try {
            $opdModel = new OpdModel();
            $rows = $opdModel->where('aktif', 1)->orderBy('nama', 'ASC')->findAll();
            $names = array_values(array_filter(array_map(
                static fn ($item) => trim((string) ($item['nama'] ?? '')),
                $rows
            )));
            if ($names !== []) {
                return $names;
            }
        } catch (\Throwable $e) {
        }

        $asetModel = new AsetModel();
        $opdRows = $asetModel->select('opd')->distinct()->orderBy('opd', 'ASC')->findAll();

        return array_values(array_filter(array_map(
            static fn ($item) => trim((string) ($item['opd'] ?? '')),
            $opdRows
        )));
    }

    private function getKopLogoPath(string $filename): ?string
    {
        $safeName = basename($filename);
        if ($safeName === '') {
            return null;
        }

        $path = WRITEPATH . 'uploads/kop/' . $safeName;
        return is_file($path) ? $path : null;
    }

    private function buildSummarySheet($sheet, array $report): void
    {
        $sheet->mergeCells('A1:F1');
        $sheet->mergeCells('A2:F2');
        $sheet->mergeCells('A3:F3');
        $sheet->setCellValue('A1', (string) ($report['kop']['kop_nama_instansi'] ?? ''));
        $sheet->setCellValue('A2', (string) ($report['reportTitle'] ?? 'Laporan Aset Tanah'));
        $sheet->setCellValue('A3', 'Ringkasan Export');
        $sheet->setCellValue('A5', 'Dicetak pada');
        $sheet->setCellValue('B5', (string) ($report['generatedAt'] ?? '-'));
        $sheet->setCellValue('A7', 'Total Data');
        $sheet->setCellValue('B7', (int) ($report['summary']['total_data'] ?? 0));
        $sheet->setCellValue('A8', 'Total Nilai');
        $sheet->setCellValue('B8', (float) $this->parseNumericValue($report['summary']['total_nilai'] ?? '0'));
        $sheet->setCellValue('A9', 'Sudah Berstatus');
        $sheet->setCellValue('B9', (int) ($report['summary']['total_berstatus'] ?? 0));
        $sheet->setCellValue('A11', 'Filter Aktif');

        $row = 12;
        if (!empty($report['activeFilters'])) {
            foreach ($report['activeFilters'] as $filter) {
                $sheet->setCellValue('A' . $row, (string) ($filter['label'] ?? ''));
                $sheet->setCellValue('B' . $row, (string) ($filter['value'] ?? ''));
                $row++;
            }
        } else {
            $sheet->setCellValue('A' . $row, 'Semua data aset tanah');
        }

        $sheet->getStyle('A1:F3')->applyFromArray([
            'font' => ['bold' => true],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
        ]);
        $sheet->getStyle('A7:B9')->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => 'AAB7C4'],
                ],
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'color' => ['rgb' => 'F8FAFC'],
            ],
        ]);
        $sheet->getStyle('B8')->getNumberFormat()->setFormatCode('#,##0.00');
        foreach (range('A', 'F') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }
    }
}
