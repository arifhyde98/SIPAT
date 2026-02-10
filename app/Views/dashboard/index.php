<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<style>
    .card-stat {
        border: 1px solid #e9ecef;
        border-radius: 0.75rem;
        transition: all 0.3s ease;
        box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,.04);
        background: #fff;
    }
    .card-stat:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 1rem rgba(0,0,0,.1);
    }
    .stat-icon {
        width: 52px;
        height: 52px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        font-size: 24px;
    }
    .stat-value { font-size: 1.75rem; font-weight: 700; color: var(--gov-ink); }
    .stat-label { color: var(--gov-muted); font-size: 0.875rem; }
    .bg-primary-gradient { background: linear-gradient(135deg, #1f3a5f 0%, #3b82f6 100%); color: #fff; box-shadow: 0 4px 10px rgba(31, 58, 95, 0.2); }
    .bg-success-gradient { background: linear-gradient(135deg, #059669 0%, #34d399 100%); color: #fff; box-shadow: 0 4px 10px rgba(16, 185, 129, 0.2); }
    .bg-warning-gradient { background: linear-gradient(135deg, #d97706 0%, #fbbf24 100%); color: #fff; box-shadow: 0 4px 10px rgba(245, 158, 11, 0.2); }
    .bg-danger-gradient { background: linear-gradient(135deg, #dc2626 0%, #f87171 100%); color: #fff; box-shadow: 0 4px 10px rgba(239, 68, 68, 0.2); }
    
    .btn-gov {
        background: linear-gradient(135deg, var(--gov-primary), var(--gov-primary-2));
        color: #fff;
        border: none;
    }
    .btn-gov:hover { color: #fff; opacity: 0.9; }
    .btn-outline-gov {
        color: var(--gov-primary);
        border: 1px solid var(--gov-primary);
        background: transparent;
    }
    .btn-outline-gov:hover {
        background: rgba(31, 58, 95, 0.05);
        color: var(--gov-primary);
    }
</style>

<!-- Header Dashboard -->
<div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
    <div>
        <h1 class="h3 fw-semibold mb-0">Dashboard</h1>
        <small class="text-muted">Selamat datang kembali, <?= esc(session()->get('user_name') ?? 'Admin') ?>!</small>
    </div>
    <div class="d-flex gap-2">
        <a href="#" class="btn btn-outline-gov">
            <i class="bi bi-download me-1"></i> Laporan
        </a>
        <a href="<?= base_url('aset/new') ?>" class="btn btn-gov">
            <i class="bi bi-plus-lg me-1"></i> Aset Baru
        </a>
    </div>
</div>

<!-- Baris Kartu Statistik -->
<div class="row g-4 mb-4">
    <div class="col-md-6 col-xl-3">
        <div class="card card-stat h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="stat-icon bg-primary-gradient">
                            <i class="bi bi-archive"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h5 class="stat-value"><?= number_format($totalAset ?? 0) ?></h5>
                        <p class="stat-label mb-0">Total Aset</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card card-stat h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="stat-icon bg-success-gradient">
                            <i class="bi bi-patch-check-fill"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h5 class="stat-value"><?= number_format($asetBersertifikat ?? 0) ?></h5>
                        <p class="stat-label mb-0">Sudah Bersertifikat</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card card-stat h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="stat-icon bg-warning-gradient">
                            <i class="bi bi-hourglass-split"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h5 class="stat-value"><?= number_format($asetProses ?? 0) ?></h5>
                        <p class="stat-label mb-0">Dalam Proses</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card card-stat h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="stat-icon bg-danger-gradient">
                            <i class="bi bi-exclamation-triangle-fill"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h5 class="stat-value"><?= number_format($asetKendala ?? 0) ?></h5>
                        <p class="stat-label mb-0">Ada Kendala</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Baris Grafik dan Tabel -->
<div class="row g-4">
    <div class="col-xl-8">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white border-0 py-3">
                <h5 class="card-title mb-0 fw-semibold">Progres Aset per Bulan</h5>
            </div>
            <div class="card-body">
                <canvas id="progressChart" style="height: 300px; width: 100%;"></canvas>
            </div>
        </div>
    </div>
    <div class="col-xl-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white border-0 py-3">
                <h5 class="card-title mb-0 fw-semibold">Aset per OPD</h5>
            </div>
            <div class="card-body">
                <canvas id="opdChart" style="height: 300px; width: 100%;"></canvas>
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
            new Chart(progressCtx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'],
                    datasets: [{
                        label: 'Aset Selesai',
                        data: [12, 19, 3, 5, 2, 3],
                        borderColor: '#3b82f6',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        fill: true,
                        tension: 0.3
                    }]
                },
                options: { responsive: true, maintainAspectRatio: false }
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
                        label: 'Jumlah Aset',
                        data: <?= json_encode($opdValues) ?>,
                        backgroundColor: [
                            '#3b82f6', // Blue
                            '#10b981', // Green
                            '#f59e0b', // Amber
                            '#6366f1', // Indigo
                            '#ef4444', // Red
                            '#8b5cf6'  // Violet
                        ],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'bottom', labels: { boxWidth: 12 } }
                    }
                }
            });
        }
    });
</script>
<?= $this->endSection() ?>
