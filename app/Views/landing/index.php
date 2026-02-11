<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SIPAT - Sistem Informasi Pensertifikatan Tanah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Source+Sans+3:wght@400;500;600;700&family=Source+Serif+4:wght@600;700&display=swap');
        :root {
            --gov-primary: #0c3658;
            --gov-primary-light: #164e7c;
            --gov-accent: #eab308;
            --gov-accent-dark: #ca8a04;
            --gov-success: #10b981;
            --gov-warning: #f59e0b;
            --gov-info: #3b82f6;
            --gov-danger: #ef4444;
            --gov-ink: #111827;
            --gov-muted: #6b7280;
            --gov-bg: #f8fafc;
            --gov-card: #ffffff;
        }
        body {
            font-family: "Source Sans 3", "Segoe UI", sans-serif;
            color: var(--gov-ink);
            background:
                radial-gradient(circle at 0% 0%, rgba(12, 54, 88, 0.05), transparent 40%),
                radial-gradient(circle at 100% 0%, rgba(234, 179, 8, 0.1), transparent 40%),
                var(--gov-bg);
        }
        h1, h2, h3, .display-5 {
            font-family: "Source Serif 4", "Georgia", serif;
            color: var(--gov-primary);
            font-weight: 700;
        }
        .text-secondary {
            color: var(--gov-muted) !important;
        }
        .gov-container {
            max-width: 1320px;
            padding-left: 24px;
            padding-right: 24px;
        }
        @media (min-width: 1600px) {
            .gov-container {
                max-width: 1440px;
            }
        }
        .nav-brand {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .nav-brand img {
            width: 56px;
            height: 56px;
            object-fit: contain;
            filter: drop-shadow(0 4px 6px rgba(0,0,0,0.1));
        }
        .nav-title {
            font-weight: 700;
            font-size: 20px;
            line-height: 1.2;
            color: var(--gov-primary);
        }
        .nav-subtitle {
            font-size: 13px;
            color: var(--gov-muted);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            font-weight: 600;
        }
        .btn-gov {
            background: var(--gov-primary);
            color: #fff;
            border-radius: 6px;
            padding: 10px 18px;
            font-weight: 600;
            border: 1px solid transparent;
            box-shadow: 0 4px 12px rgba(12, 54, 88, 0.2);
            transition: all 0.3s ease;
        }
        .btn-gov:hover {
            background: var(--gov-primary-light);
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(12, 54, 88, 0.3);
        }
        .btn-outline-gov {
            color: var(--gov-primary);
            border: 2px solid var(--gov-primary);
            border-radius: 6px;
            padding: 10px 18px;
            font-weight: 600;
            background: transparent;
        }
        .btn-outline-gov:hover {
            background: var(--gov-primary);
            color: #fff;
        }
        .btn-accent {
            background: var(--gov-accent);
            color: #fff;
            border-radius: 6px;
            padding: 10px 18px;
            font-weight: 600;
            border: 1px solid transparent;
            box-shadow: 0 4px 12px rgba(234, 179, 8, 0.3);
            transition: all 0.3s ease;
        }
        .btn-accent:hover {
            background: var(--gov-accent-dark);
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(234, 179, 8, 0.4);
        }
        .hero-card {
            background: var(--gov-card);
            border-radius: 12px;
            border: 0;
            border-top: 4px solid var(--gov-accent);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            padding: 24px;
        }
        .hero-image {
            width: 100%;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            object-fit: cover;
            height: 260px;
        }
        .badge-gov {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 12px;
            border-radius: 4px;
            background: rgba(12, 54, 88, 0.1);
            color: var(--gov-primary);
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        .stat-card {
            background: #f8fafc;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            padding: 16px;
            height: 100%;
            text-align: center;
        }
        .stat-value {
            font-size: 28px;
            font-weight: 700;
            color: var(--gov-primary);
            line-height: 1.2;
        }
        .stat-label {
            font-size: 13px;
            color: var(--gov-muted);
            font-weight: 600;
        }
        .section-title {
            font-size: 32px;
            margin-bottom: 12px;
            position: relative;
            display: inline-block;
        }
        .section-title::after {
            content: '';
            display: block;
            width: 60px;
            height: 4px;
            background: var(--gov-accent);
            margin: 8px auto 0;
            border-radius: 2px;
        }
        .section-desc {
            color: var(--gov-muted);
            margin-bottom: 40px;
            font-size: 1.1rem;
        }
        .card-elegant {
            background: var(--gov-card);
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.02);
            padding: 24px;
            height: 100%;
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }
        .card-elegant:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.06);
            border-color: var(--gov-accent);
        }
        .card-elegant .badge-gov,
        .card-elegant h5,
        .card-elegant p,
        .card-elegant .accent-line {
            position: relative;
            z-index: 2;
        }
        .card-icon-wrapper {
            position: absolute;
            top: -20px;
            right: -20px;
            font-size: 100px;
            color: var(--gov-primary);
            opacity: 0.06;
            transform: rotate(-15deg);
            transition: all 0.3s ease;
            z-index: 1;
        }
        .card-elegant:hover .card-icon-wrapper {
            opacity: 0.1;
            transform: rotate(-10deg) scale(1.1);
        }
        .accent-line {
            width: 36px;
            height: 4px;
            background: var(--gov-accent);
            border-radius: 999px;
            margin: 10px 0 12px;
        }
        .card-elegant--monitoring .accent-line { background: var(--gov-info); }
        .card-elegant--monitoring .card-icon-wrapper { color: var(--gov-info); }
        .card-elegant--dokumen .accent-line { background: var(--gov-success); }
        .card-elegant--dokumen .card-icon-wrapper { color: var(--gov-success); }
        .card-elegant--peringatan .accent-line { background: var(--gov-warning); }
        .card-elegant--peringatan .card-icon-wrapper { color: var(--gov-warning); }
        .card-elegant--pimpinan .accent-line { background: var(--gov-danger); }
        .card-elegant--pimpinan .card-icon-wrapper { color: var(--gov-danger); }
        .pill {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 32px;
            padding: 4px 10px;
            border-radius: 4px;
            background: #f1f5f9;
            color: var(--gov-ink);
            font-weight: 700;
            font-size: 12px;
        }
        .list-clean {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .list-clean li {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid #f1f5f9;
            margin-bottom: 8px;
        }
        .list-clean li:last-child {
            border-bottom: 0;
        }
        .flow-step {
            background: var(--gov-card);
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            padding: 14px 10px;
            font-weight: 600;
            color: var(--gov-primary);
            background: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.02);
            transition: all 0.3s ease;
            position: relative;
            z-index: 1;
        }
        .flow-step:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.06);
            border-color: var(--gov-accent);
            background: var(--gov-primary);
            color: #fff;
        }
        .cta-band {
            background: var(--gov-primary);
            color: #fff;
            border-radius: 12px;
            padding: 32px;
            box-shadow: 0 10px 25px rgba(12, 54, 88, 0.15);
            position: relative;
            overflow: hidden;
        }
        .cta-band::before {
            content: '';
            position: absolute;
            top: 0; right: 0; bottom: 0; left: 0;
            background: radial-gradient(circle at 90% 50%, rgba(255,255,255,0.1), transparent 60%);
        }
        .btn-light-solid {
            background: #fff;
            color: var(--gov-primary);
            border-radius: 6px;
            padding: 10px 18px;
            font-weight: 600;
            border: 1px solid transparent;
            position: relative;
            z-index: 2;
        }
        .btn-light-solid:hover {
            background: var(--gov-accent);
            color: #fff;
        }
        .gallery-shot {
            background: #fff;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            padding: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.04);
            transition: transform 0.3s ease;
        }
        .gallery-shot:hover {
            transform: scale(1.02);
        }
        .gallery-shot img {
            width: 100%;
            height: 170px;
            object-fit: cover;
            border-radius: 4px;
        }
        .footer-note {
            border-top: 1px solid #e2e8f0;
            padding-top: 24px;
            color: var(--gov-ink);
            font-size: 14px;
        }
        /* New Styles for Modern Feel */
        .navbar-transition {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            background: #fff;
            box-shadow: 0 1px 0 rgba(0,0,0,0.05);
        }
        .navbar-scrolled {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(0,0,0,0.05);
            box-shadow: 0 4px 20px rgba(0,0,0,0.06);
            padding-top: 12px !important;
            padding-bottom: 12px !important;
        }
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-12px); }
            100% { transform: translateY(0px); }
        }
        .hero-image-animate {
            animation: float 6s ease-in-out infinite;
        }
    </style>
