<?php

namespace App\Controllers;

use App\Models\SettingModel;

class LandingSettings extends BaseController
{
    public function index()
    {
        $model = new SettingModel();
        $rows = $model->findAll();
        $settings = [];
        foreach ($rows as $row) {
            $settings[$row['key']] = $row['value'];
        }

        return view('landing/settings', [
            'settings' => $settings,
        ]);
    }

    public function update()
    {
        $model = new SettingModel();
        $errors = [];
        $defaults = [
            'landing_site_title' => 'SIPAT - Sistem Informasi Pensertifikatan Tanah',
            'landing_brand_title' => 'SIPAT',
            'landing_brand_subtitle' => 'Pemda Donggala',
            'landing_nav_login_label' => 'Login Pegawai',
            'landing_nav_dashboard_label' => 'Dashboard',
            'landing_badge_text' => 'Sistem Informasi Pensertifikatan Tanah',
            'landing_hero_title' => 'Monitoring aset tanah Pemda secara real-time, rapi, dan akuntabel.',
            'landing_hero_subtitle' => 'SIPAT membantu pengelola aset memantau proses pensertifikatan dari awal hingga sertifikat terbit, lengkap dengan dokumen digital, durasi proses, dan dashboard pimpinan yang mudah dipahami.',
            'landing_cta_text' => 'Data real-time langsung dari database SIPAT',
            'landing_section_features_title' => 'Manfaat Utama',
            'landing_section_features_desc' => 'Dirancang khusus untuk mendukung akuntabilitas dan transparansi pengelolaan aset daerah.',
            'landing_feature_1_badge' => 'Monitoring',
            'landing_feature_1_title' => 'Progres Real-Time',
            'landing_feature_1_desc' => 'Lacak status aset dari pengukuran hingga sertifikat terbit.',
            'landing_feature_1_icon' => 'bi bi-display',
            'landing_feature_2_badge' => 'Dokumen',
            'landing_feature_2_title' => 'Arsip Digital',
            'landing_feature_2_desc' => 'Simpan berkas penting per tahap dengan rapi dan mudah dicari.',
            'landing_feature_2_icon' => 'bi bi-folder2-open',
            'landing_feature_3_badge' => 'Peringatan',
            'landing_feature_3_title' => 'Durasi & Kendala',
            'landing_feature_3_desc' => 'Tampilkan durasi proses dan identifikasi kendala lebih cepat.',
            'landing_feature_3_icon' => 'bi bi-stopwatch',
            'landing_feature_4_badge' => 'Pimpinan',
            'landing_feature_4_title' => 'Dashboard Strategis',
            'landing_feature_4_desc' => 'Rekap status dan progres per OPD untuk pimpinan.',
            'landing_feature_4_icon' => 'bi bi-person-workspace',
            'landing_section_stats_title' => 'Rekap Real-Time',
            'landing_section_stats_desc' => 'Statistik terkini pengelolaan aset tanah Pemerintah Kabupaten Donggala.',
            'landing_stats_status_title' => 'Status Proses',
            'landing_stats_opd_title' => 'OPD Terbanyak',
            'landing_section_flow_title' => 'Alur Kerja SIPAT',
            'landing_section_flow_desc' => 'Proses sistematis untuk memastikan setiap aset tanah terdata dan bersertifikat.',
            'landing_flow_step_1' => 'Input Aset',
            'landing_flow_step_2' => 'Update Status',
            'landing_flow_step_3' => 'Upload Dokumen',
            'landing_flow_step_4' => 'Monitoring',
            'landing_flow_step_5' => 'Laporan',
            'landing_cta_title' => 'Amankan Aset Daerah Sekarang',
            'landing_cta_desc' => 'Monitoring status tanah secara real-time untuk masa depan yang lebih baik.',
            'landing_cta_button_label' => 'Masuk SIPAT',
            'landing_section_gallery_title' => 'Dokumentasi Lapangan',
            'landing_section_gallery_desc' => 'Contoh visual proses lapangan dan arsip digital.',
            'landing_footer_text' => 'Monitoring Pensertifikatan Tanah',
            'landing_footer_copyright' => 'Pemerintah Kabupaten Donggala',
        ];
        $fields = [
            'landing_site_title',
            'landing_brand_title',
            'landing_brand_subtitle',
            'landing_nav_login_label',
            'landing_nav_dashboard_label',
            'landing_badge_text',
            'landing_hero_title',
            'landing_hero_subtitle',
            'landing_cta_text',
            'landing_section_features_title',
            'landing_section_features_desc',
            'landing_feature_1_badge',
            'landing_feature_1_title',
            'landing_feature_1_desc',
            'landing_feature_1_icon',
            'landing_feature_2_badge',
            'landing_feature_2_title',
            'landing_feature_2_desc',
            'landing_feature_2_icon',
            'landing_feature_3_badge',
            'landing_feature_3_title',
            'landing_feature_3_desc',
            'landing_feature_3_icon',
            'landing_feature_4_badge',
            'landing_feature_4_title',
            'landing_feature_4_desc',
            'landing_feature_4_icon',
            'landing_section_stats_title',
            'landing_section_stats_desc',
            'landing_stats_status_title',
            'landing_stats_opd_title',
            'landing_section_flow_title',
            'landing_section_flow_desc',
            'landing_flow_step_1',
            'landing_flow_step_2',
            'landing_flow_step_3',
            'landing_flow_step_4',
            'landing_flow_step_5',
            'landing_cta_title',
            'landing_cta_desc',
            'landing_cta_button_label',
            'landing_section_gallery_title',
            'landing_section_gallery_desc',
            'landing_footer_copyright',
            'landing_footer_text',
        ];

        $applyDefaults = (string) $this->request->getPost('apply_defaults') === '1';
        foreach ($fields as $key) {
            if ($applyDefaults) {
                $existing = $model->where('key', $key)->first();
                $value = trim((string) ($existing['value'] ?? ''));
                if ($value === '' && isset($defaults[$key])) {
                    $this->saveSetting($model, $key, $defaults[$key]);
                }
                continue;
            }
            $value = trim((string) $this->request->getPost($key));
            $this->saveSetting($model, $key, $value);
        }

        if ($applyDefaults) {
            return redirect()->back()->with('success', 'Default landing page berhasil diisi.');
        }

        $uploads = [
            'landing_logo_header',
            'landing_logo_footer',
            'landing_hero_image',
            'landing_gallery_1',
            'landing_gallery_2',
            'landing_gallery_3',
        ];

        foreach ($uploads as $key) {
            $file = $this->request->getFile($key);
            if ($file && $file->isValid() && !$file->hasMoved()) {
                $ext = strtolower((string) $file->getExtension());
                if (!in_array($ext, ['jpg', 'jpeg', 'png', 'webp'], true)) {
                    $errors[] = "File {$key} harus berupa gambar (jpg, jpeg, png, webp).";
                    continue;
                }
                $newName = $key . '_' . time() . '.' . $file->getExtension();
                $targetDir = WRITEPATH . 'uploads/landing';
                if (!is_dir($targetDir)) {
                    mkdir($targetDir, 0775, true);
                }
                $file->move($targetDir, $newName);

                $old = $model->where('key', $key)->first();
                if (!empty($old['value'])) {
                    $oldPath = $targetDir . DIRECTORY_SEPARATOR . $old['value'];
                    if (is_file($oldPath)) {
                        @unlink($oldPath);
                    }
                }

                $this->saveSetting($model, $key, $newName);
            }
        }

        if (!empty($errors)) {
            return redirect()->back()->with('errors', $errors);
        }

        return redirect()->back()->with('success', 'Pengaturan landing page berhasil disimpan.');
    }

    private function saveSetting(SettingModel $model, string $key, string $value): void
    {
        $existing = $model->where('key', $key)->first();
        if ($existing) {
            $model->update($existing['id'], ['value' => $value]);
        } else {
            $model->insert(['key' => $key, 'value' => $value]);
        }
    }
}
