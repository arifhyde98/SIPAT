<?php
$oldData = json_decode($log['old_data'] ?? '', true) ?: [];
$newData = json_decode($log['new_data'] ?? '', true) ?: [];

// Get all unique keys
$allKeys = array_unique(array_merge(array_keys($oldData), array_keys($newData)));
sort($allKeys);

// Filter keys that actually changed
$changes = [];
foreach ($allKeys as $key) {
    $oldVal = $oldData[$key] ?? null;
    $newVal = $newData[$key] ?? null;
    
    // Normalize values for comparison (handles null, empty arrays, objects)
    $oldNormalized = is_array($oldVal) ? json_encode($oldVal) : (string)$oldVal;
    $newNormalized = is_array($newVal) ? json_encode($newVal) : (string)$newVal;

    if ($oldNormalized !== $newNormalized) {
        $changes[$key] = [
            'old' => $oldVal,
            'new' => $newVal,
            'type' => (!isset($oldData[$key]) ? 'added' : (!isset($newData[$key]) ? 'deleted' : 'modified'))
        ];
    }
}
?>

<div class="modal-header">
    <div>
        <h5 class="modal-title" id="modalLogDetailLabel">Detail Log Aktivitas #<?= esc($log['id']) ?></h5>
        <small class="text-muted">Aksi dicatat pada <?= esc(date('d F Y H:i:s', strtotime($log['created_at']))) ?></small>
    </div>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body p-4">
    <!-- Meta Info Section -->
    <div class="row g-3 mb-4">
        <div class="col-md-6">
            <div class="card bg-light border-0 shadow-none h-100">
                <div class="card-body p-3">
                    <span class="text-secondary small fw-semibold d-block mb-1">PENGGUNA</span>
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px; font-size: 0.85rem; font-weight: 600;">
                            <?= strtoupper(substr($log['user_name'] ?? 'S', 0, 1)) ?>
                        </div>
                        <div>
                            <span class="d-block fw-semibold text-dark"><?= esc($log['user_name'] ?? 'Sistem / Tamu') ?></span>
                            <?php if ($log['user_email']): ?>
                                <small class="text-muted font-monospace" style="font-size: 0.75rem;"><?= esc($log['user_email']) ?></small>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card bg-light border-0 shadow-none h-100">
                <div class="card-body p-3">
                    <span class="text-secondary small fw-semibold d-block mb-1">KONEKSI & PERANGKAT</span>
                    <span class="d-block text-dark small"><strong>IP Address:</strong> <span class="font-monospace"><?= esc($log['ip_address'] ?? '-') ?></span></span>
                    <span class="d-block text-muted small text-truncate" title="<?= esc($log['user_agent']) ?>">
                        <strong>User Agent:</strong> <?= esc($log['user_agent'] ?? '-') ?>
                    </span>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-light border-0 shadow-none">
                <div class="card-body p-3">
                    <span class="text-secondary small fw-semibold d-block mb-1">AKSI</span>
                    <span class="fw-bold text-uppercase text-primary"><?= esc($log['action']) ?></span>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-light border-0 shadow-none">
                <div class="card-body p-3">
                    <span class="text-secondary small fw-semibold d-block mb-1">ENTITAS DATA</span>
                    <code class="text-primary font-monospace" style="font-size: 0.9rem;"><?= esc($log['entity']) ?></code>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-light border-0 shadow-none">
                <div class="card-body p-3">
                    <span class="text-secondary small fw-semibold d-block mb-1">TARGET ID</span>
                    <span class="font-monospace fw-semibold text-dark"><?= esc($log['entity_id'] ?? '-') ?></span>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Comparison Section -->
    <h6 class="fw-semibold text-dark mb-3">
        Perubahan Data 
        <span class="badge bg-secondary font-monospace" style="font-size: 0.72rem;"><?= count($changes) ?> field berubah</span>
    </h6>

    <?php if (empty($changes)) : ?>
        <div class="alert alert-light border text-center p-4">
            <i class="bi bi-info-circle text-muted fs-3 mb-2 d-block"></i>
            <span class="text-secondary">Tidak ada detail field data yang mengalami perubahan.</span>
        </div>
    <?php else : ?>
        <div class="table-responsive border rounded-3">
            <table class="table align-middle mb-0" style="font-size: 0.85rem;">
                <thead class="table-light">
                    <tr>
                        <th style="width: 25%;">Nama Field</th>
                        <th style="width: 37%;">Data Lama</th>
                        <th style="width: 38%;">Data Baru</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($changes as $field => $change) : ?>
                        <?php 
                        $rowClass = '';
                        if ($change['type'] === 'added') {
                            $rowClass = 'table-success-subtle';
                        } elseif ($change['type'] === 'deleted') {
                            $rowClass = 'table-danger-subtle';
                        }
                        ?>
                        <tr class="<?= $rowClass ?>">
                            <td class="fw-bold font-monospace text-dark"><?= esc($field) ?></td>
                            <td>
                                <?php if ($change['type'] === 'added'): ?>
                                    <span class="text-muted fst-italic">[Baru Dibuat]</span>
                                <?php else: ?>
                                    <div class="text-break bg-light p-2 rounded border font-monospace text-secondary" style="font-size: 0.78rem; max-height: 120px; overflow-y: auto;">
                                        <?php if (is_array($change['old'])): ?>
                                            <pre class="m-0"><?= esc(json_encode($change['old'], JSON_PRETTY_PRINT)) ?></pre>
                                        <?php else: ?>
                                            <?= esc($change['old']) ?>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($change['type'] === 'deleted'): ?>
                                    <span class="text-muted fst-italic">[Dihapus]</span>
                                <?php else: ?>
                                    <div class="text-break bg-light p-2 rounded border font-monospace text-dark" style="font-size: 0.78rem; max-height: 120px; overflow-y: auto;">
                                        <?php if (is_array($change['new'])): ?>
                                            <pre class="m-0"><?= esc(json_encode($change['new'], JSON_PRETTY_PRINT)) ?></pre>
                                        <?php else: ?>
                                            <?= esc($change['new']) ?>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">Tutup</button>
</div>
