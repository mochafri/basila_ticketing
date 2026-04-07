<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'DashboardController::index');
$routes->get('tiket', 'TicketController::index');
$routes->get('tiket/create', 'TicketController::create');
$routes->get('tiket/(:num)', 'TicketController::show/$1');
$routes->get('/user', 'MasterDataController::user');
$routes->get('/kategori', 'MasterDataController::kategori');
$routes->post('/create-kategori', 'MasterDataController::createKategori');
$routes->post('/create-layanan', 'MasterDataController::createLayanan');
$routes->get('/get-layanan/(:num)', 'TicketController::getLayananByID/$1');
$routes->delete('master-data/delete-kategori/(:num)', 'MasterDataController::deleteKategori/$1');

# Ambil file dari local server
$routes->get('tiket/file/(:any)', 'TicketController::getFile/$1');

# EndPoint buat tiket baru 
$routes->post('/tiket/baru', 'TicketController::createTiket');

# Coba endPoint approve reject sama eskalasi
$routes->post('/reject-tiket/(:num)', 'TicketController::rejectTiket/$1');
$routes->post('/escalated-tiket/(:num)', 'TicketController::escalated/$1');
$routes->post('/approve-tiket/(:num)', 'TicketController::approveTiket/$1');

# Assign task ke staff
$routes->post('/assign-staff/(:num)', 'TicketController::asssignTiket/$1');

# End point layanan
$routes->post('/layanan/(:num)', 'MasterController:getLayanan/$1');