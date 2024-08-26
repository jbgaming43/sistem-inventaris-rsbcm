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
