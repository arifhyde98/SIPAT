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
        $fields = [
            'landing_hero_title',
            'landing_hero_subtitle',
            'landing_cta_text',
            'landing_footer_text',
        ];

        foreach ($fields as $key) {
            $value = trim((string) $this->request->getPost($key));
            $this->saveSetting($model, $key, $value);
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
