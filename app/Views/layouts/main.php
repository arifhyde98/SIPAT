<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= esc($title ?? 'SIPAT') ?></title>
    <link rel="icon" type="image/png" href="<?= esc(get_landing_logo_url()) ?>">
    <link rel="shortcut icon" type="image/png" href="<?= esc(get_landing_logo_url()) ?>">
    <link href="https://cdn.jsdelivr.net/npm/adminlte4@4.0.0-rc.6.20260104/dist/css/adminlte.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/styles/overlayscrollbars.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/datatables.net-bs5@1.13.8/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="<?= base_url('assets/css/mobile-custom.css') ?>?v=<?= time() ?>" rel="stylesheet">
    <style>
        :root {
            --lte-sidebar-width: 260px;
            --admin-primary: #1E5EFF;
            --admin-primary-dark: #1846C7;
            --admin-sidebar-bg: #0F2747;
            --admin-bg: #F8FAFC;
            --admin-card-bg: #FFFFFF;
            --admin-border: #E5E7EB;
            --admin-success: #22C55E;
            --admin-warning: #F59E0B;
            --admin-danger: #EF4444;
            --admin-info: #06B6D4;
            --admin-header-height: 64px;
            --admin-footer-height: 44px;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--admin-bg) !important;
        }

        body.admin-skin {
            background: var(--admin-bg);
        }

        .admin-header {
            background: var(--admin-card-bg);
            border-bottom: 1px solid #cbd5e1;
            border-top: 3px solid #1E5EFF;
            box-shadow: 0 4px 16px rgba(15, 23, 42, 0.06);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1035;
        }
        .admin-header .container-fluid {
            min-height: var(--admin-header-height);
            padding: 0 1.5rem;
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
        .admin-header .badge {
            color: #475569;
        }
        .admin-header .btn {
            color: #475569;
        }
        .admin-header .btn.btn-light {
            background: #f1f5f9;
            border: none;
            color: #475569;
            font-weight: 500;
            border-radius: 9999px;
            padding: 0.35rem 1rem;
            transition: all 0.2s;
        }
        .admin-header .btn.btn-light:hover {
            background: #e2e8f0;
            color: #0f172a;
        }
        .admin-header .header-title {
            font-weight: 600;
            letter-spacing: 0;
            font-size: 0.95rem;
            color: #0f172a;
            margin-left: 12px;
            margin-right: auto;
        }

        .app-sidebar.admin-sidebar {
            background: var(--admin-sidebar-bg);
            top: 0;
            border-right: none;
            box-shadow: 4px 0 24px rgba(0, 0, 0, 0.04);
        }
        .admin-sidebar .brand-link {
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            padding: 1.25rem 1rem;
        }
        .admin-sidebar .brand-text {
            color: #ffffff;
            font-weight: 700;
            letter-spacing: 0.5px;
            font-size: 1.2rem;
        }
        .admin-sidebar .nav-link {
            color: #94a3b8;
            padding: 0.75rem 1.25rem;
            margin: 0.25rem 1rem;
            border-radius: 0.75rem;
            transition: all 0.2s ease;
        }
        .admin-sidebar .nav-link .nav-icon {
            color: #94a3b8;
            font-size: 1.25rem;
            margin-right: 0.75rem;
            transition: all 0.2s ease;
        }
        .admin-sidebar .nav-link.active {
            background: var(--admin-primary);
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(30, 94, 255, 0.25);
        }
        .admin-sidebar .nav-link.active .nav-icon {
            color: #ffffff;
        }
        .admin-sidebar .nav-link:hover:not(.active) {
            background: rgba(255, 255, 255, 0.06);
            color: #f8fafc;
            transform: translateX(4px);
        }
        .admin-sidebar .nav-link:hover:not(.active) .nav-icon {
            color: #f8fafc;
        }

        .app-footer.admin-footer {
            background: var(--admin-card-bg);
            color: #64748b;
            border-top: 1px solid var(--admin-border);
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
            color: #475569;
        }

        .admin-content {
            width: 100%;
            max-width: 1600px;
            margin: 0 auto;
            padding: 0 24px;
        }
        .admin-content > :first-child {
            margin-top: 0;
        }
        .app-content {
            padding-top: 1rem;
            padding-bottom: calc(var(--admin-footer-height) + 12px);
        }
        .app-main {
            padding-top: calc(var(--admin-header-height) + 8px);
            padding-bottom: calc(var(--admin-footer-height) + 8px);
            min-height: calc(100vh - var(--admin-header-height) - var(--admin-footer-height));
            overflow-y: auto;
            -webkit-overflow-scrolling: touch;
        }
        @media (max-width: 991.98px) {
            :root {
                --lte-sidebar-width: 200px;
                --admin-header-height: 70px;
            }
            .admin-content {
                padding: 0 16px;
            }
            .app-main {
                min-height: auto;
                height: auto;
                overflow-y: visible;
                padding-top: calc(var(--admin-header-height) + 24px);
            }
        }
        @media (max-width: 767.98px) {
            :root {
                --lte-sidebar-width: 230px;
            }
            .admin-content {
                padding: 0 12px;
            }
        }
        @media (max-width: 575.98px) {
            .admin-header .badge,
            .admin-header .btn,
            .admin-header .navbar-text {
                font-size: 0.75rem;
            }
            .app-footer.admin-footer {
                position: static;
            }
            .app-content {
                padding-bottom: 1rem;
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
            font-weight: 500;
            letter-spacing: 0;
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

        .swal2-container {
            z-index: 2000 !important;
        }
        .swal2-container,
        .swal2-popup {
            pointer-events: auto;
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
        /* ── Global Page Header ── */
        .page-header-global {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }
        .page-header-global h1, .page-header-global .h4, .page-header-global .h3 {
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 3px;
        }
        .page-header-global .subtitle, .page-header-global small {
            font-size: 0.82rem;
            color: #64748b;
        }

        /* ── Global Buttons ── */
        .btn-primary {
            background: #1E5EFF;
            border-color: #1E5EFF;
            border-radius: 10px;
            font-weight: 600;
            box-shadow: 0 2px 8px rgba(30,94,255,0.15);
            transition: all 0.2s ease;
        }
        .btn-primary:hover {
            background: #1846C7;
            border-color: #1846C7;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(30,94,255,0.25);
        }
        .btn-outline-primary {
            border-radius: 10px;
            border-color: #1E5EFF;
            color: #1E5EFF;
            font-weight: 500;
            transition: all 0.2s ease;
        }
        .btn-outline-primary:hover { background: #eff6ff; transform: translateY(-1px); }
        .btn-outline-secondary {
            border-radius: 10px;
            font-weight: 500;
            transition: all 0.2s ease;
            border-color: #e2e8f0;
            color: #475569;
        }
        .btn-outline-secondary:hover { background: #f8fafc; border-color: #cbd5e1; transform: translateY(-1px); }

        /* ── Card improvements ── */
        .card {
            border-radius: 16px;
            border: 1px solid #cbd5e1;
            box-shadow: 0 2px 8px rgba(15,23,42,0.04);
            transition: box-shadow 0.2s ease;
        }

        /* ── Table premium global ── */
        .table-premium thead th {
            text-transform: uppercase;
            letter-spacing: .05em;
            font-size: 0.7rem;
            color: #64748b;
            font-weight: 600;
            background: #f8fafc;
            border-bottom: 1.5px solid #cbd5e1;
            padding: 8px 12px !important;
        }
        .table-premium tbody tr:hover td {
            background: #f0f7ff !important;
            transition: background 0.15s;
        }
        .table-premium tbody tr:nth-child(even) td {
            background-color: #fafbfc;
        }
        .table-premium tbody td {
            vertical-align: middle;
            border-bottom: 1px solid #cbd5e1;
            font-size: 0.8rem;
            color: #334155;
            padding: 8px 12px !important;
        }

        /* ── Badge global ── */
        .badge {
            font-weight: 500;
            letter-spacing: 0.02em;
        }

        /* ── Form controls global ── */
        .form-control, .form-select {
            border-radius: 10px;
            border-color: #e2e8f0;
            font-size: 0.875rem;
            transition: all 0.2s;
        }
        .form-control:focus, .form-select:focus {
            border-color: #1E5EFF;
            box-shadow: 0 0 0 3px rgba(30,94,255,0.1);
        }
        .form-label { font-weight: 500; font-size: 0.875rem; color: #374151; }

        /* ── List group polish ── */
        .list-group-item {
            border-color: #f1f5f9;
            transition: background 0.15s;
        }
        .list-group-item-action:hover {
            background: #f8fafc;
            transform: translateX(2px);
            transition: all 0.15s;
        }
    </style>
</head>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary admin-skin has-mobile-nav">
    <div class="app-wrapper">
        <nav class="app-header navbar navbar-expand admin-header p-0">
            <div class="container-fluid d-flex align-items-center justify-content-between h-100" style="min-height: var(--admin-header-height);">
                <ul class="navbar-nav d-none d-md-flex">
                    <li class="nav-item">
                        <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                            <i class="bi bi-list fs-4"></i>
                        </a>
                    </li>
                </ul>
                <div class="d-md-none d-flex align-items-center gap-2 m-0 ps-3">
                    <img src="<?= esc(get_landing_logo_url()) ?>" alt="Logo SIPAT" style="height: 32px; width: auto; object-fit: contain;">
                    <span class="fw-bold text-dark mb-0" style="letter-spacing: -0.5px; line-height: 1; padding-top: 2px; font-size: 1.15rem;">SIPAT</span>
                </div>
                <div class="header-title d-none d-md-block text-muted fw-medium">Monitoring Pensertifikatan Aset Tanah</div>
                <ul class="navbar-nav ms-auto align-items-center mb-0 pe-3 flex-row gap-1">
                    <li class="nav-item me-2 d-none d-sm-block">
                        <a href="<?= base_url('profile') ?>" class="text-decoration-none d-flex flex-column text-end">
                            <span class="text-dark fw-semibold" style="font-size: 0.85rem;"><?= esc(session()->get('user_name') ?? 'Admin') ?></span>
                            <span class="text-muted" style="font-size: 0.75rem;"><?= esc(session()->get('user_role') ?? 'Administrator') ?></span>
                        </a>
                    </li>
                    <li class="nav-item me-3">
                        <a href="<?= base_url('profile') ?>" class="text-decoration-none">
                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center shadow-sm" style="width: 38px; height: 38px; font-weight: 600; font-size: 1rem;" title="Profil Saya">
                                <?= strtoupper(substr(session()->get('user_name') ?? 'A', 0, 1)) ?>
                            </div>
                        </a>
                    </li>
                    <li class="nav-item border-start ps-3 ms-1">
                        <a href="<?= base_url('logout') ?>" class="btn btn-sm btn-light d-flex align-items-center gap-2 text-danger bg-transparent hover-bg-light">
                            <i class="bi bi-box-arrow-right"></i> <span class="d-none d-sm-inline">Logout</span>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <aside class="app-sidebar shadow admin-sidebar" data-bs-theme="dark">
            <div class="sidebar-brand d-flex align-items-center justify-content-between">
                <a href="<?= base_url('dashboard') ?>" class="brand-link flex-grow-1">
                    <img src="<?= esc(get_landing_logo_url()) ?>" alt="Logo Kabupaten Donggala" class="brand-image img-circle elevation-3" style="opacity: .9">
                    <span class="brand-text fw-light">SIPAT Admin</span>
                </a>
                <a class="text-white pe-3 d-lg-none" data-lte-toggle="sidebar" href="#" role="button" title="Sembunyikan Sidebar" style="font-size: 1.1rem; text-decoration: none; padding: 0.5rem 0.25rem;">
                    <i class="bi bi-x-lg"></i>
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
                            <li class="nav-item">
                                <a href="<?= base_url('laporan') ?>" class="nav-link <?= $is('laporan') ? 'active' : '' ?>">
                                    <i class="nav-icon bi bi-file-earmark-bar-graph"></i>
                                    <p>Laporan</p>
                                </a>
                            </li>
                        <?php endif; ?>
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
                        <?php if (in_array(session()->get('user_role'), ['Admin', 'Pengelola Aset'], true)) : ?>
                            <li class="nav-item <?= ($is('master') || $is('status')) ? 'menu-open' : '' ?>">
                                <a href="#" class="nav-link <?= ($is('master') || $is('status')) ? 'active' : '' ?>">
                                    <i class="nav-icon bi bi-database-gear"></i>
                                    <p>
                                        Master Data
                                        <i class="nav-arrow bi bi-chevron-right"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <?php if (session()->get('user_role') === 'Admin') : ?>
                                        <li class="nav-item">
                                            <a href="<?= base_url('users') ?>" class="nav-link <?= $is('users') ? 'active' : '' ?>">
                                                <i class="nav-icon bi bi-people"></i>
                                                <p>Users</p>
                                            </a>
                                        </li>
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
                                    <?php endif; ?>
                                    <li class="nav-item">
                                        <a href="<?= base_url('master/opd') ?>" class="nav-link <?= $is('master/opd') ? 'active' : '' ?>">
                                            <i class="nav-icon bi bi-buildings"></i>
                                            <p>OPD</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?= base_url('status') ?>" class="nav-link <?= $is('status') ? 'active' : '' ?>">
                                            <i class="nav-icon bi bi-tags"></i>
                                            <p>Status Proses</p>
                                        </a>
                                    </li>
                                    <?php if (session()->get('user_role') === 'Admin') : ?>
                                        <li class="nav-item">
                                            <a href="<?= base_url('master/judul-laporan') ?>" class="nav-link <?= $is('master/judul-laporan') ? 'active' : '' ?>">
                                                <i class="nav-icon bi bi-card-heading"></i>
                                                <p>Judul Laporan</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="<?= base_url('master/pengamanan') ?>" class="nav-link <?= $is('master/pengamanan') ? 'active' : '' ?>">
                                                <i class="nav-icon bi bi-shield-check"></i>
                                                <p>Master Pengamanan</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="<?= base_url('landing-settings') ?>" class="nav-link <?= $is('landing-settings') ? 'active' : '' ?>">
                                                <i class="nav-icon bi bi-brush"></i>
                                                <p>Landing Page</p>
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                    <?php if (in_array(session()->get('user_role'), ['Admin', 'Pengelola Aset'], true)) : ?>
                                        <li class="nav-item">
                                            <a href="<?= base_url('kop-settings') ?>" class="nav-link <?= $is('kop-settings') ? 'active' : '' ?>">
                                                <i class="nav-icon bi bi-file-earmark-richtext"></i>
                                                <p>Master KOP</p>
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                    <?php if (session()->get('user_role') === 'Admin') : ?>
                                        <li class="nav-item">
                                            <a href="<?= base_url('logs') ?>" class="nav-link <?= $is('logs') ? 'active' : '' ?>">
                                                <i class="nav-icon bi bi-journal-text"></i>
                                                <p>Log Aktivitas</p>
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                </ul>
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
        <!-- Mobile Bottom Navigation Bar (<768px) -->
        <nav class="mobile-bottom-nav">
            <a href="<?= base_url('dashboard') ?>" class="mobile-nav-item <?= $is('dashboard') ? 'active' : '' ?>">
                <i class="bi bi-speedometer2"></i>
                <span>Dashboard</span>
            </a>
            <a href="<?= base_url('aset') ?>" class="mobile-nav-item <?= $is('aset') ? 'active' : '' ?>">
                <i class="bi bi-building"></i>
                <span>Aset</span>
            </a>
            <?php if (in_array(session()->get('user_role'), ['Admin', 'Pengelola Aset'], true)) : ?>
                <a href="<?= base_url('aset/create') ?>" class="mobile-nav-fab" title="Tambah Aset Baru">
                    <i class="bi bi-plus-lg"></i>
                </a>
            <?php else : ?>
                <a href="<?= base_url('peta') ?>" class="mobile-nav-item <?= $is('peta') ? 'active' : '' ?>">
                    <i class="bi bi-map"></i>
                    <span>Peta</span>
                </a>
            <?php endif; ?>
            <a href="<?= base_url('peta') ?>" class="mobile-nav-item <?= $is('peta') ? 'active' : '' ?>">
                <i class="bi bi-map"></i>
                <span>Peta</span>
            </a>
            <a href="#" class="mobile-nav-item" data-lte-toggle="sidebar">
                <i class="bi bi-grid-fill"></i>
                <span>Menu</span>
            </a>
        </nav>
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
        // Auto convert modals to bottom sheets on mobile
        document.addEventListener('DOMContentLoaded', () => {
            const handleMobileModals = () => {
                const isMobile = window.innerWidth < 768;
                document.querySelectorAll('.modal').forEach(modal => {
                    if (isMobile) {
                        modal.classList.add('mobile-bottom-sheet');
                    } else {
                        modal.classList.remove('mobile-bottom-sheet');
                    }
                });
            };
            handleMobileModals();
            window.addEventListener('resize', handleMobileModals);
        });

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
            const swalContainer = document.querySelector('.swal2-container');
            const swalPopup = swalContainer ? swalContainer.querySelector('.swal2-popup') : null;
            const hasActiveSwal = swalPopup && (swalPopup.classList.contains('swal2-toast') || swalPopup.classList.contains('swal2-show'));
            document.querySelectorAll('.modal-backdrop, .sidebar-overlay').forEach((el) => {
                el.remove();
            });
            if (!hasActiveSwal && swalContainer) {
                swalContainer.remove();
            }
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
                    if (submitter && submitter.tagName === 'BUTTON') {
                        const originalHtml = submitter.innerHTML;
                        submitter.dataset.originalHtml = originalHtml;
                        submitter.classList.add('btn-loading');
                        submitter.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Memproses...';
                        submitter.disabled = true;
                    }
                    form.submit();
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
