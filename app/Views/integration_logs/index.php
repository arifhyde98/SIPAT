<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="page-header-global d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-1"><i class="bi bi-diagram-3 text-primary me-2"></i> Log Integrasi API (SIPAT ↔ eLabel)</h1>
        <div class="subtitle">Monitoring status pertukaran data dan penanganan kegagalan sinkronisasi</div>
    </div>
    <div>
        <a href="<?= base_url('integration-logs') ?>" class="btn btn-outline-primary btn-sm">
            <i class="bi bi-arrow-clockwise me-1"></i> Refresh Log
        </a>
    </div>
</div>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i><?= session()->getFlashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-2"></i><?= session()->getFlashdata('error') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-white py-3">
        <h5 class="card-title fw-bold mb-0 text-slate-800">
            <i class="bi bi-clock-history text-primary me-2"></i> Riwayat Audit Sinkronisasi API
        </h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive p-3">
            <table id="sipat-audit-log-table" class="table table-hover align-middle mb-0 w-100">
                <thead class="bg-light">
                    <tr>
                        <th style="width: 40px;" class="text-center">No</th>
                        <th style="width: 140px;">Waktu</th>
                        <th style="width: 130px;">Event</th>
                        <th>NIBAR</th>
                        <th style="width: 110px;" class="text-center">Arah</th>
                        <th style="width: 100px;" class="text-center">Status</th>
                        <th>Operator</th>
                        <th style="width: 100px;" class="text-center">Aksi Detail</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; foreach ($logs as $row): 
                        $prettyChanges = json_encode(json_decode($row['changes'] ?? '{}'), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
                    ?>
                        <tr>
                            <td class="text-center text-muted fw-bold"><?= $i++ ?></td>
                            <td class="small font-monospace"><?= esc($row['created_at'] ?? '-') ?></td>
                            <td>
                                <span class="badge bg-secondary px-2 py-1 font-monospace">
                                    <?= esc($row['event_name'] ?? '-') ?>
                                </span>
                            </td>
                            <td class="font-monospace text-primary fw-bold">
                                <?= esc($row['nibar'] ?? '-') ?>
                            </td>
                            <td class="text-center">
                                <?php if (($row['direction'] ?? '') === 'outbound'): ?>
                                    <span class="badge bg-info text-dark"><i class="bi bi-arrow-up me-1"></i> SIPAT➔eLabel</span>
                                <?php else: ?>
                                    <span class="badge bg-warning text-dark"><i class="bi bi-arrow-down me-1"></i> eLabel➔SIPAT</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <?php if (($row['sync_status'] ?? '') === 'SUCCESS'): ?>
                                    <span class="badge bg-success px-2 py-1"><i class="bi bi-check-circle me-1"></i> Sukses</span>
                                <?php elseif (($row['sync_status'] ?? '') === 'PENDING'): ?>
                                    <span class="badge bg-warning text-dark px-2 py-1"><i class="bi bi-clock me-1"></i> Pending</span>
                                <?php else: ?>
                                    <span class="badge bg-danger px-2 py-1"><i class="bi bi-exclamation-triangle me-1"></i> Gagal</span>
                                <?php endif; ?>
                            </td>
                            <td class="small text-secondary"><?= esc($row['created_by'] ?? '-') ?></td>
                            <td class="text-center">
                                <button type="button" class="btn btn-outline-info btn-xs rounded-pill btn-detail-log"
                                        data-id="<?= $row['id'] ?>"
                                        data-eventid="<?= esc($row['event_id'] ?? '-') ?>"
                                        data-reason="<?= esc($row['reason'] ?? '-') ?>"
                                        data-changes="<?= esc($prettyChanges) ?>"
                                        data-error="<?= esc($row['error_message'] ?? '') ?>">
                                    <i class="bi bi-eye me-1"></i> Detail
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php if (!empty($queues)): ?>
    <div class="card border-0 shadow-sm border-warning">
        <div class="card-header bg-warning bg-opacity-10 py-3">
            <h5 class="card-title fw-bold mb-0 text-dark">
                <i class="bi bi-arrow-repeat text-warning me-2"></i> Antrean Sinkronisasi Pending / Gagal (Retry Queue)
            </h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive p-3">
                <table class="table table-hover align-middle mb-0 w-100">
                    <thead class="bg-light">
                        <tr>
                            <th>Target URL</th>
                            <th style="width: 90px;" class="text-center">Retry</th>
                            <th style="width: 100px;" class="text-center">Status</th>
                            <th>Pesan Error Terakhir</th>
                            <th style="width: 130px;" class="text-center">Aksi Retry</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($queues as $q): ?>
                            <tr>
                                <td class="font-monospace small text-primary"><?= esc($q['target_url']) ?></td>
                                <td class="text-center fw-bold"><?= $q['retry_count'] ?> / <?= $q['max_retries'] ?></td>
                                <td class="text-center">
                                    <?php if ($q['status'] === 'DONE'): ?>
                                        <span class="badge bg-success">Selesai</span>
                                    <?php elseif ($q['status'] === 'PENDING'): ?>
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger">Gagal</span>
                                    <?php endif; ?>
                                </td>
                                <td class="small text-danger font-monospace"><?= esc($q['last_error'] ?? '-') ?></td>
                                <td class="text-center">
                                    <?php if ($q['status'] !== 'DONE'): ?>
                                        <form action="<?= base_url('integration-logs/retry/' . $q['id']) ?>" method="post">
                                            <?= csrf_field() ?>
                                            <button type="submit" class="btn btn-warning btn-sm rounded-pill shadow-sm" onclick="return confirm('Kirim ulang sinkronisasi ini?')">
                                                <i class="bi bi-arrow-clockwise me-1"></i> Sync Ulang
                                            </button>
                                        </form>
                                    <?php else: ?>
                                        <span class="text-muted small"><i class="bi bi-check-all me-1"></i> Terproses</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php endif; ?>

<!-- Single Global Modal for Detail (Outside Table) -->
<div class="modal fade" id="sipatGlobalDetailModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title fw-bold">
                    <i class="bi bi-info-circle me-2"></i> Detail Log Sinkronisasi <span id="sipat-modal-log-id"></span>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Event ID:</strong><br>
                        <span id="sipat-modal-event-id" class="font-monospace text-muted small"></span>
                    </div>
                    <div class="col-md-6">
                        <strong>Alasan / Trigger:</strong><br>
                        <span id="sipat-modal-reason" class="text-dark small"></span>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="fw-bold mb-1">Data Perubahan (JSON Payload):</label>
                    <pre id="sipat-modal-changes" class="bg-light p-3 border rounded text-dark font-monospace small" style="max-height: 220px; overflow-y: auto;"></pre>
                </div>

                <div id="sipat-modal-error-container" class="alert alert-danger mb-0" style="display: none;">
                    <strong><i class="bi bi-exclamation-octagon me-1"></i> Pesan Kesalahan (Error Trace):</strong>
                    <pre id="sipat-modal-error-text" class="mb-0 text-white font-monospace small" style="white-space: pre-wrap;"></pre>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    $(document).on('click', '.btn-detail-log', function() {
        var btn = $(this);
        $('#sipat-modal-log-id').text('#' + btn.data('id'));
        $('#sipat-modal-event-id').text(btn.data('eventid'));
        $('#sipat-modal-reason').text(btn.data('reason'));

        var changes = btn.data('changes');
        if (typeof changes === 'object') {
            changes = JSON.stringify(changes, null, 2);
        }
        $('#sipat-modal-changes').text(changes || '{}');

        var err = btn.data('error');
        if (err && err.length > 0) {
            $('#sipat-modal-error-container').show();
            $('#sipat-modal-error-text').text(err);
        } else {
            $('#sipat-modal-error-container').hide();
            $('#sipat-modal-error-text').text('');
        }

        var modalEl = document.getElementById('sipatGlobalDetailModal');
        var bsModal = new bootstrap.Modal(modalEl);
        bsModal.show();
    });
});
</script>
<?= $this->endSection() ?>
