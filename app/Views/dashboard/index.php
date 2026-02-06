<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h4 fw-semibold mb-1">Dashboard</h1>
        <small class="text-muted">Ringkasan progres pensertifikatan</small>
    </div>
</div>

<?php
    $gradients = [
        ['#2563eb', '#60a5fa', 'bi-collection'],
        ['#16a34a', '#4ade80', 'bi-shield-check'],
        ['#f59e0b', '#fbbf24', 'bi-clock-history'],
        ['#ef4444', '#f97316', 'bi-exclamation-triangle'],
        ['#8b5cf6', '#a78bfa', 'bi-flag'],
        ['#0ea5e9', '#38bdf8', 'bi-graph-up'],
        ['#14b8a6', '#5eead4', 'bi-diagram-3'],
        ['#64748b', '#94a3b8', 'bi-layers'],
    ];
    $i = 0;
?>
<div class="row g-3 mb-4">
    <?php foreach ($statusCounts as $status => $jumlah) : ?>
        <?php $g = $gradients[$i % count($gradients)]; $i++; ?>
        <div class="col-md-3">
            <div class="card text-white fancy-card" style="background: linear-gradient(135deg, <?= $g[0] ?>, <?= $g[1] ?>); border: 0;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-white-50 small"><?= esc($status) ?></div>
                            <div class="h3 fw-bold mb-0"><?= esc($jumlah) ?></div>
                        </div>
                        <i class="bi <?= $g[2] ?> fs-1 text-white-50"></i>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<div class="card border-0 fancy-card" style="background: rgba(59, 130, 246, 0.06);">
    <div class="card-header border-0" style="background: transparent;">
        <h3 class="card-title text-primary mb-0">
            <i class="bi bi-bar-chart me-2"></i> Progres per OPD
        </h3>
    </div>
    <div class="card-body">
        <?php if (empty($opdStats)) : ?>
            <p class="text-muted mb-0">Belum ada data OPD.</p>
        <?php else : ?>
            <div class="table-responsive">
                <table class="table align-middle mb-0 table-premium">
                    <thead>
                        <tr>
                            <th>OPD</th>
                            <th>Jumlah Aset</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($opdStats as $opd => $jumlah) : ?>
                            <tr>
                                <td><?= esc($opd) ?></td>
                                <td><?= esc($jumlah) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<div class="card mt-4 border-0 fancy-card" style="background: rgba(16, 185, 129, 0.06);">
    <div class="card-header border-0" style="background: transparent;">
        <h3 class="card-title text-success mb-0">
            <i class="bi bi-pie-chart me-2"></i> Rekap Jumlah Aset per Status Proses
        </h3>
    </div>
    <div class="card-body">
        <?php if (empty($statusCounts)) : ?>
            <p class="text-muted mb-0">Belum ada data status.</p>
        <?php else : ?>
            <div style="height: 120px; max-width: 420px;">
                <canvas id="statusChart" class="mb-3"></canvas>
            </div>
            <div class="table-responsive">
                <table class="table align-middle mb-0 table-premium">
                    <thead>
                        <tr>
                            <th>Status</th>
                            <th>Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($statusCounts as $status => $jumlah) : ?>
                            <tr>
                                <td><?= esc($status) ?></td>
                                <td><span class="chip-soft"><?= esc($jumlah) ?></span></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>
<?= $this->endSection() ?>

<?php if (!empty($statusCounts)) : ?>
    <?= $this->section('scripts') ?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('statusChart');
            if (!ctx || typeof Chart === 'undefined') return;
            const labels = <?= json_encode(array_keys($statusCounts)) ?>;
            const data = <?= json_encode(array_values($statusCounts)) ?>;
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels,
                    datasets: [{
                        label: 'Jumlah Aset',
                        data,
                        backgroundColor: [
                            'rgba(37, 99, 235, 0.6)',
                            'rgba(16, 185, 129, 0.6)',
                            'rgba(245, 158, 11, 0.6)',
                            'rgba(239, 68, 68, 0.6)',
                            'rgba(139, 92, 246, 0.6)',
                            'rgba(14, 165, 233, 0.6)'
                        ],
                        borderRadius: 8
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    animation: false,
                    plugins: { legend: { display: false } },
                    scales: { y: { beginAtZero: true } }
                }
            });
        });
    </script>
    <?= $this->endSection() ?>
<?php endif; ?>
