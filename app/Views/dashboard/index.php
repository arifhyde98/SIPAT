<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
    :root {
        --gov-primary: #1e3a8a; /* Navy Blue */
        --gov-primary-hover: #172554;
        --gov-secondary: #64748b;
        --gov-success: #10b981;
        --gov-warning: #f59e0b;
        --gov-danger: #ef4444;
        --gov-bg: #f8fafc;
        --gov-card-bg: #ffffff;
    }
    body {
        font-family: 'Plus Jakarta Sans', sans-serif;
        background-color: var(--gov-bg);
        color: #0f172a;
    }
    
    /* Buttons */
    .btn-gov {
        background-color: var(--gov-primary);
        color: #fff;
        border-radius: 8px;
        padding: 10px 24px;
        font-weight: 600;
        border: 1px solid transparent;
        transition: all 0.2s ease;
    }
    .btn-gov:hover {
        background-color: var(--gov-primary-hover);
        color: #fff;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(30, 58, 138, 0.2);
    }
    .btn-outline-gov {
        background-color: transparent;
        color: var(--gov-primary);
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        padding: 10px 24px;
        font-weight: 600;
        transition: all 0.2s ease;
    }
    .btn-outline-gov:hover {
        border-color: var(--gov-primary);
        background-color: #eff6ff;
        color: var(--gov-primary);
    }

    /* Cards */
    .card {
        border: none;
        border-radius: 16px;
        background: var(--gov-card-bg);
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .card-stat {
        padding: 24px;
    }
    .card-stat:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.01);
    }
    
    /* Stat Icons & Text */
    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        margin-bottom: 16px;
    }
    .icon-primary { background-color: #eff6ff; color: var(--gov-primary); }
    .icon-success { background-color: #ecfdf5; color: var(--gov-success); }
    .icon-warning { background-color: #fffbeb; color: var(--gov-warning); }
    .icon-danger { background-color: #fef2f2; color: var(--gov-danger); }

    .stat-value {
        font-size: 32px;
        font-weight: 700;
        color: #0f172a;
        line-height: 1.2;
        margin-bottom: 4px;
    }
    .stat-label {
        font-size: 14px;
        font-weight: 500;
        color: var(--gov-secondary);
    }

    /* Charts */
    .card-header {
        background: transparent;
        border-bottom: 1px solid #f1f5f9;
        padding: 20px 24px;
    }
    .card-title {
        font-size: 18px;
        font-weight: 600;
        color: #0f172a;
    }
    .chart-container {
        position: relative;
        width: 100%;
    }
</style>

    <!-- Header Dashboard -->
    <div class="d-flex justify-content-between align-items-end flex-wrap gap-3 mb-5">
        <div>
            <h1 class="h3 fw-bold mb-1">Dashboard</h1>
            <p class="text-muted mb-0">Selamat datang kembali, <?= esc(session()->get('user_name') ?? 'Admin') ?>!</p>
        </div>
        <div class="d-flex gap-3">
            <a href="#" class="btn btn-outline-gov">
                <i class="bi bi-file-earmark-text me-2"></i>Laporan
            </a>
            <a href="<?= base_url('aset/new') ?>" class="btn btn-gov">
                <i class="bi bi-plus-lg me-2"></i>Aset Baru
            </a>
        </div>
    </div>

    <!-- Baris Kartu Statistik -->
    <?php
        $statusCards = $statusCounts ?? [];
        $breakdownSertifikat = [];
        $breakdownProses = [];
        $breakdownKendala = [];

        foreach ($statusCards as $statusName => $statusTotal) {
            $name = (string) $statusName;
            $total = (int) $statusTotal;
            $normalized = strtolower($name);

            if (str_contains($normalized, 'kendala') || str_contains($normalized, 'sengketa')) {
                $breakdownKendala[$name] = $total;
            } elseif (str_contains($normalized, 'selesai ukur')) {
                $breakdownProses[$name] = $total;
            } elseif (str_contains($normalized, 'sertifikat') || str_contains($normalized, 'terbit') || str_contains($normalized, 'selesai')) {
                $breakdownSertifikat[$name] = $total;
            } else {
                $breakdownProses[$name] = $total;
            }
        }

        arsort($breakdownSertifikat);
        arsort($breakdownProses);
        arsort($breakdownKendala);

        $miniSertifikat = array_slice($breakdownSertifikat, 0, 3, true);
        $miniProses = array_slice($breakdownProses, 0, 3, true);
        $miniKendala = array_slice($breakdownKendala, 0, 3, true);
    ?>
    <div class="row g-4 mb-5">
        <div class="col-md-6 col-xl-3">
            <div class="card card-stat h-100">
                <div class="d-flex flex-column align-items-start">
                    <div class="stat-icon icon-primary">
                        <i class="bi bi-building"></i>
                    </div>
                    <div class="stat-value"><?= number_format($totalAset ?? 0) ?></div>
                    <div class="stat-label">Total Aset</div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="card card-stat h-100">
                <div class="d-flex flex-column align-items-start">
                    <div class="stat-icon icon-success">
                        <i class="bi bi-patch-check-fill"></i>
                    </div>
                    <div class="stat-value"><?= number_format($asetBersertifikat ?? 0) ?></div>
                    <div class="stat-label">Sudah Bersertifikat</div>
                    <?php if (!empty($miniSertifikat)) : ?>
                        <div class="text-muted small mt-2">
                            <?php foreach ($miniSertifikat as $name => $count) : ?>
                                <div><?= esc($name) ?>: <?= number_format((int) $count) ?></div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="card card-stat h-100">
                <div class="d-flex flex-column align-items-start">
                    <div class="stat-icon icon-warning">
                        <i class="bi bi-hourglass-split"></i>
                    </div>
                    <div class="stat-value"><?= number_format($asetProses ?? 0) ?></div>
                    <div class="stat-label">Dalam Proses</div>
                    <?php if (!empty($miniProses)) : ?>
                        <div class="text-muted small mt-2">
                            <?php foreach ($miniProses as $name => $count) : ?>
                                <div><?= esc($name) ?>: <?= number_format((int) $count) ?></div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="card card-stat h-100">
                <div class="d-flex flex-column align-items-start">
                    <div class="stat-icon icon-danger">
                        <i class="bi bi-exclamation-triangle-fill"></i>
                    </div>
                    <div class="stat-value"><?= number_format($asetKendala ?? 0) ?></div>
                    <div class="stat-label">Ada Kendala</div>
                    <?php if (!empty($miniKendala)) : ?>
                        <div class="text-muted small mt-2">
                            <?php foreach ($miniKendala as $name => $count) : ?>
                                <div><?= esc($name) ?>: <?= number_format((int) $count) ?></div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
<!-- Baris Grafik dan Tabel -->
<div class="row g-4">
    <div class="col-xl-8">
        <div class="card h-100">
            <div class="card-header">
                <h5 class="card-title mb-0">Progres Aset Bulanan</h5>
            </div>
            <div class="card-body">
                <div class="chart-container" style="height: 320px;">
                    <canvas id="progressChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4">
        <div class="card h-100">
            <div class="card-header">
                <h5 class="card-title mb-0">Distribusi per OPD</h5>
            </div>
            <div class="card-body">
                <div class="chart-container" style="height: 320px; position: relative;">
                    <canvas id="opdChart"></canvas>
                </div>
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
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'],
                    datasets: [{
                        label: 'Aset Selesai',
                        data: [12, 19, 3, 5, 2, 3],
                        borderColor: '#1e3a8a',
                        backgroundColor: gradient,
                        borderWidth: 2,
                        pointBackgroundColor: '#ffffff',
                        pointBorderColor: '#1e3a8a',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        fill: true,
                        tension: 0.3
                    }]
                },
                options: { 
                    responsive: true, 
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#1e3a8a',
                            padding: 12,
                            titleFont: { family: 'Plus Jakarta Sans', size: 13 },
                            bodyFont: { family: 'Plus Jakarta Sans', size: 13 },
                            displayColors: false,
                            cornerRadius: 8
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { color: '#f1f5f9', drawBorder: false },
                            ticks: { font: { family: 'Plus Jakarta Sans' }, color: '#64748b' }
                        },
                        x: {
                            grid: { display: false, drawBorder: false },
                            ticks: { font: { family: 'Plus Jakarta Sans' }, color: '#64748b' }
                        }
                    }
                }
            });
        }

        // OPD Chart
        const opdCtx = document.getElementById('opdChart');
        if (opdCtx) {
            <?php
                $opdLabels = isset($opdStats) ? array_keys($opdStats) : ['Dinas A', 'Dinas B', 'Lainnya'];
                $opdValues = isset($opdStats) ? array_values($opdStats) : [30, 50, 20];
            ?>
            new Chart(opdCtx, {
                type: 'doughnut',
                data: {
                    labels: <?= json_encode($opdLabels) ?>,
                    datasets: [{
                        data: <?= json_encode($opdValues) ?>,
                        backgroundColor: [
                            '#1e3a8a', // Navy
                            '#10b981', // Green
                            '#f59e0b', // Amber
                            '#ef4444', // Red
                            '#3b82f6', // Blue
                            '#6366f1'  // Indigo
                        ],
                        borderWidth: 0,
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '75%',
                    plugins: {
                        legend: { 
                            position: 'bottom', 
                            labels: { 
                                boxWidth: 10,
                                usePointStyle: true,
                                pointStyle: 'circle',
                                font: { family: 'Plus Jakarta Sans', size: 12 },
                                color: '#64748b',
                                padding: 20
                            } 
                        }
                    }
                }
            });
        }
    });
</script>
<?= $this->endSection() ?>


