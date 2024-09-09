<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// Routes untuk mengelola auth
$routes->get('/', 'AuthController::login');
$routes->post('/login', 'AuthController::login');
$routes->get('/logout', 'AuthController::logout');

$routes->get('/dashboard', 'DashboardController::index');

// Routes untuk mengelola pengguna
$routes->get('/pengguna', 'PenggunaController::index');
$routes->post('/pengguna/add', 'PenggunaController::add');
$routes->post('/pengguna/checkUsername', 'PenggunaController::checkUsername');
$routes->post('/pengguna/edit/(:num)', 'PenggunaController::edit/$1');
$routes->post('/pengguna/delete/(:num)', 'PenggunaController::delete/$1');

// Routes untuk mengelola data pengajuan non-medis
$routes->get('/pengajuan_nonmedis', 'PengajuanNonMedisController::index');
$routes->post('/pengguna/add', 'PengajuanNonMedisController::add');
$routes->post('/pengguna/edit/(:num)', 'PengajuanNonMedisController::edit/$1');
$routes->post('/pengguna/delete/(:num)', 'PengajuanNonMedisController::delete/$1');

// Routes untuk mengelola data pengajuan inventaris
$routes->get('/pengajuan_inventaris', 'PengajuanInventarisController::index');
$routes->post('/pengajuan_inventaris/add', 'PengajuanInventarisController::add');
$routes->post('/pengajuan_inventaris/edit/(:num)', 'PengajuanInventarisController::edit/$1');
$routes->post('/pengajuan_inventaris/delete/(:num)', 'PengajuanInventarisController::delete/$1');
$routes->post('/pengajuan_inventaris/setuju/(:num)', 'PengajuanInventarisController::setuju/$1');
$routes->post('/pengajuan_inventaris/tolak/(:num)', 'PengajuanInventarisController::tolak/$1');
$routes->post('/pengajuan_inventaris/print', 'PengajuanInventarisController::print');

// Routes untuk mengelola data pembelian inventaris
$routes->get('/pembelian_inventaris', 'PembelianInventarisController::index');
$routes->post('/pembelian_inventaris/add', 'PembelianInventarisController::add');
$routes->post('/pembelian_inventaris/edit/(:any)', 'PembelianInventarisController::edit/$1');
$routes->post('/pembelian_inventaris/delete/(:any)', 'PembelianInventarisController::delete/$1');
$routes->get('/pembelian_inventaris/detail/(:any)', 'PembelianInventarisController::detail/$1');
$routes->post('/pembelian_inventaris/setuju/(:num)', 'PembelianInventarisController::setuju/$1');
$routes->post('/pembelian_inventaris/tolak/(:num)', 'PembelianInventarisController::tolak/$1');
$routes->post('/pembelian_inventaris/print', 'PembelianInventarisController::print');
$routes->get('/pembelian_inventaris/pilih_barang', 'PembelianInventarisController::getBarangDetails');