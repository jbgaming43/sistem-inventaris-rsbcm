<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// Routes untuk mengelola AUTH
$routes->get('/', 'AuthController::login');
$routes->post('/login', 'AuthController::login');
$routes->get('/logout', 'AuthController::logout');

$routes->get('/dashboard', 'DashboardController::index');

// Routes untuk mengelola PENGGUNA
$routes->get('/pengguna', 'PenggunaController::index');
$routes->post('/pengguna/add', 'PenggunaController::add');
$routes->post('/pengguna/checkUsername', 'PenggunaController::checkUsername');
$routes->post('/pengguna/edit/(:num)', 'PenggunaController::edit/$1');
$routes->post('/pengguna/delete/(:num)', 'PenggunaController::delete/$1');

/***
 * ROUTES UNTUK INVENTARIS */

// Routes untuk mengelola data PENGAJUAN INVENTARIS
$routes->get('/pengajuan_inventaris', 'PengajuanInventarisController::index');
$routes->post('/pengajuan_inventaris/add', 'PengajuanInventarisController::add');
$routes->post('/pengajuan_inventaris/edit/(:any)', 'PengajuanInventarisController::edit/$1');
$routes->post('/pengajuan_inventaris/delete/(:any)', 'PengajuanInventarisController::delete/$1');
$routes->post('/pengajuan_inventaris/setuju/(:any)', 'PengajuanInventarisController::setuju/$1');
$routes->post('/pengajuan_inventaris/tolak/(:any)', 'PengajuanInventarisController::tolak/$1');
$routes->post('/pengajuan_inventaris/print', 'PengajuanInventarisController::print');

// Routes untuk mengelola data PEMBELIAN INVENTARIS
$routes->get('/pembelian_inventaris', 'PembelianInventarisController::index');
$routes->post('/pembelian_inventaris/add', 'PembelianInventarisController::add');
$routes->post('/pembelian_inventaris/edit/(:any)', 'PembelianInventarisController::edit/$1');
$routes->post('/pembelian_inventaris/delete/(:any)', 'PembelianInventarisController::delete/$1');
$routes->get('/pembelian_inventaris/detail/(:any)', 'PembelianInventarisController::detail/$1');
$routes->post('/pembelian_inventaris/setuju/(:num)', 'PembelianInventarisController::setuju/$1');
$routes->post('/pembelian_inventaris/tolak/(:num)', 'PembelianInventarisController::tolak/$1');
$routes->get('/pembelian_inventaris/print/(:any)', 'PembelianInventarisController::print/$1');
$routes->get('/pembelian_inventaris/pilih_barang', 'PembelianInventarisController::getBarangDetails');

// Routes untuk mengelola data PENERIMAAN INVENTARIS
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

// Routes untuk PEMBAYARAN INVENTARIS
$routes->get('/pembayaran_inventaris', 'PembayaranInventarisController::index');
$routes->post('/pembayaran_inventaris/add', 'PembayaranInventarisController::add');
$routes->get('/pembayaran_inventaris/delete/(:any)', 'PembayaranInventarisController::delete/$1');

/***
 * ROUTES UNTUK NON MEDIS */

// Routes untuk mengelola data PENGAJUAN NON MEDIS
$routes->get('/pengajuan_non_medis', 'PengajuanNonMedisController::index');
$routes->post('/pengajuan_non_medis/add', 'PengajuanNonMedisController::add');
$routes->get('/pengajuan_non_medis/pilih_barang', 'PengajuanNonMedisController::getBarangDetails');
$routes->post('/pengajuan_non_medis/setuju/(:any)', 'PengajuanNonMedisController::setuju/$1');
$routes->post('/pengajuan_non_medis/tolak/(:any)', 'PengajuanNonMedisController::tolak/$1');
$routes->post('/pengajuan_non_medis/delete/(:any)', 'PengajuanNonMedisController::delete/$1');
$routes->get('/pengajuan_non_medis/detail/(:any)', 'PengajuanNonMedisController::detail/$1');
$routes->get('/pengajuan_non_medis/print/(:any)', 'PengajuanNonMedisController::print/$1');

