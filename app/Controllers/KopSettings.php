<?php

namespace App\Controllers;

use App\Models\SettingModel;

class KopSettings extends BaseController
{
    private const TEXT_FIELDS = [
        'kop_nama_instansi',
        'kop_nama_unit',
        'kop_subunit',
        'kop_alamat',
        'kop_kontak',
        'kop_nama_laporan_aset',
        'kop_footer',
        'kop_kota_ttd',
        'kop_pejabat_jabatan',
        'kop_pejabat_nama',
        'kop_pejabat_nip',
    ];

    private const DEFAULTS = [
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

    public function index()
    {
        return view('kop_settings/index', [
            'settings' => $this->getSettingsMap(),
            'defaults' => self::DEFAULTS,
        ]);
    }

    public function update()
    {
        $model = new SettingModel();

        foreach (self::TEXT_FIELDS as $field) {
            $value = trim((string) $this->request->getPost($field));
            $this->saveSetting($model, $field, $value);
        }

        $file = $this->request->getFile('kop_logo');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $ext = strtolower((string) $file->getExtension());
            if (!in_array($ext, ['jpg', 'jpeg', 'png', 'webp'], true)) {
                return redirect()->back()->with('errors', ['Logo KOP harus berupa gambar jpg, jpeg, png, atau webp.']);
            }

            $targetDir = WRITEPATH . 'uploads/kop';
            if (!is_dir($targetDir)) {
                mkdir($targetDir, 0775, true);
            }

            $old = $model->where('key', 'kop_logo')->first();
            $newName = 'kop_logo_' . time() . '.' . $file->getExtension();
            $file->move($targetDir, $newName);

            if (!empty($old['value'])) {
                $oldPath = $targetDir . DIRECTORY_SEPARATOR . basename((string) $old['value']);
                if (is_file($oldPath)) {
                    @unlink($oldPath);
                }
            }

            $this->saveSetting($model, 'kop_logo', $newName);
        }

        return redirect()->back()->with('success', 'Master KOP berhasil disimpan.');
    }

    public function media(string $filename)
    {
        $safeName = basename($filename);
        $path = WRITEPATH . 'uploads/kop/' . $safeName;
        if (!is_file($path)) {
            return $this->response->setStatusCode(404);
        }

        $mime = mime_content_type($path) ?: 'application/octet-stream';

        return $this->response
            ->setHeader('Content-Type', $mime)
            ->setBody((string) file_get_contents($path));
    }

    private function getSettingsMap(): array
    {
        $model = new SettingModel();
        $rows = $model->whereIn('key', array_keys(self::DEFAULTS))->findAll();
        $map = self::DEFAULTS;

        foreach ($rows as $row) {
            $value = trim((string) ($row['value'] ?? ''));
            if ($value !== '') {
                $map[$row['key']] = $value;
            }
        }

        return $map;
    }

    private function saveSetting(SettingModel $model, string $key, string $value): void
    {
        $existing = $model->where('key', $key)->first();
        if ($existing) {
            $model->update($existing['id'], ['value' => $value]);
            return;
        }

        $model->insert(['key' => $key, 'value' => $value]);
    }
}
