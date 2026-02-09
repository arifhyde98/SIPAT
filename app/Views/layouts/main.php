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

        @media (max-width: 991.98px) {
            :root {
                --lte-sidebar-width: 200px;
            }
        }

        @media (max-width: 767.98px) {
            :root {
                --lte-sidebar-width: 0px;
            }
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
    </style>
</head>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <div class="app-wrapper">
        <nav class="app-header navbar navbar-expand bg-primary">
            <div class="container-fluid">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                            <i class="bi bi-list"></i>
                        </a>
                    </li>
                </ul>
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

        <aside class="app-sidebar shadow" data-bs-theme="dark" style="background: rgba(13, 64, 124, 0.88);">
            <div class="sidebar-brand">
                <a href="<?= base_url('dashboard') ?>" class="brand-link">
                    <img
                        src="https://upload.wikimedia.org/wikipedia/commons/thumb/e/e5/Lambang_Kabupaten_Donggala_%282015-sekarang%29.png/196px-Lambang_Kabupaten_Donggala_%282015-sekarang%29.png"
                        alt="Logo Kabupaten Donggala"
                        class="brand-image img-circle elevation-3"
                        style="opacity: .9">
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
                <div class="container-fluid py-3">
                    <?= $this->renderSection('content') ?>
                </div>
            </div>
        </main>

        <footer class="app-footer">
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
        const sipatEscape = (value) => String(value ?? '').replace(/[&<>"']/g, (c) => ({
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#39;',
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
                }
            });
        });
    </script>
    <script>
        $(function() {
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
                            columns = JSON.parse(trimmed).map(c => ({
                                data: c
                            }));
                        } catch (e) {
                            console.error('Invalid data-columns JSON:', columnsAttr, e);
                        }
                    } else {
                        columns = trimmed.split(',').map(c => c.trim()).filter(Boolean).map(c => ({
                            data: c
                        }));
                    }
                }
                const colDefs = [];
                if (hideCols.length) {
                    colDefs.push({
                        targets: hideCols,
                        visible: false,
                        searchable: true
                    });
                }
                if (columns && columns.length) {
                    colDefs.push({
                        targets: columns.length - 1,
                        orderable: false
                    });
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
                        paginate: {
                            previous: "Sebelumnya",
                            next: "Berikutnya"
                        }
                    }
                };
                if (serverSide && columns) {
                    dtOptions.columns = columns;
                }
                $table.DataTable(dtOptions);
            });
        });
    </script>
    <?= $this->renderSection('scripts') ?>
</body>

</html>
