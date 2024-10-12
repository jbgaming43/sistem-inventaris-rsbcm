<!-- Sidebar -->
<aside class="navbar navbar-vertical navbar-expand-lg" data-bs-theme="dark">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar-menu" aria-controls="sidebar-menu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <h1 class="navbar-brand navbar-brand-autodark">
            <a href=".">
                <!-- <img src="./static/logo.svg" width="110" height="32" alt="Tabler" class="navbar-brand-image"> -->
                SIIB RSBCM
            </a>
        </h1>
        <div class="navbar-nav flex-row d-lg-none">
            <div class="nav-item dropdown">
                <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown" aria-label="Open user menu">
                    <span class="avatar avatar-sm" style="background-image: url(<?= base_url('assets/avatars/') . session()->get('profile_image') ?>)"></span>
                    <div class="d-none d-xl-block ps-2">
                        <div><?= session()->get('username') ?></div>
                        <div class="mt-1 small text-muted"> <?= session()->get('level') ?></div>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <p class="dropdown-item"><?= session()->get('nama_pengguna') ?></p>
                    <div class="dropdown-divider m-0"></div>
                    <a href="<?= base_url('/logout'); ?>" class="dropdown-item">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon text-danger" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M14 8v-2a2 2 0 0 0 -2 -2h-7a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h7a2 2 0 0 0 2 -2v-2" />
                                <path d="M9 12h12l-3 -3" />
                                <path d="M18 15l3 -3" />
                            </svg>
                        </span>
                        <span class="nav-link-title text-danger">
                            Logout
                        </span>
                    </a>
                </div>
            </div>
        </div>
        <div class="collapse navbar-collapse" id="sidebar-menu">
            <ul class="navbar-nav pt-lg-3">
                <li class="nav-item <?= ($active_menu == 'dashboard') ? 'active' : ''; ?>">
                    <a class="nav-link" href="<?= base_url('/dashboard'); ?>">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <!-- Download SVG icon from http://tabler-icons.io/i/home -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M5 12l-2 0l9 -9l9 9l-2 0" />
                                <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" />
                                <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" />
                            </svg>
                        </span>
                        <span class="nav-link-title">
                            Dashboard
                        </span>
                    </a>
                </li>
                <li class="nav-item dropdown <?= ($active_menu == 'master') ? 'active' : ''; ?>">
                    <a class="nav-link dropdown-toggle" href="#navbar-layout" data-bs-toggle="dropdown" data-bs-auto-close="false" role="button" aria-expanded="true">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M3 3m0 2a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v14a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2z" />
                                <path d="M12 8.5v7" />
                                <path d="M9 10l6 4" />
                                <path d="M9 14l6 -4" />
                            </svg>
                        </span>
                        <span class="nav-link-title">
                            Master
                        </span>
                    </a>
                    <div class="dropdown-menu <?= ($active_menu == 'master') ? 'show' : ''; ?>">
                        <div class="dropdown-menu-columns">
                            <div class="dropdown-menu-column">
                                <a class="dropdown-item <?= ($active_submenu == 'pengguna') ? 'active' : ''; ?>" href="<?= base_url('/pengguna'); ?>">
                                    Data Pengguna
                                </a>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="nav-item dropdown <?= ($active_menu == 'inventaris') ? 'active' : ''; ?>">
                    <a class="nav-link dropdown-toggle" href="#navbar-layout" data-bs-toggle="dropdown" data-bs-auto-close="false" role="button" aria-expanded="true">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-building-warehouse">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M3 21v-13l9 -4l9 4v13" />
                                <path d="M13 13h4v8h-10v-6h6" />
                                <path d="M13 21v-9a1 1 0 0 0 -1 -1h-2a1 1 0 0 0 -1 1v3" />
                            </svg>
                        </span>
                        <span class="nav-link-title">
                            Inventaris
                        </span>
                    </a>
                    <div class="dropdown-menu <?= ($active_menu == 'inventaris') ? 'show' : ''; ?>">
                        <div class="dropdown-menu-columns">
                            <div class="dropdown-menu-column">
                                <a class="dropdown-item <?= ($active_submenu == 'pengajuan_inventaris') ? 'active' : ''; ?>" href="<?= base_url('/pengajuan_inventaris'); ?>">
                                    Data Pengajuan
                                </a>
                                <a class="dropdown-item <?= ($active_submenu == 'pembelian_inventaris') ? 'active' : ''; ?>" href="<?= base_url('/pembelian_inventaris'); ?>">
                                    Data Pembelian
                                </a>
                                <a class="dropdown-item <?= ($active_submenu == 'penerimaan_inventaris') ? 'active' : ''; ?>" href="<?= base_url('/penerimaan_inventaris'); ?>">
                                    Data Penerimaan
                                </a>
                                <a class="dropdown-item <?= ($active_submenu == 'pembayaran_inventaris') ? 'active' : ''; ?>" href="<?= base_url('/pembayaran_inventaris'); ?>">
                                    Data Pembayaran
                                </a>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="nav-item dropdown <?= ($active_menu == 'non_medis') ? 'active' : ''; ?>">
                    <a class="nav-link dropdown-toggle" href="#navbar-layout" data-bs-toggle="dropdown" data-bs-auto-close="false" role="button" aria-expanded="true">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-medical-cross-off">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M17.928 17.733l-.574 -.331l-3.354 -1.938v4.536a1 1 0 0 1 -1 1h-2a1 1 0 0 1 -1 -1v-4.536l-3.928 2.268a1 1 0 0 1 -1.366 -.366l-1 -1.732a1 1 0 0 1 .366 -1.366l3.927 -2.268l-3.927 -2.268a1 1 0 0 1 -.366 -1.366l1 -1.732a1 1 0 0 1 1.366 -.366l.333 .192m3.595 -.46v-2a1 1 0 0 1 1 -1h2a1 1 0 0 1 1 1v4.535l3.928 -2.267a1 1 0 0 1 1.366 .366l1 1.732a1 1 0 0 1 -.366 1.366l-3.927 2.268l3.927 2.269a1 1 0 0 1 .366 1.366l-.24 .416" />
                                <path d="M3 3l18 18" />
                            </svg>
                        </span>
                        <span class="nav-link-title">
                            Non Medis
                        </span>
                    </a>
                    <div class="dropdown-menu <?= ($active_menu == 'non_medis') ? 'show' : ''; ?>">
                        <div class="dropdown-menu-columns">
                            <div class="dropdown-menu-column">
                                <a class="dropdown-item <?= ($active_submenu == 'pengajuan_non_medis') ? 'active' : ''; ?>" href="<?= base_url('/pengajuan_non_medis'); ?>">
                                    Data Pengajuan
                                </a>
                                <a class="dropdown-item <?= ($active_submenu == 'pembelian_non_medis') ? 'active' : ''; ?>" href="<?= base_url('/pembelian_non_medis'); ?>">
                                    Data Pembelian
                                </a>
                                <a class="dropdown-item <?= ($active_submenu == 'penerimaan_non_medis') ? 'active' : ''; ?>" href="<?= base_url('/penerimaan_non_medis'); ?>">
                                    Data Penerimaan
                                </a>
                                <a class="dropdown-item <?= ($active_submenu == 'permintaan_non_medis') ? 'active' : ''; ?>" href="<?= base_url('/penerimaan_non_medis'); ?>">
                                    Data Permintaan
                                </a>
                                <a class="dropdown-item <?= ($active_submenu == 'pengeluaran_non_medis') ? 'active' : ''; ?>" href="<?= base_url('/penerimaan_non_medis'); ?>">
                                    Data Pengeluaran
                                </a>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-danger" href="<?= base_url('/logout'); ?>">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon text-danger" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M14 8v-2a2 2 0 0 0 -2 -2h-7a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h7a2 2 0 0 0 2 -2v-2" />
                                <path d="M9 12h12l-3 -3" />
                                <path d="M18 15l3 -3" />
                            </svg>
                        </span>
                        <span class="nav-link-title">
                            Logout
                        </span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</aside>
