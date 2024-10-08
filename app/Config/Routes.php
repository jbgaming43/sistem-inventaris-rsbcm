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
$routes->get('/pengajuan_non_medis', 'PengajuanNonMedisController::index');
$routes->post('/pengajuan_non_medis/add', 'PengajuanNonMedisController::add');
$routes->get('/pengajuan_non_medis/pilih_barang', 'PengajuanNonMedisController::getBarangDetails');
$routes->post('/pengajuan_non_medis/setuju/(:any)', 'PengajuanNonMedisController::setuju/$1');
$routes->post('/pengajuan_non_medis/tolak/(:any)', 'PengajuanNonMedisController::tolak/$1');
$routes->post('/pengajuan_non_medis/delete/(:any)', 'PengajuanNonMedisController::delete/$1');
$routes->get('/pengajuan_non_medis/detail/(:any)', 'PengajuanNonMedisController::detail/$1');
$routes->get('/pengajuan_non_medis/print/(:any)', 'PengajuanNonMedisController::print/$1');


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
$routes->get('/pembelian_inventaris/print/(:any)', 'PembelianInventarisController::print/$1');
$routes->get('/pembelian_inventaris/pilih_barang', 'PembelianInventarisController::getBarangDetails');

// Routes untuk mengelola data penerimaan inventaris
$routes->get('/penerimaan_inventaris', 'PenerimaanInventarisController::index');
$routes->post('/penerimaan_inventaris/add', 'PenerimaanInventarisController::add');
$routes->post('/penerimaan_inventaris/edit/(:any)', 'PenerimaanInventarisController::edit/$1');
$routes->post('/penerimaan_inventaris/delete/(:any)', 'PenerimaanInventarisController::delete/$1');
$routes->get('/penerimaan_inventaris/detail/(:any)', 'PenerimaanInventarisController::detail/$1');
$routes->get('/penerimaan_inventaris/print/(:any)', 'PenerimaanInventarisController::print/$1');
$routes->get('/penerimaan_inventaris/pilih_no_faktur', 'PenerimaanInventarisController::getFaktur');
$routes->get('/penerimaan_inventaris/info/(:any)', 'PenerimaanInventarisController::info/$1');
$routes->get('/penerimaan_inventaris/page_qr/(:any)', 'PenerimaanInventarisController::page_qr/$1');
$routes->post('/penerimaan_inventaris/add_ruang', 'PenerimaanInventarisController::add_ruang');
$routes->post('/penerimaan_inventaris/add_garansi', 'PenerimaanInventarisController::add_garansi');
$routes->get('/penerimaan_inventaris/print_qr/(:any)', 'PenerimaanInventarisController::print_qr/$1');
$routes->get('/penerimaan_inventaris/generate-qr', 'PenerimaanInventarisController::generateQR');

// Routes untuk pembayaran inventaris
$routes->get('/pembayaran_inventaris', 'PembayaranInventarisController::index');
$routes->post('/pembayaran_inventaris/add', 'PembayaranInventarisController::add');
$routes->get('/pembayaran_inventaris/delete/(:any)', 'PembayaranInventarisController::delete/$1');