// Routes untuk mengelola data PEMBELIAN  NON MEDIS
$routes->get('/pembelian_non_medis', 'PembelianNonMedisController::index');
$routes->post('/pembelian_non_medis/add', 'PembelianNonMedisController::add');
$routes->post('/pembelian_non_medis/edit/(:any)', 'PembelianNonMedisController::edit/$1');
$routes->get('/pembelian_non_medis/pilih_barang', 'PembelianNonMedisController::getBarangDetails');
$routes->post('/pembelian_non_medis/setuju/(:any)', 'PembelianNonMedisController::setuju/$1');
$routes->post('/pembelian_non_medis/tolak/(:any)', 'PembelianNonMedisController::tolak/$1');
$routes->post('/pembelian_non_medis/delete/(:any)', 'PembelianNonMedisController::delete/$1');
$routes->get('/pembelian_non_medis/detail/(:any)', 'PembelianNonMedisController::detail/$1');
$routes->get('/pembelian_non_medis/print/(:any)', 'PembelianNonMedisController::print/$1');

// Routes untuk mengelola data PENERIMAAN NON MEDIS
$routes->get('/penerimaan_non_medis', 'PenerimaanNonMedisController::index');
$routes->post('/penerimaan_non_medis/add', 'PenerimaanNonMedisController::add');
$routes->post('/penerimaan_non_medis/edit/(:any)', 'PenerimaanNonMedisController::edit/$1');
$routes->post('/penerimaan_non_medis/delete/(:any)', 'PenerimaanNonMedisController::delete/$1');
$routes->get('/penerimaan_non_medis/detail/(:any)', 'PenerimaanNonMedisController::detail/$1');
$routes->get('/penerimaan_non_medis/print/(:any)', 'PenerimaanNonMedisController::print/$1');
$routes->get('/penerimaan_non_medis/pilih_no_faktur', 'PenerimaanNonMedisController::getFaktur');
$routes->get('/penerimaan_non_medis/info/(:any)', 'PenerimaanNonMedisController::info/$1');

// Routes untuk mengelola data PERMINTAAN NON MEDIS
$routes->get('/permintaan_non_medis', 'PermintaanNonMedisController::index');
$routes->post('/permintaan_non_medis/add', 'PermintaanNonMedisController::add');
$routes->post('/permintaan_non_medis/edit/(:any)', 'PermintaanNonMedisController::edit/$1');
$routes->post('/permintaan_non_medis/delete/(:any)', 'PermintaanNonMedisController::delete/$1');
$routes->get('/permintaan_non_medis/detail/(:any)', 'PermintaanNonMedisController::detail/$1');
$routes->get('/permintaan_non_medis/print/(:any)', 'PermintaanNonMedisController::print/$1');
$routes->get('/permintaan_non_medis/pilih_no_faktur', 'PermintaanNonMedisController::getFaktur');
$routes->get('/permintaan_non_medis/info/(:any)', 'PermintaanNonMedisController::info/$1');
$routes->post('/permintaan_non_medis/setuju/(:any)', 'PermintaanNonMedisController::setuju/$1');
$routes->post('/permintaan_non_medis/tolak/(:any)', 'PermintaanNonMedisController::tolak/$1');

// Routes untuk mengelola data PENGELUARAN NON MEDIS
$routes->get('/pengeluaran_non_medis', 'PengeluaranNonMedisController::index');
$routes->post('/pengeluaran_non_medis/add', 'PengeluaranNonMedisController::add');
$routes->post('/pengeluaran_non_medis/edit/(:any)', 'PengeluaranNonMedisController::edit/$1');
$routes->post('/pengeluaran_non_medis/delete/(:any)', 'PengeluaranNonMedisController::delete/$1');
$routes->get('/pengeluaran_non_medis/detail/(:any)', 'PengeluaranNonMedisController::detail/$1');
$routes->get('/pengeluaran_non_medis/print/(:any)', 'PengeluaranNonMedisController::print/$1');
$routes->get('/pengeluaran_non_medis/pilih_no_faktur', 'PengeluaranNonMedisController::getFaktur');
$routes->get('/pengeluaran_non_medis/info/(:any)', 'PengeluaranNonMedisController::info/$1');
