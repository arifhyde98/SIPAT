<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h4 fw-semibold mb-1">Pengaturan Landing Page</h1>
        <small class="text-muted">Ubah logo, header, footer, dan konten utama landing.</small>
    </div>
</div>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<div class="card">
    <div class="card-body">
        <form method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>

            <?php
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
                $getValue = static function (array $settings, array $defaults, string $key): string {
                    $value = trim((string) ($settings[$key] ?? ''));
                    if ($value !== '') {
                        return $value;
                    }
                    return (string) ($defaults[$key] ?? '');
                };
            ?>

            <style>
                :root {
                    --gov-primary: #0c3658;
                    --gov-accent: #eab308;
                }
                .card {
                    border: none;
                    box-shadow: 0 10px 30px rgba(0,0,0,0.05);
                    border-radius: 16px;
                    overflow: hidden;
                    transition: all 0.3s ease;
                    border-top: 4px solid var(--gov-primary);
                }
                .card:hover {
                    box-shadow: 0 20px 40px rgba(0,0,0,0.08);
                }
                .form-label {
                    font-weight: 600;
                    color: #475569;
                    font-size: 0.875rem;
                    margin-bottom: 0.5rem;
                    transition: color 0.2s;
                }
                .form-control {
                    border-radius: 10px;
                    border: 1px solid #e2e8f0;
                    padding: 0.75rem 1rem;
                    background-color: #f8fafc;
                    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                }
                .form-control:focus {
                    border-color: var(--gov-accent);
                    box-shadow: 0 0 0 4px rgba(234, 179, 8, 0.15);
                    background-color: #fff;
                    transform: translateY(-2px);
                }
                .form-control:hover {
                    background-color: #fff;
                    border-color: #cbd5e1;
                }
                h6.text-uppercase {
                    color: var(--gov-primary) !important;
                    font-weight: 800;
                    letter-spacing: 0.05em;
                    position: relative;
                    padding-left: 1rem;
                    margin-top: 1rem;
                    border-left: 4px solid var(--gov-accent);
                    background: linear-gradient(90deg, rgba(234, 179, 8, 0.1) 0%, transparent 100%);
                    padding-top: 0.5rem;
                    padding-bottom: 0.5rem;
                    border-radius: 0 8px 8px 0;
                }
                .btn-primary {
                    background: var(--gov-primary);
                    border: none;
                    padding: 12px 30px;
                    border-radius: 8px;
                    font-weight: 600;
                    box-shadow: 0 4px 12px rgba(12, 54, 88, 0.2);
                    transition: all 0.3s ease;
                }
                .btn-primary:hover {
                    background: #164e7c;
                    transform: translateY(-2px);
                    box-shadow: 0 8px 20px rgba(12, 54, 88, 0.3);
                }
                .preview-thumb {
                    width: 100%;
                    max-width: 240px;
                    height: 140px;
                    border-radius: 12px;
                    object-fit: cover;
                    border: 2px solid #fff;
                    box-shadow: 0 8px 18px rgba(15, 23, 42, 0.08);
                    transition: transform 0.3s ease;
                    cursor: pointer;
                }
                .preview-thumb:hover {
                    transform: scale(1.05) rotate(1deg);
                    box-shadow: 0 12px 24px rgba(15, 23, 42, 0.12);
                }
                .preview-logo {
                    width: 80px;
                    height: 80px;
                    border-radius: 50%;
                    object-fit: contain;
                    padding: 8px;
                    border: 2px solid #fff;
                    box-shadow: 0 6px 14px rgba(15, 23, 42, 0.08);
                    background: #fff;
                    transition: transform 0.3s ease;
                }
                .preview-logo:hover {
                    transform: rotate(10deg) scale(1.1);
                }
            </style>

            <div class="row g-3">
                <div class="col-12">
                    <h6 class="text-uppercase text-muted mb-2">Meta & Branding</h6>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Judul Situs (Title)</label>
                    <input type="text" name="landing_site_title" class="form-control" value="<?= esc($getValue($settings ?? [], $defaults, 'landing_site_title')) ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Nama Brand</label>
                    <input type="text" name="landing_brand_title" class="form-control" value="<?= esc($getValue($settings ?? [], $defaults, 'landing_brand_title')) ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Sub Brand</label>
                    <input type="text" name="landing_brand_subtitle" class="form-control" value="<?= esc($getValue($settings ?? [], $defaults, 'landing_brand_subtitle')) ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Label Tombol Login</label>
                    <input type="text" name="landing_nav_login_label" class="form-control" value="<?= esc($getValue($settings ?? [], $defaults, 'landing_nav_login_label')) ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Label Tombol Dashboard</label>
                    <input type="text" name="landing_nav_dashboard_label" class="form-control" value="<?= esc($getValue($settings ?? [], $defaults, 'landing_nav_dashboard_label')) ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Teks Badge Hero</label>
                    <input type="text" name="landing_badge_text" class="form-control" value="<?= esc($getValue($settings ?? [], $defaults, 'landing_badge_text')) ?>">
                </div>

                <div class="col-12 mt-3">
                    <h6 class="text-uppercase text-muted mb-2">Hero</h6>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Judul Hero</label>
                    <textarea name="landing_hero_title" class="form-control" rows="2"><?= esc($getValue($settings ?? [], $defaults, 'landing_hero_title')) ?></textarea>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Subjudul Hero</label>
                    <textarea name="landing_hero_subtitle" class="form-control" rows="2"><?= esc($getValue($settings ?? [], $defaults, 'landing_hero_subtitle')) ?></textarea>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Teks CTA Kecil</label>
                    <input type="text" name="landing_cta_text" class="form-control" value="<?= esc($getValue($settings ?? [], $defaults, 'landing_cta_text')) ?>">
                </div>

                <div class="col-12 mt-3">
                    <h6 class="text-uppercase text-muted mb-2">Section Manfaat</h6>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Judul Section Manfaat</label>
                    <input type="text" name="landing_section_features_title" class="form-control" value="<?= esc($getValue($settings ?? [], $defaults, 'landing_section_features_title')) ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Deskripsi Section Manfaat</label>
                    <textarea name="landing_section_features_desc" class="form-control" rows="2"><?= esc($getValue($settings ?? [], $defaults, 'landing_section_features_desc')) ?></textarea>
                </div>

                <div class="col-12 mt-2">
                    <div class="text-muted small">Kartu Manfaat 1</div>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Badge</label>
                    <input type="text" name="landing_feature_1_badge" class="form-control" value="<?= esc($getValue($settings ?? [], $defaults, 'landing_feature_1_badge')) ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Judul</label>
                    <input type="text" name="landing_feature_1_title" class="form-control" value="<?= esc($getValue($settings ?? [], $defaults, 'landing_feature_1_title')) ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Deskripsi</label>
                    <input type="text" name="landing_feature_1_desc" class="form-control" value="<?= esc($getValue($settings ?? [], $defaults, 'landing_feature_1_desc')) ?>">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Icon (class)</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light text-primary"><i class="<?= esc($getValue($settings ?? [], $defaults, 'landing_feature_1_icon')) ?> fs-5"></i></span>
                        <input type="text" name="landing_feature_1_icon" class="form-control icon-input" value="<?= esc($getValue($settings ?? [], $defaults, 'landing_feature_1_icon')) ?>">
                    </div>
                </div>

                <div class="col-12">
                    <div class="text-muted small">Kartu Manfaat 2</div>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Badge</label>
                    <input type="text" name="landing_feature_2_badge" class="form-control" value="<?= esc($getValue($settings ?? [], $defaults, 'landing_feature_2_badge')) ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Judul</label>
                    <input type="text" name="landing_feature_2_title" class="form-control" value="<?= esc($getValue($settings ?? [], $defaults, 'landing_feature_2_title')) ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Deskripsi</label>
                    <input type="text" name="landing_feature_2_desc" class="form-control" value="<?= esc($getValue($settings ?? [], $defaults, 'landing_feature_2_desc')) ?>">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Icon (class)</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light text-primary"><i class="<?= esc($getValue($settings ?? [], $defaults, 'landing_feature_2_icon')) ?> fs-5"></i></span>
                        <input type="text" name="landing_feature_2_icon" class="form-control icon-input" value="<?= esc($getValue($settings ?? [], $defaults, 'landing_feature_2_icon')) ?>">
                    </div>
                </div>

                <div class="col-12">
                    <div class="text-muted small">Kartu Manfaat 3</div>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Badge</label>
                    <input type="text" name="landing_feature_3_badge" class="form-control" value="<?= esc($getValue($settings ?? [], $defaults, 'landing_feature_3_badge')) ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Judul</label>
                    <input type="text" name="landing_feature_3_title" class="form-control" value="<?= esc($getValue($settings ?? [], $defaults, 'landing_feature_3_title')) ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Deskripsi</label>
                    <input type="text" name="landing_feature_3_desc" class="form-control" value="<?= esc($getValue($settings ?? [], $defaults, 'landing_feature_3_desc')) ?>">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Icon (class)</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light text-primary"><i class="<?= esc($getValue($settings ?? [], $defaults, 'landing_feature_3_icon')) ?> fs-5"></i></span>
                        <input type="text" name="landing_feature_3_icon" class="form-control icon-input" value="<?= esc($getValue($settings ?? [], $defaults, 'landing_feature_3_icon')) ?>">
                    </div>
                </div>

                <div class="col-12">
                    <div class="text-muted small">Kartu Manfaat 4</div>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Badge</label>
                    <input type="text" name="landing_feature_4_badge" class="form-control" value="<?= esc($getValue($settings ?? [], $defaults, 'landing_feature_4_badge')) ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Judul</label>
                    <input type="text" name="landing_feature_4_title" class="form-control" value="<?= esc($getValue($settings ?? [], $defaults, 'landing_feature_4_title')) ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Deskripsi</label>
                    <input type="text" name="landing_feature_4_desc" class="form-control" value="<?= esc($getValue($settings ?? [], $defaults, 'landing_feature_4_desc')) ?>">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Icon (class)</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light text-primary"><i class="<?= esc($getValue($settings ?? [], $defaults, 'landing_feature_4_icon')) ?> fs-5"></i></span>
                        <input type="text" name="landing_feature_4_icon" class="form-control icon-input" value="<?= esc($getValue($settings ?? [], $defaults, 'landing_feature_4_icon')) ?>">
                    </div>
                </div>

                <div class="col-12 mt-3">
                    <h6 class="text-uppercase text-muted mb-2">Section Rekap</h6>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Judul Section Rekap</label>
                    <input type="text" name="landing_section_stats_title" class="form-control" value="<?= esc($getValue($settings ?? [], $defaults, 'landing_section_stats_title')) ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Deskripsi Section Rekap</label>
                    <textarea name="landing_section_stats_desc" class="form-control" rows="2"><?= esc($getValue($settings ?? [], $defaults, 'landing_section_stats_desc')) ?></textarea>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Label Status Proses</label>
                    <input type="text" name="landing_stats_status_title" class="form-control" value="<?= esc($getValue($settings ?? [], $defaults, 'landing_stats_status_title')) ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Label OPD Terbanyak</label>
                    <input type="text" name="landing_stats_opd_title" class="form-control" value="<?= esc($getValue($settings ?? [], $defaults, 'landing_stats_opd_title')) ?>">
                </div>

                <div class="col-12 mt-3">
                    <h6 class="text-uppercase text-muted mb-2">Section Alur Kerja</h6>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Judul Section Alur</label>
                    <input type="text" name="landing_section_flow_title" class="form-control" value="<?= esc($getValue($settings ?? [], $defaults, 'landing_section_flow_title')) ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Deskripsi Section Alur</label>
                    <textarea name="landing_section_flow_desc" class="form-control" rows="2"><?= esc($getValue($settings ?? [], $defaults, 'landing_section_flow_desc')) ?></textarea>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Step 1</label>
                    <input type="text" name="landing_flow_step_1" class="form-control" value="<?= esc($getValue($settings ?? [], $defaults, 'landing_flow_step_1')) ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Step 2</label>
                    <input type="text" name="landing_flow_step_2" class="form-control" value="<?= esc($getValue($settings ?? [], $defaults, 'landing_flow_step_2')) ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Step 3</label>
                    <input type="text" name="landing_flow_step_3" class="form-control" value="<?= esc($getValue($settings ?? [], $defaults, 'landing_flow_step_3')) ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Step 4</label>
                    <input type="text" name="landing_flow_step_4" class="form-control" value="<?= esc($getValue($settings ?? [], $defaults, 'landing_flow_step_4')) ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Step 5</label>
                    <input type="text" name="landing_flow_step_5" class="form-control" value="<?= esc($getValue($settings ?? [], $defaults, 'landing_flow_step_5')) ?>">
                </div>

                <div class="col-12 mt-3">
                    <h6 class="text-uppercase text-muted mb-2">CTA Band</h6>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Judul CTA</label>
                    <input type="text" name="landing_cta_title" class="form-control" value="<?= esc($getValue($settings ?? [], $defaults, 'landing_cta_title')) ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Deskripsi CTA</label>
                    <input type="text" name="landing_cta_desc" class="form-control" value="<?= esc($getValue($settings ?? [], $defaults, 'landing_cta_desc')) ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Label Tombol CTA</label>
                    <input type="text" name="landing_cta_button_label" class="form-control" value="<?= esc($getValue($settings ?? [], $defaults, 'landing_cta_button_label')) ?>">
                </div>

                <div class="col-12 mt-3">
                    <h6 class="text-uppercase text-muted mb-2">Section Galeri</h6>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Judul Section Galeri</label>
                    <input type="text" name="landing_section_gallery_title" class="form-control" value="<?= esc($getValue($settings ?? [], $defaults, 'landing_section_gallery_title')) ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Deskripsi Section Galeri</label>
                    <input type="text" name="landing_section_gallery_desc" class="form-control" value="<?= esc($getValue($settings ?? [], $defaults, 'landing_section_gallery_desc')) ?>">
                </div>

                <div class="col-12 mt-3">
                    <h6 class="text-uppercase text-muted mb-2">Footer</h6>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Teks Footer</label>
                    <input type="text" name="landing_footer_text" class="form-control" value="<?= esc($getValue($settings ?? [], $defaults, 'landing_footer_text')) ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Copyright</label>
                    <input type="text" name="landing_footer_copyright" class="form-control" value="<?= esc($getValue($settings ?? [], $defaults, 'landing_footer_copyright')) ?>">
                </div>
            </div>

            <hr class="my-4">

            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Logo Header</label>
                    <input type="file" name="landing_logo_header" class="form-control">
                    <?php if (!empty($settings['landing_logo_header'])) : ?>
                        <img src="<?= base_url('landing/media/' . $settings['landing_logo_header']) ?>" alt="Logo Header" class="mt-2 preview-logo">
                    <?php endif; ?>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Logo Footer</label>
                    <input type="file" name="landing_logo_footer" class="form-control">
                    <?php if (!empty($settings['landing_logo_footer'])) : ?>
                        <img src="<?= base_url('landing/media/' . $settings['landing_logo_footer']) ?>" alt="Logo Footer" class="mt-2 preview-logo">
                    <?php endif; ?>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Gambar Hero</label>
                    <input type="file" name="landing_hero_image" class="form-control">
                    <?php if (!empty($settings['landing_hero_image'])) : ?>
                        <img src="<?= base_url('landing/media/' . $settings['landing_hero_image']) ?>" alt="Hero Image" class="mt-2 preview-thumb">
                    <?php endif; ?>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Galeri 1</label>
                    <input type="file" name="landing_gallery_1" class="form-control">
                    <?php if (!empty($settings['landing_gallery_1'])) : ?>
                        <img src="<?= base_url('landing/media/' . $settings['landing_gallery_1']) ?>" alt="Galeri 1" class="mt-2 preview-thumb">
                    <?php endif; ?>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Galeri 2</label>
                    <input type="file" name="landing_gallery_2" class="form-control">
                    <?php if (!empty($settings['landing_gallery_2'])) : ?>
                        <img src="<?= base_url('landing/media/' . $settings['landing_gallery_2']) ?>" alt="Galeri 2" class="mt-2 preview-thumb">
                    <?php endif; ?>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Galeri 3</label>
                    <input type="file" name="landing_gallery_3" class="form-control">
                    <?php if (!empty($settings['landing_gallery_3'])) : ?>
                        <img src="<?= base_url('landing/media/' . $settings['landing_gallery_3']) ?>" alt="Galeri 3" class="mt-2 preview-thumb">
                    <?php endif; ?>
                </div>
            </div>

            <div class="mt-4">
                <button class="btn btn-primary">Simpan Perubahan</button>
                <button class="btn btn-outline-secondary" name="apply_defaults" value="1">Isi Default</button>
            </div>
        </form>
    </div>
</div>

<script>
    document.querySelectorAll('.icon-input').forEach(input => {
        input.addEventListener('input', function() {
            const icon = this.previousElementSibling.querySelector('i');
            if(icon) icon.className = this.value + ' fs-5';
        });
    });
</script>
<?= $this->endSection() ?>
