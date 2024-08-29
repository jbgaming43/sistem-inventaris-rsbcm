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