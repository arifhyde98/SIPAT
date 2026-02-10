<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= esc($title ?? 'SIPAT') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/adminlte4@4.0.0-rc.6.20260104/dist/css/adminlte.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/styles/overlayscrollbars.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/datatables.net-bs5@1.13.8/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <style>
        :root {
            --lte-sidebar-width: 230px;
            --admin-blue: #0b4f84;
            --admin-blue-dark: #083d67;
            --admin-gold: #f0b429;
            --admin-header-height: 56px;
            --admin-footer-height: 44px;
        }

        body.admin-skin {
            background: #eef2f6;
        }

        .admin-header {
            background: var(--admin-blue);
            border-bottom: 3px solid var(--admin-gold);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1035;
        }
        .admin-header .container-fluid {
            min-height: var(--admin-header-height);
        }
        @media (min-width: 992px) {
            .admin-header {
                left: var(--lte-sidebar-width);
            }
            body.sidebar-collapse .admin-header {
                left: 0;
            }
        }
        .admin-header .nav-link,
        .admin-header .navbar-text,
        .admin-header .btn,
        .admin-header .badge {
            color: #fff;
        }
        .admin-header .btn.btn-light {
            color: var(--admin-blue-dark);
        }
        .admin-header .header-title {
            font-weight: 700;
            letter-spacing: 0.3px;
            text-transform: uppercase;
            font-size: 0.85rem;
            color: rgba(255, 255, 255, 0.9);
            margin-left: 12px;
            margin-right: auto;
        }

        .app-sidebar.admin-sidebar {
            background: var(--admin-blue-dark);
            top: 0;
        }
        .admin-sidebar .brand-link {
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }
        .admin-sidebar .brand-text {
            color: #fff;
            font-weight: 600;
        }
        .admin-sidebar .nav-link {
            color: rgba(255, 255, 255, 0.9);
        }
        .admin-sidebar .nav-link .nav-icon {
            color: rgba(255, 255, 255, 0.9);
        }
        .admin-sidebar .nav-link.active {
            background: rgba(255, 255, 255, 0.15);
            color: #fff;
        }
        .admin-sidebar .nav-link:hover {
            background: rgba(255, 255, 255, 0.08);
        }

        .app-footer.admin-footer {
            background: var(--admin-blue-dark);
            color: #fff;
            border-top: 3px solid var(--admin-gold);
            position: fixed;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 1035;
        }
        @media (min-width: 992px) {
            .app-footer.admin-footer {
                left: var(--lte-sidebar-width);
            }
            body.sidebar-collapse .app-footer.admin-footer {
                left: 0;
            }
        }
        .app-footer.admin-footer strong,
        .app-footer.admin-footer .float-end {
            color: #fff;
        }

        .admin-content {
            width: 100%;
            max-width: none;
            margin: 0;
            padding: 0 24px;
        }
        .admin-content > :first-child {
            margin-top: 0;
        }
        .app-content {
            padding-top: 1rem;
        }
        .app-main {
            padding-top: calc(var(--admin-header-height) + 8px);
            padding-bottom: calc(var(--admin-footer-height) + 8px);
            height: calc(100vh - var(--admin-header-height) - var(--admin-footer-height));
            overflow: hidden;
        }
        @media (max-width: 991.98px) {
            :root {
                --lte-sidebar-width: 200px;
            }
            .admin-content {
                padding: 0 16px;
            }
        }
        @media (max-width: 767.98px) {
            :root {
                --lte-sidebar-width: 0px;
            }
        }

        .modal-modern .modal-content {
            border: 0;
            border-radius: 18px;
            box-shadow: 0 24px 50px rgba(15, 23, 42, 0.18);
        }
        .modal-modern .modal-header {
            border-bottom: 0;
            background: linear-gradient(135deg, rgba(13, 110, 253, 0.12), rgba(255, 255, 255, 0.9));
            padding: 18px 22px;
        }
        .modal-modern .modal-title {
            font-weight: 700;
        }
        .modal-modern .modal-body {
            padding: 18px 22px 6px;
        }
        .modal-modern .modal-footer {
            border-top: 0;
            padding: 10px 22px 18px;
        }

        .card.fancy-card {
            transition: transform .2s ease, box-shadow .2s ease;
            box-shadow: 0 8px 22px rgba(15, 23, 42, 0.08);
        }
        .card.fancy-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 28px rgba(15, 23, 42, 0.12);
        }
        .table-premium thead th {
            text-transform: uppercase;
            letter-spacing: .04em;
            font-size: .72rem;
            color: #64748b;
        }
        .table-premium tbody tr:hover {
            background: rgba(59, 130, 246, 0.05);
        }
        .chip-soft {
            display: inline-flex;
            align-items: center;
            gap: .35rem;
            padding: .15rem .6rem;
            border-radius: 999px;
            background: rgba(59, 130, 246, 0.12);
            color: #1d4ed8;
            font-weight: 600;
            font-size: .75rem;
        }
        .btn-xs {
            --bs-btn-padding-y: 0.15rem;
            --bs-btn-padding-x: 0.45rem;
            --bs-btn-font-size: 0.7rem;
            --bs-btn-border-radius: 0.4rem;
        }

        .app-sidebar .nav-link p {
            font-weight: 700;
            letter-spacing: 0.2px;
        }
        .app-sidebar .nav-link.active {
            background: rgba(255, 255, 255, 0.18);
            border-radius: 0.5rem;
        }
        .app-sidebar .nav-link.active .nav-icon,
        .app-sidebar .nav-link.active p {
            color: #fff;
        }

        body:not(.sidebar-open) .sidebar-overlay {
            display: none !important;
        }

        .nav-link,
        .btn,
        .card {
            transition: all .2s ease;
        }
        .btn:active {
            transform: translateY(1px);
        }
        .btn-loading {
            pointer-events: none;
            opacity: 0.85;
        }
        .btn-loading .spinner-border {
            width: 1rem;
            height: 1rem;
            margin-right: 0.4rem;
        }

        .empty-state {
            padding: 24px;
            text-align: center;
            color: #64748b;
            border: 1px dashed rgba(15, 23, 42, 0.15);
            border-radius: 12px;
            background: #fff;
        }

        .row-highlight {
            animation: rowFlash 2.4s ease-out 1;
            background-color: rgba(255, 193, 7, 0.2) !important;
        }
        @keyframes rowFlash {
            0% { background-color: rgba(255, 193, 7, 0.35); }
            100% { background-color: transparent; }
        }

        .table-loading tbody td {
            position: relative;
            color: transparent;
        }
        .table-loading tbody td::after {
            content: "";
            position: absolute;
            left: 8px;
            right: 8px;
            top: 50%;
            height: 12px;
            transform: translateY(-50%);
            border-radius: 6px;
            background: linear-gradient(90deg, #f1f5f9 25%, #e2e8f0 37%, #f1f5f9 63%);
            background-size: 400% 100%;
            animation: shimmer 1.2s ease-in-out infinite;
        }
        @keyframes shimmer {
            0% { background-position: 100% 0; }
            100% { background-position: -100% 0; }
        }

        .table-responsive {
            max-height: calc(100vh - var(--admin-header-height) - var(--admin-footer-height) - 220px);
            overflow: auto;
        }

        .table-responsive thead th,
        .table-premium thead th,
        .aset-table thead th {
            position: sticky;
            top: 0;
            z-index: 2;
            background: #ffffff;
            background-clip: padding-box;
        }
    </style>
</head>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary admin-skin">
    <div class="app-wrapper">
        <nav class="app-header navbar navbar-expand admin-header">
            <div class="container-fluid">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                            <i class="bi bi-list"></i>
                        </a>
                    </li>
                </ul>
                <div class="header-title d-none d-md-block">ANDA SEDANG LOGIN SIPAT DONGGALA 2026</div>
                <ul class="navbar-nav ms-auto text-white">
                    <li class="nav-item me-2">
                        <span class="badge text-bg-light text-primary"><?= esc(session()->get('user_role') ?? 'Guest') ?></span>
                    </li>
                    <li class="nav-item me-3">
                        <span class="text-white small"><?= esc(session()->get('user_name') ?? '') ?></span>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('logout') ?>" class="btn btn-sm btn-light">Logout</a>
                    </li>
                </ul>
            </div>
        </nav>

        <aside class="app-sidebar shadow admin-sidebar" data-bs-theme="dark">
            <div class="sidebar-brand">
                <a href="<?= base_url('dashboard') ?>" class="brand-link">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/e/e5/Lambang_Kabupaten_Donggala_%282015-sekarang%29.png/196px-Lambang_Kabupaten_Donggala_%282015-sekarang%29.png" alt="Logo Kabupaten Donggala" class="brand-image img-circle elevation-3" style="opacity: .9">
                    <span class="brand-text fw-light">SIPAT Admin</span>
                </a>
            </div>
            <div class="sidebar-wrapper">
                <?php
                $path = trim(service('uri')->getPath(), '/');
                $is = static function (string $prefix) use ($path): bool {
                    if ($prefix === '') {
                        return $path === '' || $path === 'dashboard';
                    }
                    return $path === $prefix || str_starts_with($path, $prefix . '/');
                };
                ?>
                <nav class="mt-2">
                    <ul class="nav sidebar-menu flex-column" role="menu" data-lte-toggle="treeview" data-accordion="false">
                        <li class="nav-item">
                            <a href="<?= base_url('dashboard') ?>" class="nav-link <?= $is('dashboard') ? 'active' : '' ?>">
                                <i class="nav-icon bi bi-speedometer2"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('aset') ?>" class="nav-link <?= $is('aset') ? 'active' : '' ?>">
                                <i class="nav-icon bi bi-building"></i>
                                <p>Aset Tanah</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('peta') ?>" class="nav-link <?= $is('peta') ? 'active' : '' ?>">
                                <i class="nav-icon bi bi-map"></i>
                                <p>Peta Aset</p>
                            </a>
                        </li>
                        <?php if (in_array(session()->get('user_role'), ['Admin', 'Pengelola Aset'], true)) : ?>
                            <li class="nav-item <?= $is('surat') ? 'menu-open' : '' ?>">
                                <a href="#" class="nav-link <?= $is('surat') ? 'active' : '' ?>">
                                    <i class="nav-icon bi bi-file-earmark-text"></i>
                                    <p>
                                        Surat Tanah
                                        <i class="nav-arrow bi bi-chevron-right"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="<?= base_url('surat/skpt') ?>" class="nav-link <?= $is('surat/skpt') ? 'active' : '' ?>">
                                            <i class="nav-icon bi bi-file-text"></i>
                                            <p>SKPT</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?= base_url('surat/pernyataan-batas') ?>" class="nav-link <?= $is('surat/pernyataan-batas') ? 'active' : '' ?>">
                                            <i class="nav-icon bi bi-file-ruled"></i>
                                            <p>Pernyataan Batas</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        <?php endif; ?>
                        <?php if (in_array(session()->get('user_role'), ['Admin', 'Pengelola Aset'], true)) : ?>
                            <li class="nav-item">
                                <a href="<?= base_url('aset/import') ?>" class="nav-link <?= $is('aset/import') ? 'active' : '' ?>">
                                    <i class="nav-icon bi bi-upload"></i>
                                    <p>Import Aset</p>
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if (session()->get('user_role') === 'Admin') : ?>
                            <li class="nav-item">
                                <a href="<?= base_url('users') ?>" class="nav-link <?= $is('users') ? 'active' : '' ?>">
                                    <i class="nav-icon bi bi-people"></i>
                                    <p>Users</p>
                                </a>
                            </li>
                            <li class="nav-item <?= $is('master') ? 'menu-open' : '' ?>">
                                <a href="#" class="nav-link <?= $is('master') ? 'active' : '' ?>">
                                    <i class="nav-icon bi bi-database-gear"></i>
                                    <p>
                                        Master Data
                                        <i class="nav-arrow bi bi-chevron-right"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="<?= base_url('master/kecamatan') ?>" class="nav-link <?= $is('master/kecamatan') ? 'active' : '' ?>">
                                            <i class="nav-icon bi bi-geo"></i>
                                            <p>Kecamatan</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?= base_url('master/desa') ?>" class="nav-link <?= $is('master/desa') ? 'active' : '' ?>">
                                            <i class="nav-icon bi bi-geo-alt"></i>
                                            <p>Desa</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?= base_url('master/kepala-desa') ?>" class="nav-link <?= $is('master/kepala-desa') ? 'active' : '' ?>">
                                            <i class="nav-icon bi bi-person-badge"></i>
                                            <p>Kepala Desa</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?= base_url('master/camat') ?>" class="nav-link <?= $is('master/camat') ? 'active' : '' ?>">
                                            <i class="nav-icon bi bi-person-lines-fill"></i>
                                            <p>Camat</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?= base_url('master/pemohon') ?>" class="nav-link <?= $is('master/pemohon') ? 'active' : '' ?>">
                                            <i class="nav-icon bi bi-person-vcard"></i>
                                            <p>Pemohon</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a href="<?= base_url('status') ?>" class="nav-link <?= $is('status') ? 'active' : '' ?>">
                                    <i class="nav-icon bi bi-tags"></i>
                                    <p>Status Proses</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= base_url('landing-settings') ?>" class="nav-link <?= $is('landing-settings') ? 'active' : '' ?>">
                                    <i class="nav-icon bi bi-brush"></i>
                                    <p>Landing Page</p>
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </nav>
            </div>
        </aside>

        <main class="app-main">
            <div class="app-content">
                <div class="container-fluid admin-content pb-3">
                    <?= $this->renderSection('content') ?>
                </div>
            </div>
        </main>

        <footer class="app-footer admin-footer">
            <div class="float-end d-none d-sm-inline">SIPAT</div>
            <strong>Monitoring Pensertifikatan Tanah</strong>
        </footer>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/browser/overlayscrollbars.browser.es6.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/adminlte4@4.0.0-rc.6.20260104/dist/js/adminlte.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/datatables.net@1.13.8/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/datatables.net-bs5@1.13.8/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        const sipatHighlightRow = (highlight) => {
            if (!highlight) return false;
            const selector = `[data-row-id="${highlight}"], [data-id="${highlight}"], #row-${highlight}`;
            const row = document.querySelector(selector);
            if (row) {
                row.classList.add('row-highlight');
                return true;
            }
            return false;
        };

        const sipatGetHighlightParam = () => {
            const params = new URLSearchParams(window.location.search);
            return params.get('highlight') || '';
        };

        const sipatCleanupOverlays = () => {
            const hasOpenModal = document.querySelector('.modal.show');
            if (hasOpenModal) return;
            document.querySelectorAll('.modal-backdrop, .swal2-container, .sidebar-overlay').forEach((el) => {
                el.remove();
            });
            document.body.classList.remove('modal-open');
            document.body.style.removeProperty('padding-right');
        };

        const sipatEscape = (value) => String(value ?? '').replace(/[&<>"']/g, (c) => ({
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#39;'
        })[c]);

        const sipatToast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
        });

        <?php $successMessage = session()->getFlashdata('success'); ?>
        <?php if (!empty($successMessage)) : ?>
        sipatToast.fire({
            icon: 'success',
            title: sipatEscape(<?= json_encode($successMessage, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT) ?>),
        });
        <?php endif; ?>

        <?php
        $errorList = session()->getFlashdata('errors');
        if (empty($errorList)) {
            $errorList = session('errors');
        }
        $errorList = is_array($errorList) ? array_values($errorList) : [];
        ?>
        <?php if (!empty($errorList)) : ?>
        (function () {
            const errors = <?= json_encode($errorList, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT) ?>;
            const items = errors.map(err => `<li>${sipatEscape(err)}</li>`).join('');
            Swal.fire({
                icon: 'error',
                title: 'Terjadi Kesalahan',
                html: `<ul style="text-align:left;margin:0;padding-left:18px;">${items}</ul>`,
            });
        })();
        <?php endif; ?>

        document.addEventListener('submit', function (event) {
            const form = event.target;
            const submitter = event.submitter;
            const message = (submitter && submitter.dataset.confirm) || form.dataset.confirm;
            if (submitter && submitter.tagName === 'BUTTON') {
                const originalHtml = submitter.innerHTML;
                submitter.dataset.originalHtml = originalHtml;
                submitter.classList.add('btn-loading');
                submitter.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Memproses...';
                submitter.disabled = true;
            }
            if (!message) return;
            event.preventDefault();
            Swal.fire({
                icon: 'warning',
                title: 'Konfirmasi',
                text: message,
                showCancelButton: true,
                confirmButtonText: 'Ya, lanjut',
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                } else if (submitter && submitter.tagName === 'BUTTON') {
                    submitter.classList.remove('btn-loading');
                    if (submitter.dataset.originalHtml) {
                        submitter.innerHTML = submitter.dataset.originalHtml;
                    }
                    submitter.disabled = false;
                }
            });
        });

        document.addEventListener('DOMContentLoaded', sipatCleanupOverlays);
    </script>
    <script>
        $(function() {
            const highlightValue = sipatGetHighlightParam();
            if (highlightValue) {
                sipatHighlightRow(highlightValue);
            }
            $('.js-datatable').each(function() {
                const $table = $(this);
                const hideColsAttr = $table.data('hide-cols');
                const hideCols = hideColsAttr !== undefined ?
                    hideColsAttr.toString().split(',').map(v => parseInt(v.trim(), 10)).filter(v => !Number.isNaN(v)) :
                    [];
                const serverSide = $table.data('server') === true || $table.data('server') === 'true';
                const source = $table.data('source');
                const columnsAttr = $table.attr('data-columns');
                let columns = null;
                if (columnsAttr && columnsAttr.trim().length > 0) {
                    const trimmed = columnsAttr.trim();
                    if (trimmed.startsWith('[')) {
                        try {
                            columns = JSON.parse(trimmed).map(c => ({ data: c }));
                        } catch (e) {
                            console.error('Invalid data-columns JSON:', columnsAttr, e);
                        }
                    } else {
                        columns = trimmed.split(',').map(c => c.trim()).filter(Boolean).map(c => ({ data: c }));
                    }
                }
                const colDefs = [];
                if (hideCols.length) {
                    colDefs.push({ targets: hideCols, visible: false, searchable: true });
                }
                if (columns && columns.length) {
                    colDefs.push({ targets: columns.length - 1, orderable: false });
                }

                if ($.fn.dataTable.isDataTable($table)) {
                    $table.DataTable().clear().destroy();
                }

                const dtOptions = {
                    processing: serverSide,
                    serverSide: serverSide,
                    ajax: serverSide && source ? {
                        url: source,
                        dataSrc: 'data',
                        error: function(xhr) {
                            console.error('DataTables AJAX error:', xhr.status, xhr.responseText);
                        }
                    } : undefined,
                    pageLength: 10,
                    lengthMenu: [10, 25, 50, 100],
                    columnDefs: colDefs,
                    language: {
                        search: "Cari:",
                        lengthMenu: "Tampilkan _MENU_ data",
                        info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
                        infoEmpty: "Tidak ada data",
                        zeroRecords: "Data tidak ditemukan",
                        paginate: { previous: "Sebelumnya", next: "Berikutnya" }
                    }
                };
                if (serverSide && columns) {
                    dtOptions.columns = columns;
                }
                const dt = $table.DataTable(dtOptions);
                const setLoading = (isLoading) => $table.toggleClass('table-loading', !!isLoading);
                setLoading(false);
                $table.on('processing.dt', function (e, settings, processing) {
                    setLoading(processing);
                });
                if (serverSide) {
                    setLoading(true);
                    dt.one('draw.dt', function () { setLoading(false); });
                }
                $table.on('draw.dt', function () {
                    if (highlightValue && sipatHighlightRow(highlightValue)) {
                        $table.off('draw.dt');
                    }
                });
            });
        });
    </script>
    <?= $this->renderSection('scripts') ?>
</body>
</html>