<!-- Navbar -->
<header class="navbar navbar-expand-md d-none d-lg-flex d-print-none">
    <div class="container-xl">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu" aria-controls="navbar-menu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="navbar-nav flex-row order-md-last">
            <div class="d-none d-md-flex me-3">
                <a href="?theme=dark" class="nav-link px-0 hide-theme-dark" title="Enable dark mode" data-bs-toggle="tooltip" data-bs-placement="bottom">
                    <!-- Download SVG icon from http://tabler-icons.io/i/moon -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M12 3c.132 0 .263 0 .393 0a7.5 7.5 0 0 0 7.92 12.446a9 9 0 1 1 -8.313 -12.454z" />
                    </svg>
                </a>
                <a href="?theme=light" class="nav-link px-0 hide-theme-light" title="Enable light mode" data-bs-toggle="tooltip" data-bs-placement="bottom">
                    <!-- Download SVG icon from http://tabler-icons.io/i/sun -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M12 12m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" />
                        <path d="M3 12h1m8 -9v1m8 8h1m-9 8v1m-6.4 -15.4l.7 .7m12.1 -.7l-.7 .7m0 11.4l.7 .7m-12.1 -.7l-.7 .7" />
                    </svg>
                </a>
            </div>
            <div class="nav-item dropdown">
                <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown" aria-label="Open user menu">
                    <span class="avatar avatar-sm" style="background-image: url(<?= base_url('assets/avatars/') . session()->get('profile_image') ?>)"></span>
                    <div class="d-none d-xl-block ps-2">
                        <div><?= session()->get('username') ?></div>
                        <div class="mt-1 small text-muted"> <?= session()->get('level') ?></div>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <p class="dropdown-item"><?= session()->get('nama_pengguna') ?></p>
                    <div class="dropdown-divider m-0"></div>
                    <a href="<?= base_url('/logout'); ?>" class="dropdown-item">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon text-danger" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M14 8v-2a2 2 0 0 0 -2 -2h-7a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h7a2 2 0 0 0 2 -2v-2" />
                                <path d="M9 12h12l-3 -3" />
                                <path d="M18 15l3 -3" />
                            </svg>
                        </span>
                        <span class="nav-link-title text-danger">
                            Logout
                        </span>
                    </a>
                </div>
            </div>
        </div>
        <div class="collapse navbar-collapse" id="navbar-menu">
            <!-- Tombol search -->
            <!-- <div>
                        <form action="./" method="get" autocomplete="off" novalidate>
                            <div class="input-icon">
                                <span class="input-icon-addon">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" />
                                        <path d="M21 21l-6 -6" />
                                    </svg>
                                </span>

                                <input type="text" value="" class="form-control" placeholder="Search…" aria-label="Search in website">
                            </div>
                        </form>
                    </div> -->
        </div>
    </div>
</header>