</head>
<body>
    <header id="mainNav" class="fixed-top py-4 navbar-transition">
        <div class="container gov-container d-flex flex-wrap align-items-center justify-content-between gap-3">
            <div class="nav-brand">
                <?php
                    $logoHeader = $landing['landing_logo_header'] ?? null;
                    $logoHeaderUrl = $logoHeader ? base_url('landing/media/' . $logoHeader) : 'https://upload.wikimedia.org/wikipedia/commons/thumb/e/e5/Lambang_Kabupaten_Donggala_%282015-sekarang%29.png/196px-Lambang_Kabupaten_Donggala_%282015-sekarang%29.png';
                ?>
                <img src="<?= esc($logoHeaderUrl) ?>" alt="Logo Kabupaten Donggala">
                <div>
                    <div class="nav-title">SIPAT</div>
                    <div class="nav-subtitle">Pemda Donggala</div>
                </div>
            </div>
            <div class="d-flex gap-2">
                <a class="btn btn-outline-gov" href="<?= base_url('login') ?>">Login Pegawai</a>
                <a class="btn btn-gov" href="<?= base_url('dashboard') ?>">Dashboard</a>
            </div>
        </div>
    </header>

    <main style="padding-top: 110px;">
        <section class="py-5 position-relative">
            <!-- Background decoration -->
            <div style="position: absolute; top: -100px; right: -100px; width: 400px; height: 400px; background: radial-gradient(circle, rgba(234, 179, 8, 0.05) 0%, transparent 70%); border-radius: 50%; z-index: -1;"></div>
            
            <div class="container gov-container">
                <div class="row align-items-center g-5">
                    <div class="col-lg-6" data-aos="fade-right">
                        <span class="badge-gov mb-2"><i class="bi bi-building-check me-1"></i> Sistem Informasi Pensertifikatan Tanah</span>
                        <?php
                            $heroTitle = trim((string) ($landing['landing_hero_title'] ?? ''));
                            $heroSubtitle = trim((string) ($landing['landing_hero_subtitle'] ?? ''));
                        ?>
                        <h1 class="display-5 mt-2 fw-bold text-dark">
                            <?= esc($heroTitle !== '' ? $heroTitle : 'Monitoring aset tanah Pemda secara real-time, rapi, dan akuntabel.') ?>
                        </h1>
                        <p class="mt-3 text-secondary lead">
                            <?= esc($heroSubtitle !== '' ? $heroSubtitle : 'SIPAT membantu pengelola aset memantau proses pensertifikatan dari awal hingga sertifikat terbit, lengkap dengan dokumen digital, durasi proses, dan dashboard pimpinan yang mudah dipahami.') ?>
                        </p>
                        <div class="d-flex flex-wrap gap-2 mt-4">
                            <a class="btn btn-gov" href="<?= base_url('login') ?>">Akses Sistem</a>
                            <a class="btn btn-outline-gov" href="#fitur">Lihat Fitur</a>
                        </div>
                        <div class="mt-3 text-secondary small">
                            <?php
                                $ctaText = trim((string) ($landing['landing_cta_text'] ?? ''));
                            ?>
                            <?= esc($ctaText !== '' ? $ctaText : 'Data real-time langsung dari database SIPAT') ?>
                        </div>
                    </div>
                    <div class="col-lg-6" data-aos="fade-left" data-aos-delay="100">
                        <div class="hero-card">
                            <?php
                                $heroImage = $landing['landing_hero_image'] ?? null;
                                $heroImageUrl = $heroImage ? base_url('landing/media/' . $heroImage) : null;
                            ?>
                            <?php if ($heroImageUrl) : ?>
                                <img class="hero-image hero-image-animate" src="<?= esc($heroImageUrl) ?>" alt="Hero SIPAT">
                            <?php endif; ?>
                            <div class="mt-4">
                                <div class="badge-gov mb-2">Ringkasan Cepat</div>
                                <h3 class="mt-2">Status Proses Terkini</h3>
                                <p class="text-secondary mb-3">Data real-time dari database SIPAT.</p>
                                <div class="row g-3">
                                    <div class="col-6">
                                        <div class="stat-card">
                                            <div class="stat-value" data-count="<?= (int) ($asetProses ?? 0) ?>">0</div>
                                            <div class="stat-label">Dalam Proses</div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="stat-card">
                                            <div class="stat-value" data-count="<?= (int) ($asetBersertifikat ?? 0) ?>">0</div>
                                            <div class="stat-label">Bersertifikat</div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="stat-card">
                                            <div class="stat-value" data-count="<?= (int) ($asetKendala ?? 0) ?>">0</div>
                                            <div class="stat-label">Kendala</div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="stat-card">
                                            <div class="stat-value" data-count="<?= (int) ($totalAset ?? 0) ?>">0</div>
                                            <div class="stat-label">Total Aset</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="fitur" class="py-5">
            <div class="container gov-container">
                <div class="text-center mb-5" data-aos="fade-up">
                    <h2 class="section-title">Manfaat Utama</h2>
                    <p class="section-desc mx-auto" style="max-width: 600px;">Dirancang khusus untuk mendukung akuntabilitas dan transparansi pengelolaan aset daerah.</p>
                </div>
                <div class="row g-4">
                    <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="0">
                        <div class="card-elegant card-elegant--monitoring">
                            <div class="card-icon-wrapper"><i class="bi bi-display"></i></div>
                            <div class="badge-gov">Monitoring</div>
                            <div class="accent-line"></div>
                            <h5>Progres Real-Time</h5>
                            <p class="text-secondary mb-0">Lacak status aset dari pengukuran hingga sertifikat terbit.</p>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="100">
                        <div class="card-elegant card-elegant--dokumen">
                            <div class="card-icon-wrapper"><i class="bi bi-folder2-open"></i></div>
                            <div class="badge-gov">Dokumen</div>
                            <div class="accent-line"></div>
                            <h5>Arsip Digital</h5>
                            <p class="text-secondary mb-0">Simpan berkas penting per tahap dengan rapi dan mudah dicari.</p>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="200">
                        <div class="card-elegant card-elegant--peringatan">
                            <div class="card-icon-wrapper"><i class="bi bi-stopwatch"></i></div>
                            <div class="badge-gov">Peringatan</div>
                            <div class="accent-line"></div>
                            <h5>Durasi & Kendala</h5>
                            <p class="text-secondary mb-0">Tampilkan durasi proses dan identifikasi kendala lebih cepat.</p>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="300">
                        <div class="card-elegant card-elegant--pimpinan">
                            <div class="card-icon-wrapper"><i class="bi bi-person-workspace"></i></div>
                            <div class="badge-gov">Pimpinan</div>
                            <div class="accent-line"></div>
                            <h5>Dashboard Strategis</h5>
                            <p class="text-secondary mb-0">Rekap status dan progres per OPD untuk pimpinan.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-5">
            <div class="container gov-container">
                <div class="mb-4" data-aos="fade-right">
                    <h2 class="section-title">Rekap Real-Time</h2>
                    <p class="section-desc">Statistik terkini pengelolaan aset tanah Pemerintah Kabupaten Donggala.</p>
                </div>
                <div class="row g-4">
                    <div class="col-lg-6" data-aos="fade-up">
                        <div class="card-elegant">
                            <div class="badge-gov">Status Proses</div>
                            <ul class="list-clean mt-3">
                                <?php
                                    $statusItems = $statusCounts ?? [];
                                    arsort($statusItems);
                                    $shown = 0;
                                    foreach ($statusItems as $name => $count) :
                                        if ($shown >= 6) { break; }
                                        $shown++;
                                ?>
                                    <li>
                                        <span><?= esc($name) ?></span>
                                        <span class="pill"><?= number_format((int) $count) ?></span>
                                    </li>
                                <?php endforeach; ?>
                                <?php if (empty($statusItems)) : ?>
                                    <li>
                                        <span>Belum ada data</span>
                                        <span class="pill">0</span>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
                        <div class="card-elegant">
                            <div class="badge-gov">OPD Terbanyak</div>
                            <ul class="list-clean mt-3">
                                <?php
                                    $opdItems = $opdStats ?? [];
                                    $shown = 0;
                                    foreach ($opdItems as $name => $count) :
                                        if ($shown >= 6) { break; }
                                        $shown++;
                                ?>
                                    <li>
                                        <span><?= esc($name) ?></span>
                                        <span class="pill"><?= number_format((int) $count) ?></span>
                                    </li>
                                <?php endforeach; ?>
                                <?php if (empty($opdItems)) : ?>
                                    <li>
                                        <span>Belum ada data</span>
                                        <span class="pill">0</span>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-5">
            <div class="container gov-container">
                <div class="text-center mb-5" data-aos="fade-up">
                    <h2 class="section-title">Alur Kerja SIPAT</h2>
                    <p class="section-desc mx-auto" style="max-width: 600px;">Proses sistematis untuk memastikan setiap aset tanah terdata dan bersertifikat.</p>
                </div>
                <div class="row row-cols-2 row-cols-md-5 g-3" data-aos="fade-up">
                    <div class="col"><div class="flow-step text-center">Input Aset</div></div>
                    <div class="col"><div class="flow-step text-center">Update Status</div></div>
                    <div class="col"><div class="flow-step text-center">Upload Dokumen</div></div>
                    <div class="col"><div class="flow-step text-center">Monitoring</div></div>
                    <div class="col"><div class="flow-step text-center">Laporan</div></div>
                </div>
                <div class="cta-band mt-5 d-flex flex-wrap align-items-center justify-content-between gap-3" data-aos="zoom-in">
                    <div>
                        <h4 class="fw-bold mb-1">Amankan Aset Daerah Sekarang</h4>
                        <div class="text-white-50">Monitoring status tanah secara real-time untuk masa depan yang lebih baik.</div>
                    </div>
                    <a class="btn btn-light-solid" href="<?= base_url('login') ?>">Masuk SIPAT</a>
                </div>
            </div>
        </section>

        <section class="py-5 bg-white">
            <div class="container gov-container">
                <div class="mb-4" data-aos="fade-right">
                    <h2 class="section-title">Dokumentasi Lapangan</h2>
                    <p class="section-desc">Contoh visual proses lapangan dan arsip digital.</p>
                </div>
                <div class="row g-3">
                    <?php
                        $galleryDefaults = [
                            'https://images.unsplash.com/photo-1489515217757-5fd1be406fef?q=80&w=800&auto=format&fit=crop',
                            'https://images.unsplash.com/photo-1503387762-592deb58ef4e?q=80&w=800&auto=format&fit=crop',
                            'https://images.unsplash.com/photo-1520607162513-77705c0f0d4a?q=80&w=800&auto=format&fit=crop',
                        ];
                        $galleryKeys = ['landing_gallery_1', 'landing_gallery_2', 'landing_gallery_3'];
                    ?>
                    <?php foreach ($galleryKeys as $i => $key) : ?>
                        <?php
                            $file = $landing[$key] ?? null;
                            $url = $file ? base_url('landing/media/' . $file) : $galleryDefaults[$i];
                        ?>
                        <div class="col-md-4" data-aos="fade-up" data-aos-delay="<?= $i * 100 ?>">
                            <div class="gallery-shot">
                                <img src="<?= esc($url) ?>" alt="Dokumentasi lapangan">
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    </main>

    <footer class="py-4 bg-light border-top">
        <div class="container gov-container footer-note d-flex flex-wrap align-items-center justify-content-between gap-3">
            <?php
                $logoFooter = $landing['landing_logo_footer'] ?? null;
                $logoFooterUrl = $logoFooter ? base_url('landing/media/' . $logoFooter) : $logoHeaderUrl;
            ?>
            <div class="d-flex align-items-center gap-2">
                <img src="<?= esc($logoFooterUrl) ?>" alt="Logo Footer" style="width:32px;height:32px;border-radius:50%;border:1px solid rgba(31,58,95,0.15);">
                <span class="fw-semibold text-dark">Copyright &copy; <?= date('Y') ?> Pemerintah Kabupaten Donggala</span>
            </div>
            <div class="text-muted small"><?= esc($landing['landing_footer_text'] ?? 'Monitoring Pensertifikatan Tanah') ?></div>
        </div>
    </footer>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        // Initialize AOS
        AOS.init({
            once: true,
            duration: 800,
            offset: 60
        });

        // Navbar Scroll Effect
        const nav = document.getElementById('mainNav');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 20) {
                nav.classList.remove('navbar-transition', 'py-4');
                nav.classList.add('navbar-scrolled');
            } else {
                nav.classList.add('navbar-transition', 'py-4');
                nav.classList.remove('navbar-scrolled');
            }
        });

        // Simple Counter Animation
        const counters = document.querySelectorAll('.stat-value[data-count]');
        const speed = 200;

        const animateCounters = () => {
            counters.forEach(counter => {
                const updateCount = () => {
                    const target = +counter.getAttribute('data-count');
                    const count = +counter.innerText.replace(/,/g, '');
                    const inc = target / speed;

                    if (count < target) {
                        counter.innerText = Math.ceil(count + inc).toLocaleString();
                        setTimeout(updateCount, 20);
                    } else {
                        counter.innerText = target.toLocaleString();
                    }
                };
                updateCount();
            });
        };

        // Trigger counter when stats section is visible
        let animated = false;
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting && !animated) {
                    animateCounters();
                    animated = true;
                }
            });
        }, { threshold: 0.5 });

        const statSection = document.querySelector('.stat-card');
        if (statSection) {
            observer.observe(statSection);
        }
    </script>
</body>
</html>
