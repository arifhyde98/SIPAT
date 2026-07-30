<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<style>
    :root {
        --gov-primary: #1E5EFF;
        --gov-primary-hover: #1846C7;
        --gov-secondary: #64748b;
        --gov-success: #22C55E;
        --gov-warning: #F59E0B;
        --gov-danger: #EF4444;
        --gov-bg: #F8FAFC;
        --gov-card-bg: #FFFFFF;
    }
    
    /* Utility */
    .text-gov-primary { color: var(--gov-primary); }
    .text-gov-success { color: var(--gov-success); }
    .text-gov-warning { color: var(--gov-warning); }
    .text-gov-danger { color: var(--gov-danger); }
    
    .bg-gov-primary-light { background-color: #eff6ff; }
    .bg-gov-success-light { background-color: #f0fdf4; }
    .bg-gov-warning-light { background-color: #fffbeb; }
    .bg-gov-danger-light { background-color: #fef2f2; }

    /* Buttons */
    .btn-gov {
        background-color: var(--gov-primary);
        color: #fff;
        border-radius: 8px;
        padding: 8px 16px;
        font-weight: 500;
        font-size: 0.9rem;
        border: 1px solid transparent;
        transition: all 0.2s ease;
        box-shadow: 0 2px 4px rgba(30, 94, 255, 0.15);
    }
    .btn-gov:hover {
        background-color: var(--gov-primary-hover);
        color: #fff;
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(30, 94, 255, 0.2);
    }
    .btn-outline-gov {
        background-color: var(--gov-card-bg);
        color: var(--gov-primary);
        border: 1px solid var(--gov-primary);
        border-radius: 8px;
        padding: 8px 16px;
        font-weight: 500;
        font-size: 0.9rem;
        transition: all 0.2s ease;
    }
    .btn-outline-gov:hover {
        background-color: #f1f5f9;
        color: var(--gov-primary);
    }
    .btn-light-gov {
        background-color: var(--gov-card-bg);
        color: #475569;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 8px 16px;
        font-weight: 500;
        font-size: 0.9rem;
        transition: all 0.2s ease;
    }
    .btn-light-gov:hover {
        background-color: #f8fafc;
        border-color: #cbd5e1;
    }

    /* Cards */
    .card {
        border: 1px solid #f1f5f9;
        border-radius: 16px;
        background: var(--gov-card-bg);
        box-shadow: 0 2px 8px rgba(15, 23, 42, 0.04);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .card-stat {
        padding: 24px;
        position: relative;
        overflow: hidden;
    }
    .card-stat:hover, .card:hover {
        box-shadow: 0 8px 24px rgba(15, 23, 42, 0.08);
    }
    
    /* Stat Icons & Text */
    .stat-header {
        display: flex;
        align-items: flex-start;
        gap: 16px;
    }
    .stat-icon {
        width: 64px;
        height: 64px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        flex-shrink: 0;
        color: #ffffff;
    }
    .icon-primary { background-color: var(--gov-primary); }
    .icon-success { background-color: var(--gov-success); }
    .icon-warning { background-color: var(--gov-warning); }
    .icon-danger { background-color: var(--gov-danger); }
    .stat-value {
        font-size: 32px;
        font-weight: 700;
        color: #0f172a;
        line-height: 1.1;
        margin-top: 8px;
        letter-spacing: -0.5px;
    }
    .stat-label {
        font-size: 14px;
        font-weight: 500;
        color: #64748b;
        margin-top: 4px;
    }
    .stat-footer {
        margin-top: 16px;
        font-size: 13px;
        color: #64748b;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .progress-bar-thin {
        height: 4px;
        border-radius: 2px;
        background-color: #f1f5f9;
        margin-top: 12px;
        overflow: hidden;
    }
    .progress-bar-thin .progress-value {
        height: 100%;
        border-radius: 2px;
    }
    
    .wave-bg {
        position: absolute;
        bottom: 0;
        right: 0;
        width: 100px;
        height: 50px;
        opacity: 0.1;
        background: url('data:image/svg+xml;utf8,<svg viewBox="0 0 100 50" xmlns="http://www.w3.org/2000/svg"><path d="M0,50 C30,30 40,50 70,30 C90,15 100,20 100,20 L100,50 Z" fill="%231E5EFF"/></svg>') no-repeat bottom right;
        background-size: cover;
    }

    /* Charts */
    .card-header {
        background: transparent;
        border-bottom: 1px solid #f1f5f9;
        padding: 20px 24px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .card-title {
        font-size: 16px;
        font-weight: 600;
        color: #0f172a;
        margin: 0;
    }
    .chart-container {
        position: relative;
        width: 100%;
    }
    
    .badge-soft-primary {
        background-color: #eff6ff;
        color: var(--gov-primary);
        font-weight: 500;
        padding: 4px 8px;
        border-radius: 6px;
    }

    .mini-stat-card {
        border: 1px solid #f1f5f9;
        border-radius: 12px;
        padding: 16px;
        background: #f8fafc;
    }
    
    .breadcrumb-custom {
        font-size: 13px;
        color: #64748b;
        margin-bottom: 8px;
    }
    .breadcrumb-custom a {
        color: #64748b;
        text-decoration: none;
    }
    .breadcrumb-custom a:hover {
        color: var(--gov-primary);
    }
</style>

    <!-- Header Dashboard -->
    <div class="d-flex justify-content-between align-items-start flex-wrap gap-3 mb-4">
        <div>
            <h1 class="h3 fw-bold mb-1 text-dark">Dashboard</h1>
            <div class="breadcrumb-custom">
                <a href="<?= base_url('dashboard') ?>">Beranda</a> &gt; Dashboard
            </div>
            <p class="text-dark fw-medium mt-3 mb-1" style="font-size: 1.05rem;">
                Selamat datang kembali, <?= esc(session()->get('user_name') ?? 'Admin SIPAT') ?> 👋
            </p>
            <p class="text-muted mb-0" style="font-size: 0.9rem;">
                Monitoring Pensertifikatan Aset Tanah Kabupaten Donggala secara real-time.
            </p>
        </div>
        <div class="d-flex align-items-center gap-3 mt-2 mt-md-0">
            <div class="btn-light-gov d-flex align-items-center gap-2">
                <i class="bi bi-calendar4"></i>
                <span style="font-size: 0.85rem; text-align: left; line-height: 1.2;">
                    <?php
                        $formatter = new \IntlDateFormatter('id_ID', \IntlDateFormatter::FULL, \IntlDateFormatter::SHORT);
                        $formatter->setPattern('EEEE, dd MMMM yyyy HH:mm \W\I\B');
                        echo $formatter->format(new \DateTime());
                    ?>
                </span>
            </div>
            <a href="<?= base_url('laporan') ?>" class="btn btn-outline-gov d-flex align-items-center gap-2">
                <i class="bi bi-file-earmark-text"></i> Laporan <i class="bi bi-chevron-down ms-1" style="font-size: 0.75rem;"></i>
            </a>
            <a href="<?= base_url('aset/create') ?>" class="btn btn-gov d-flex align-items-center gap-2">
                <i class="bi bi-plus-lg"></i> Tambah Aset
            </a>
        </div>
    </div>

    <!-- Baris Kartu Statistik -->
    <?php
        $breakdowns = $statusBreakdowns ?? [];
        $totalAsetVal = $totalAset ?? 0;
        $asetBersertifikatVal = $asetBersertifikat ?? 0;
        $asetProsesVal = $asetProses ?? 0;
        $asetKendalaVal = $asetKendala ?? 0;
        $asetBelumDiurusVal = $asetBelumDiurus ?? 0;
        
        $pctBersertifikat = $totalAsetVal > 0 ? round(($asetBersertifikatVal / $totalAsetVal) * 100, 1) : 0;
        $pctProses = $totalAsetVal > 0 ? round(($asetProsesVal / $totalAsetVal) * 100, 1) : 0;
        $pctKendala = $totalAsetVal > 0 ? round(($asetKendalaVal / $totalAsetVal) * 100, 1) : 0;

        $breakdownSertifikat = $breakdowns['bersertifikat'] ?? [];
        $breakdownProses = $breakdowns['proses'] ?? [];
        $breakdownKendala = $breakdowns['kendala'] ?? [];
        $breakdownBelumDiurus = $breakdowns['belum_diurus'] ?? [];
    ?>
    <div class="row g-4 mb-5">
        <div class="col-md-6 col-xl-3">
            <div class="card card-stat h-100 d-flex flex-column">
                <div class="wave-bg"></div>
                <div class="position-relative flex-grow-1" style="z-index: 1;">
                    <div class="stat-header">
                        <div class="stat-icon icon-primary">
                            <i class="bi bi-box"></i>
                        </div>
                        <div>
                            <div class="stat-label mt-0 mb-1">Total Aset</div>
                            <div class="stat-value mt-0"><?= number_format($totalAsetVal, 0, ',', '.') ?></div>
                        </div>
                    </div>
                    <div class="stat-footer">
                        <span class="badge-soft-primary"><i class="bi bi-arrow-up-short"></i> 18</span>
                        <span>Bulan ini</span>
                    </div>
                </div>
                <!-- Breakdown Belum Diurus (jika ada) -->
                <?php if(!empty($breakdownBelumDiurus) || $asetBelumDiurusVal > 0): ?>
                <div class="mt-4 pt-3 border-top position-relative" style="z-index: 1;">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-muted" style="font-size: 12px; font-weight: 500;">Belum Diurus</span>
                        <span class="fw-semibold text-dark" style="font-size: 12px;"><?= number_format($asetBelumDiurusVal, 0, ',', '.') ?></span>
                    </div>
                    <?php $count = 0; foreach($breakdownBelumDiurus as $status => $val): if($count>=2) break; ?>
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <span class="text-muted text-truncate pe-2" style="font-size: 11px;">- <?= esc($status) ?></span>
                        <span class="text-dark" style="font-size: 11px;"><?= number_format($val, 0, ',', '.') ?></span>
                    </div>
                    <?php $count++; endforeach; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="col-md-6 col-xl-3">
            <div class="card card-stat h-100 d-flex flex-column">
                <div class="flex-grow-1">
                    <div class="stat-header">
                        <div class="stat-icon icon-success">
                            <i class="bi bi-shield-check"></i>
                        </div>
                        <div>
                            <div class="stat-label mt-0 mb-1">Sudah Bersertifikat</div>
                            <div class="stat-value mt-0"><?= number_format($asetBersertifikatVal, 0, ',', '.') ?></div>
                        </div>
                    </div>
                    <div class="stat-footer justify-content-between align-items-end mb-1 mt-3">
                        <span><strong><?= str_replace('.', ',', $pctBersertifikat) ?>%</strong> dari total aset</span>
                    </div>
                    <div class="progress-bar-thin">
                        <div class="progress-value bg-gov-success" style="width: <?= $pctBersertifikat ?>%;"></div>
                    </div>
                </div>
                <!-- Breakdown Sertifikat -->
                <?php if(!empty($breakdownSertifikat)): ?>
                <div class="mt-4 pt-3 border-top">
                    <?php $count = 0; foreach($breakdownSertifikat as $status => $val): if($count>=3) break; ?>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-muted text-truncate pe-2" style="font-size: 12px;"><?= esc($status) ?></span>
                        <span class="fw-medium text-dark" style="font-size: 12px;"><?= number_format($val, 0, ',', '.') ?></span>
                    </div>
                    <?php $count++; endforeach; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card card-stat h-100 d-flex flex-column">
                <div class="flex-grow-1">
                    <div class="stat-header">
                        <div class="stat-icon icon-warning">
                            <i class="bi bi-hourglass-split"></i>
                        </div>
                        <div>
                            <div class="stat-label mt-0 mb-1">Dalam Proses</div>
                            <div class="stat-value mt-0"><?= number_format($asetProsesVal, 0, ',', '.') ?></div>
                        </div>
                    </div>
                    <div class="stat-footer justify-content-between align-items-end mb-1 mt-3">
                        <span><strong><?= str_replace('.', ',', $pctProses) ?>%</strong> dari total aset</span>
                    </div>
                    <div class="progress-bar-thin">
                        <div class="progress-value bg-gov-warning" style="width: <?= $pctProses ?>%;"></div>
                    </div>
                </div>
                <!-- Breakdown Proses -->
                <?php if(!empty($breakdownProses)): ?>
                <div class="mt-4 pt-3 border-top">
                    <?php $count = 0; foreach($breakdownProses as $status => $val): if($count>=3) break; ?>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-muted text-truncate pe-2" style="font-size: 12px;"><?= esc($status) ?></span>
                        <span class="fw-medium text-dark" style="font-size: 12px;"><?= number_format($val, 0, ',', '.') ?></span>
                    </div>
                    <?php $count++; endforeach; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card card-stat h-100 d-flex flex-column">
                <div class="flex-grow-1">
                    <div class="stat-header">
                        <div class="stat-icon icon-danger">
                            <i class="bi bi-exclamation-triangle"></i>
                        </div>
                        <div>
                            <div class="stat-label mt-0 mb-1">Ada Kendala</div>
                            <div class="stat-value mt-0"><?= number_format($asetKendalaVal, 0, ',', '.') ?></div>
                        </div>
                    </div>
                    <div class="stat-footer justify-content-between align-items-end mb-1 mt-3">
                        <span><strong><?= str_replace('.', ',', $pctKendala) ?>%</strong> dari total aset</span>
                    </div>
                    <div class="progress-bar-thin">
                        <div class="progress-value bg-gov-danger" style="width: <?= $pctKendala ?>%;"></div>
                    </div>
                </div>
                <!-- Breakdown Kendala -->
                <?php if(!empty($breakdownKendala)): ?>
                <div class="mt-4 pt-3 border-top">
                    <?php $count = 0; foreach($breakdownKendala as $status => $val): if($count>=3) break; ?>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-muted text-truncate pe-2" style="font-size: 12px;"><?= esc($status) ?></span>
                        <span class="fw-medium text-dark" style="font-size: 12px;"><?= number_format($val, 0, ',', '.') ?></span>
                    </div>
                    <?php $count++; endforeach; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <!-- Baris Grafik -->
    <div class="row g-4 mb-4">
        <div class="col-xl-7">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title">Progres Aset Bulanan</h5>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-light-gov dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Tahun 2026
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                            <li><a class="dropdown-item" href="#">Tahun 2026</a></li>
                            <li><a class="dropdown-item" href="#">Tahun 2025</a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-center gap-4 mb-3" style="font-size: 13px; color: #64748b;">
                        <div class="d-flex align-items-center gap-2"><span style="width: 8px; height: 8px; border-radius: 2px; background-color: var(--gov-success);"></span> Sertifikat Selesai</div>
                        <div class="d-flex align-items-center gap-2"><span style="width: 8px; height: 8px; border-radius: 2px; background-color: var(--gov-warning);"></span> Dalam Proses</div>
                        <div class="d-flex align-items-center gap-2"><span style="width: 8px; height: 8px; border-radius: 2px; background-color: var(--gov-primary);"></span> Belum Bersertifikat</div>
                    </div>
                    <div class="chart-container" style="height: 280px;">
                        <canvas id="progressChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-5">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title">Distribusi per OPD</h5>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-light-gov dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Semua OPD
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                            <li><a class="dropdown-item" href="#">Semua OPD</a></li>
                            <li><a class="dropdown-item" href="#">BPKAD</a></li>
                            <li><a class="dropdown-item" href="#">Dinas Pendidikan</a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-body d-flex flex-column">
                    <div class="row flex-grow-1 align-items-center">
                        <div class="col-6">
                            <div class="chart-container" style="height: 220px; position: relative;">
                                <canvas id="opdChart"></canvas>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex flex-column gap-3" style="font-size: 13px;">
                                <?php
                                    $opdLabels = isset($opdStats) ? array_keys($opdStats) : ['Dinas A', 'Dinas B', 'Lainnya'];
                                    $opdValues = isset($opdStats) ? array_values($opdStats) : [30, 50, 20];
                                    $opdColors = ['#1E5EFF', '#22C55E', '#F59E0B', '#8B5CF6', '#06B6D4', '#EF4444', '#64748B'];
                                    $totalOpdAset = array_sum($opdValues);
                                    
                                    $limit = 5;
                                    $count = 0;
                                    foreach ($opdLabels as $index => $label):
                                        if ($count >= $limit) break;
                                        $value = $opdValues[$index];
                                        $color = $opdColors[$index % count($opdColors)];
                                        $percent = $totalOpdAset > 0 ? round(($value / $totalOpdAset) * 100) : 0;
                                ?>
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center gap-2">
                                        <span style="width: 8px; height: 8px; border-radius: 2px; background-color: <?= $color ?>;"></span> <span class="fw-medium text-dark text-truncate" style="max-width: 120px;" title="<?= esc($label) ?>"><?= esc($label) ?></span>
                                    </div>
                                    <span class="text-muted"><?= number_format($value) ?> (<?= $percent ?>%)</span>
                                </div>
                                <?php 
                                        $count++;
                                    endforeach; 
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="mt-3 p-3 bg-gov-bg rounded-3 d-flex flex-column">
                        <span class="text-gov-primary" style="font-size: 13px; font-weight: 500;">Total Aset</span>
                        <span class="fw-bold text-dark" style="font-size: 16px;"><?= number_format($totalAsetVal, 0, ',', '.') ?> Aset</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Baris Aktivitas & Status -->
    <div class="row g-4 mb-4">
        <div class="col-xl-5">
            <div class="card h-100">
                <div class="card-header pb-0 border-0 pt-4">
                    <h5 class="card-title">Aktivitas Terbaru</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex flex-column gap-4">
                        <div class="d-flex align-items-start gap-3">
                            <div class="bg-gov-success-light text-gov-success rounded-circle d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                                <i class="bi bi-check2"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-1 fw-bold text-dark" style="font-size: 14px;">Aset tanah berhasil ditambahkan</h6>
                                <p class="mb-0 text-muted" style="font-size: 13px;">Lapangan Bola Desa Labuan</p>
                            </div>
                            <div class="text-end">
                                <div class="text-muted" style="font-size: 12px;">30 Jul 2026</div>
                                <div class="text-muted" style="font-size: 12px;">10:12 WIB</div>
                            </div>
                        </div>
                        
                        <div class="d-flex align-items-start gap-3">
                            <div class="bg-gov-warning-light text-gov-warning rounded-circle d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                                <i class="bi bi-file-earmark-text"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-1 fw-bold text-dark" style="font-size: 14px;">Proses sertifikasi selesai</h6>
                                <p class="mb-0 text-muted" style="font-size: 13px;">Puskesmas Banawa</p>
                            </div>
                            <div class="text-end">
                                <div class="text-muted" style="font-size: 12px;">30 Jul 2026</div>
                                <div class="text-muted" style="font-size: 12px;">09:45 WIB</div>
                            </div>
                        </div>

                        <div class="d-flex align-items-start gap-3">
                            <div class="bg-gov-primary-light text-gov-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                                <i class="bi bi-cloud-arrow-up"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-1 fw-bold text-dark" style="font-size: 14px;">Import data aset berhasil</h6>
                                <p class="mb-0 text-muted" style="font-size: 13px;">File: aset_tanah_juli_2026.xlsx</p>
                            </div>
                            <div class="text-end">
                                <div class="text-muted" style="font-size: 12px;">30 Jul 2026</div>
                                <div class="text-muted" style="font-size: 12px;">09:20 WIB</div>
                            </div>
                        </div>
                    </div>
                    <a href="#" class="btn btn-outline-gov w-100 mt-4 d-flex align-items-center justify-content-center gap-2">
                        Lihat semua aktivitas <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
        
        <div class="col-xl-7">
            <div class="d-flex flex-column h-100 gap-4">
                <div class="card flex-grow-1">
                    <div class="card-header pb-0 border-0 pt-4">
                        <h5 class="card-title">Aset Berdasarkan Status Sertifikasi</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-sm-6 col-md-3">
                                <div class="mini-stat-card h-100">
                                    <div class="text-gov-success fw-medium mb-2" style="font-size: 13px;">Sudah Bersertifikat</div>
                                    <div class="d-flex align-items-end justify-content-between mb-2">
                                        <span class="fs-4 fw-bold text-dark"><?= number_format($asetBersertifikatVal, 0, ',', '.') ?></span>
                                        <span class="text-muted" style="font-size: 12px;"><?= str_replace('.', ',', $pctBersertifikat) ?>%</span>
                                    </div>
                                    <div class="progress-bar-thin mt-0 bg-gov-success-light">
                                        <div class="progress-value bg-gov-success" style="width: <?= $pctBersertifikat ?>%;"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-3">
                                <div class="mini-stat-card h-100">
                                    <div class="text-gov-warning fw-medium mb-2" style="font-size: 13px;">Dalam Proses</div>
                                    <div class="d-flex align-items-end justify-content-between mb-2">
                                        <span class="fs-4 fw-bold text-dark"><?= number_format($asetProsesVal, 0, ',', '.') ?></span>
                                        <span class="text-muted" style="font-size: 12px;"><?= str_replace('.', ',', $pctProses) ?>%</span>
                                    </div>
                                    <div class="progress-bar-thin mt-0 bg-gov-warning-light">
                                        <div class="progress-value bg-gov-warning" style="width: <?= $pctProses ?>%;"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-3">
                                <div class="mini-stat-card h-100">
                                    <div class="text-gov-danger fw-medium mb-2" style="font-size: 13px;">Bermasalah</div>
                                    <div class="d-flex align-items-end justify-content-between mb-2">
                                        <span class="fs-4 fw-bold text-dark"><?= number_format($asetKendalaVal, 0, ',', '.') ?></span>
                                        <span class="text-muted" style="font-size: 12px;"><?= str_replace('.', ',', $pctKendala) ?>%</span>
                                    </div>
                                    <div class="progress-bar-thin mt-0 bg-gov-danger-light">
                                        <div class="progress-value bg-gov-danger" style="width: <?= $pctKendala ?>%;"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-3">
                                <div class="mini-stat-card h-100">
                                    <div class="text-gov-primary fw-medium mb-2" style="font-size: 13px;">Belum Bersertifikat</div>
                                    <div class="d-flex align-items-end justify-content-between mb-2">
                                        <span class="fs-4 fw-bold text-dark"><?= number_format((isset($asetBelumDiurus) ? $asetBelumDiurus : 0), 0, ',', '.') ?></span>
                                        <span class="text-muted" style="font-size: 12px;">0%</span>
                                    </div>
                                    <div class="progress-bar-thin mt-0 bg-secondary bg-opacity-10">
                                        <div class="progress-value bg-secondary opacity-25" style="width: 0%;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="bg-gov-primary-light text-gov-primary rounded-3 p-3 d-flex align-items-center gap-3">
                    <i class="bi bi-info-circle ms-2"></i>
                    <span style="font-size: 13px;">Data diperbarui secara real-time sesuai dengan input dari masing-masing OPD.</span>
                </div>
            </div>
        </div>
    </div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Progress Chart (Dummy Data for now)
        const progressCtx = document.getElementById('progressChart');
        
        if (progressCtx) {
            const ctx = progressCtx.getContext('2d');
            const gradient = ctx.createLinearGradient(0, 0, 0, 400);
            gradient.addColorStop(0, 'rgba(30, 58, 138, 0.15)');
            gradient.addColorStop(1, 'rgba(30, 58, 138, 0)');

            new Chart(progressCtx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                    datasets: [
                        {
                            label: 'Sertifikat Selesai',
                            data: [15, 20, 35, 35, 50, 65, 80, 95, 115, 130, 140, 160],
                            borderColor: '#22C55E',
                            backgroundColor: 'transparent',
                            borderWidth: 2,
                            pointBackgroundColor: '#22C55E',
                            pointBorderColor: '#ffffff',
                            pointBorderWidth: 2,
                            pointRadius: 4,
                            pointHoverRadius: 6,
                            tension: 0.3
                        },
                        {
                            label: 'Dalam Proses',
                            data: [30, 50, 75, 90, 110, 125, 140, 155, 175, 195, 220, 240],
                            borderColor: '#F59E0B',
                            backgroundColor: 'transparent',
                            borderWidth: 2,
                            pointBackgroundColor: '#F59E0B',
                            pointBorderColor: '#ffffff',
                            pointBorderWidth: 2,
                            pointRadius: 4,
                            pointHoverRadius: 6,
                            tension: 0.3
                        },
                        {
                            label: 'Belum Bersertifikat',
                            data: [100, 120, 165, 185, 215, 255, 280, 295, 310, 320, 340, 380],
                            borderColor: '#1E5EFF',
                            backgroundColor: gradient,
                            borderWidth: 2,
                            pointBackgroundColor: '#1E5EFF',
                            pointBorderColor: '#ffffff',
                            pointBorderWidth: 2,
                            pointRadius: 4,
                            pointHoverRadius: 6,
                            fill: true,
                            tension: 0.3
                        }
                    ]
                },
                options: { 
                    responsive: true, 
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#0f172a',
                            padding: 12,
                            titleFont: { family: 'Inter', size: 13 },
                            bodyFont: { family: 'Inter', size: 13 },
                            displayColors: true,
                            cornerRadius: 8
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { color: '#f1f5f9', drawBorder: false },
                            ticks: { font: { family: 'Inter', size: 11 }, color: '#64748b', maxTicksLimit: 6 }
                        },
                        x: {
                            grid: { display: false, drawBorder: false },
                            ticks: { font: { family: 'Inter', size: 11 }, color: '#64748b' }
                        }
                    }
                }
            });
        }

        // OPD Chart
        const opdCtx = document.getElementById('opdChart');
        if (opdCtx) {
            new Chart(opdCtx, {
                type: 'doughnut',
                data: {
                    labels: <?= json_encode(array_slice($opdLabels, 0, 5)) ?>,
                    datasets: [{
                        data: <?= json_encode(array_slice($opdValues, 0, 5)) ?>,
                        backgroundColor: <?= json_encode(array_slice($opdColors, 0, 5)) ?>,
                        borderWidth: 0,
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '70%',
                    plugins: {
                        legend: { 
                            display: false
                        },
                        tooltip: {
                            backgroundColor: '#0f172a',
                            padding: 12,
                            titleFont: { family: 'Inter', size: 13 },
                            bodyFont: { family: 'Inter', size: 13 },
                            displayColors: true,
                            cornerRadius: 8
                        }
                    }
                }
            });
        }
    });
</script>
<?= $this->endSection() ?>
