<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SIPAT - Sistem Informasi Pensertifikatan Tanah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Source+Sans+3:wght@400;500;600;700&family=Source+Serif+4:wght@600;700&display=swap');
        :root {
            --gov-primary: #1f3a5f;
            --gov-primary-2: #162c49;
            --gov-accent: #c8a13a;
            --gov-ink: #111827;
            --gov-muted: #6b7280;
            --gov-bg: #f5f7fb;
            --gov-card: #ffffff;
        }
        body {
            font-family: "Source Sans 3", "Segoe UI", sans-serif;
            color: var(--gov-ink);
            background:
                radial-gradient(900px 420px at 10% -10%, rgba(31, 58, 95, 0.14), transparent 60%),
                radial-gradient(900px 420px at 90% 0%, rgba(200, 161, 58, 0.12), transparent 60%),
                var(--gov-bg);
        }
        h1, h2, h3, .display-5 {
            font-family: "Source Serif 4", "Georgia", serif;
            color: var(--gov-primary);
            letter-spacing: 0.2px;
        }
        .gov-container {
            max-width: 1200px;
        }
        .nav-brand {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .nav-brand img {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: #fff;
            border: 1px solid rgba(31, 58, 95, 0.15);
            box-shadow: 0 6px 16px rgba(15, 23, 42, 0.08);
        }
        .nav-title {
            font-weight: 700;
            letter-spacing: 0.2px;
        }
        .nav-subtitle {
            font-size: 12px;
            color: var(--gov-muted);
            text-transform: uppercase;
            letter-spacing: 0.12em;
        }
        .btn-gov {
            background: var(--gov-primary);
            color: #fff;
            border-radius: 8px;
            padding: 10px 18px;
            font-weight: 600;
            border: 1px solid transparent;
            box-shadow: 0 10px 20px rgba(31, 58, 95, 0.2);
        }
        .btn-gov:hover {
            background: var(--gov-primary-2);
            color: #fff;
        }
        .btn-outline-gov {
            color: var(--gov-primary);
            border: 1px solid rgba(31, 58, 95, 0.35);
            border-radius: 8px;
            padding: 10px 18px;
            font-weight: 600;
            background: #fff;
        }
        .btn-outline-gov:hover {
            background: rgba(31, 58, 95, 0.06);
            color: var(--gov-primary);
        }
        .hero-card {
            background: var(--gov-card);
            border-radius: 18px;
            border: 1px solid rgba(31, 58, 95, 0.12);
            box-shadow: 0 20px 40px rgba(15, 23, 42, 0.08);
            padding: 28px;
        }
        .hero-image {
            width: 100%;
            border-radius: 14px;
            border: 1px solid rgba(31, 58, 95, 0.12);
            box-shadow: 0 14px 28px rgba(15, 23, 42, 0.08);
            object-fit: cover;
            height: 260px;
        }
        .badge-gov {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 12px;
            border-radius: 999px;
            background: rgba(31, 58, 95, 0.12);
            color: var(--gov-primary);
            font-size: 12px;
            font-weight: 600;
        }
        .stat-card {
            background: var(--gov-card);
            border-radius: 14px;
            border: 1px solid rgba(31, 58, 95, 0.1);
            box-shadow: 0 10px 22px rgba(15, 23, 42, 0.06);
            padding: 18px;
            height: 100%;
        }
        .stat-value {
            font-size: 26px;
            font-weight: 700;
            color: var(--gov-primary);
        }
        .stat-label {
            font-size: 13px;
            color: var(--gov-muted);
        }
        .section-title {
            font-size: 28px;
            margin-bottom: 6px;
        }
        .section-desc {
            color: var(--gov-muted);
            margin-bottom: 24px;
        }
        .card-elegant {
            background: var(--gov-card);
            border-radius: 16px;
            border: 1px solid rgba(31, 58, 95, 0.1);
            box-shadow: 0 14px 28px rgba(15, 23, 42, 0.06);
            padding: 18px;
            height: 100%;
        }
        .accent-line {
            width: 36px;
            height: 3px;
            background: var(--gov-accent);
            border-radius: 999px;
            margin: 10px 0 12px;
        }
        .pill {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 36px;
            padding: 4px 10px;
            border-radius: 999px;
            background: rgba(31, 58, 95, 0.1);
            color: var(--gov-primary);
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
            padding: 10px 12px;
            border-radius: 12px;
            border: 1px solid rgba(31, 58, 95, 0.08);
            background: rgba(255, 255, 255, 0.7);
            margin-bottom: 8px;
        }
        .flow-step {
            background: var(--gov-card);
            border-radius: 12px;
            border: 1px dashed rgba(31, 58, 95, 0.35);
            padding: 14px 10px;
            font-weight: 600;
            color: var(--gov-primary);
        }
        .cta-band {
            background: linear-gradient(135deg, #1f3a5f, #253f66);
            color: #fff;
            border-radius: 18px;
            padding: 22px 26px;
            box-shadow: 0 18px 34px rgba(15, 23, 42, 0.14);
        }
        .gallery-shot {
            background: #fff;
            border-radius: 12px;
            border: 1px solid rgba(31, 58, 95, 0.1);
            padding: 8px;
            box-shadow: 0 10px 20px rgba(15, 23, 42, 0.06);
        }
        .gallery-shot img {
            width: 100%;
            height: 170px;
            object-fit: cover;
            border-radius: 10px;
        }
        .footer-note {
            border-top: 1px solid rgba(31, 58, 95, 0.12);
            padding-top: 18px;
            color: var(--gov-muted);
            font-size: 14px;
        }
    </style>
</head>
<body>
    <header class="bg-white border-bottom py-3 shadow-sm">
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
                <a class="btn btn-outline-gov" href="<?= base_url('login') ?>">Masuk</a>
                <a class="btn btn-gov" href="<?= base_url('dashboard') ?>">Dashboard</a>
            </div>
        </div>
    </header>

    <main>
        <section class="py-5">
            <div class="container gov-container">
                <div class="row align-items-center g-5">
                    <div class="col-lg-6">
                        <span class="badge-gov">Sistem Informasi Pensertifikatan Tanah</span>
                        <?php
                            $heroTitle = trim((string) ($landing['landing_hero_title'] ?? ''));
                            $heroSubtitle = trim((string) ($landing['landing_hero_subtitle'] ?? ''));
                        ?>
                        <h1 class="display-5 mt-3">
                            <?= esc($heroTitle !== '' ? $heroTitle : 'Monitoring aset tanah Pemda secara real-time, rapi, dan akuntabel.') ?>
                        </h1>
                        <p class="mt-3 text-secondary">
                            <?= esc($heroSubtitle !== '' ? $heroSubtitle : 'SIPAT membantu pengelola aset memantau proses pensertifikatan dari awal hingga sertifikat terbit, lengkap dengan dokumen digital, durasi proses, dan dashboard pimpinan yang mudah dipahami.') ?>
                        </p>
                        <div class="d-flex flex-wrap gap-2 mt-4">
                            <a class="btn btn-gov" href="<?= base_url('login') ?>">Masuk Sistem</a>
                            <a class="btn btn-outline-gov" href="#fitur">Lihat Fitur</a>
                        </div>
                        <div class="mt-3 text-secondary small">
                            <?php
                                $ctaText = trim((string) ($landing['landing_cta_text'] ?? ''));
                            ?>
                            <?= esc($ctaText !== '' ? $ctaText : 'Data real-time langsung dari database SIPAT') ?>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="hero-card">
                            <?php
                                $heroImage = $landing['landing_hero_image'] ?? null;
                                $heroImageUrl = $heroImage ? base_url('landing/media/' . $heroImage) : null;
                            ?>
                            <?php if ($heroImageUrl) : ?>
                                <img class="hero-image" src="<?= esc($heroImageUrl) ?>" alt="Hero SIPAT">
                            <?php endif; ?>
                            <div class="mt-4">
                                <div class="badge-gov">Ringkasan Cepat</div>
                                <h3 class="mt-2">Status Proses Terkini</h3>
                                <p class="text-secondary mb-3">Data real-time dari database SIPAT.</p>
                                <div class="row g-3">
                                    <div class="col-6">
                                        <div class="stat-card">
                                            <div class="stat-value"><?= number_format((int) ($asetProses ?? 0)) ?></div>
                                            <div class="stat-label">Dalam Proses</div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="stat-card">
                                            <div class="stat-value"><?= number_format((int) ($asetBersertifikat ?? 0)) ?></div>
                                            <div class="stat-label">Bersertifikat</div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="stat-card">
                                            <div class="stat-value"><?= number_format((int) ($asetKendala ?? 0)) ?></div>
                                            <div class="stat-label">Kendala</div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="stat-card">
                                            <div class="stat-value"><?= number_format((int) ($totalAset ?? 0)) ?></div>
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
                <h2 class="section-title">Manfaat Utama</h2>
                <p class="section-desc">Dirancang untuk alur kerja Pemda yang cepat dan transparan.</p>
                <div class="row g-4">
                    <div class="col-md-6 col-lg-3">
                        <div class="card-elegant">
                            <div class="badge-gov">Monitoring</div>
                            <div class="accent-line"></div>
                            <h5>Progres Real-Time</h5>
                            <p class="text-secondary mb-0">Lacak status aset dari pengukuran hingga sertifikat terbit.</p>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="card-elegant">
                            <div class="badge-gov">Dokumen</div>
                            <div class="accent-line"></div>
                            <h5>Arsip Digital</h5>
                            <p class="text-secondary mb-0">Simpan berkas penting per tahap dengan rapi dan mudah dicari.</p>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="card-elegant">
                            <div class="badge-gov">Peringatan</div>
                            <div class="accent-line"></div>
                            <h5>Durasi & Kendala</h5>
                            <p class="text-secondary mb-0">Tampilkan durasi proses dan identifikasi kendala lebih cepat.</p>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="card-elegant">
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
                <h2 class="section-title">Rekap Real-Time</h2>
                <p class="section-desc">Ringkasan status proses dan OPD dengan aset terbanyak.</p>
                <div class="row g-4">
                    <div class="col-lg-6">
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
                    <div class="col-lg-6">
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
                <h2 class="section-title">Alur Kerja SIPAT</h2>
                <p class="section-desc">Sederhana dan terukur dari awal hingga selesai.</p>
                <div class="row row-cols-2 row-cols-md-5 g-3">
                    <div class="col"><div class="flow-step text-center">Input Aset</div></div>
                    <div class="col"><div class="flow-step text-center">Update Status</div></div>
                    <div class="col"><div class="flow-step text-center">Upload Dokumen</div></div>
                    <div class="col"><div class="flow-step text-center">Monitoring</div></div>
                    <div class="col"><div class="flow-step text-center">Laporan</div></div>
                </div>
                <div class="cta-band mt-4 d-flex flex-wrap align-items-center justify-content-between gap-3">
                    <div>
                        <div class="fw-semibold">Jangan sampai aset terlambat diproses</div>
                        <div class="text-white-50">Mulai monitoring status tanah sekarang juga.</div>
                    </div>
                    <a class="btn btn-outline-gov" style="background: #fff;" href="<?= base_url('login') ?>">Masuk SIPAT</a>
                </div>
            </div>
        </section>

        <section class="py-5">
            <div class="container gov-container">
                <h2 class="section-title">Dokumentasi Lapangan</h2>
                <p class="section-desc">Contoh visual proses lapangan dan arsip digital.</p>
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
                        <div class="col-md-4">
                            <div class="gallery-shot">
                                <img src="<?= esc($url) ?>" alt="Dokumentasi lapangan">
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    </main>

    <footer class="py-4 bg-white">
        <div class="container gov-container footer-note d-flex flex-wrap align-items-center justify-content-between gap-3">
            <?php
                $logoFooter = $landing['landing_logo_footer'] ?? null;
                $logoFooterUrl = $logoFooter ? base_url('landing/media/' . $logoFooter) : $logoHeaderUrl;
            ?>
            <div class="d-flex align-items-center gap-2">
                <img src="<?= esc($logoFooterUrl) ?>" alt="Logo Footer" style="width:32px;height:32px;border-radius:50%;border:1px solid rgba(31,58,95,0.15);">
                <span>Copyright <?= date('Y') ?> SIPAT - Pemda Donggala</span>
            </div>
            <div><?= esc($landing['landing_footer_text'] ?? 'Monitoring Pensertifikatan Tanah') ?></div>
        </div>
    </footer>
</body>
</html>
