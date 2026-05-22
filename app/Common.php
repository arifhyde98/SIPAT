<?php

/**
 * The goal of this file is to allow developers a location
 * where they can overwrite core procedural functions and
 * replace them with their own. This file is loaded during
 * the bootstrap process and is called during the framework's
 * execution.
 *
 * This can be looked at as a `master helper` file that is
 * loaded early on, and may also contain additional functions
 * that you'd like to use throughout your entire application
 *
 * @see: https://codeigniter.com/user_guide/extending/common.html
 */

if (! function_exists('get_landing_logo_url')) {
    /**
     * Get the landing header logo URL with fallback
     */
    function get_landing_logo_url(): string
    {
        $defaultLogo = 'https://upload.wikimedia.org/wikipedia/commons/thumb/e/e5/Lambang_Kabupaten_Donggala_%282015-sekarang%29.png/196px-Lambang_Kabupaten_Donggala_%282015-sekarang%29.png';
        try {
            $model = new \App\Models\SettingModel();
            $logoHeaderSetting = $model->where('key', 'landing_logo_header')->first();
            $logoHeader = $logoHeaderSetting['value'] ?? null;
            return $logoHeader ? base_url('landing/media/' . $logoHeader) : $defaultLogo;
        } catch (\Throwable $e) {
            return $defaultLogo;
        }
    }
}

