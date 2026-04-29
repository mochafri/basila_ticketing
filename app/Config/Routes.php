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
$routes->get('/dashboard', 'DashboardController::index');
$routes->get('tiket', 'TicketController::index');
$routes->get('tiket/create', 'TicketController::create');
$routes->get('tiket/(:num)', 'TicketController::show/$1');

$routes->get('/user', 'MasterDataController::user');
$routes->post('/create-role', 'MasterDataController::createRole');
$routes->post('/create-user-mapping', 'MasterDataController::createUserMapping');
$routes->delete('/delete-user-mapping/(:num)', 'MasterDataController::deleteUserMapping/$1');
$routes->get('/kategori', 'MasterDataController::kategori');

$routes->post('/create-kategori', 'MasterDataController::createKategori');
$routes->post('/create-layanan', 'MasterDataController::createLayanan');

$routes->get('/get-layanan/(:num)', 'TicketController::getLayananByID/$1');

# Ambil file dari local server
$routes->get('tiket/file/users/(:any)', 'TicketController::getFileUsers/$1');
$routes->get('tiket/file/admin/(:any)', 'TicketController::getFileAdmin/$1');

# EndPoint buat tiket baru 
$routes->post('/create-tiket', 'TicketController::createTiket');

#EndPoint login pages
$routes->get('/', 'AuthController::signIn');
$routes->get('/signin', 'AuthController::signIn');
$routes->get('/signup', 'AuthController::signUp');
$routes->get('/forgot-password', 'AuthController::forgotPassword');
$routes->get('/role-option', 'RoleOptionController::index');

#EndPoint login Process
$routes->post('/auth/signin', 'AuthController::processSignIn');
$routes->post('/auth/signup', 'AuthController::processSignUp');
$routes->post('/auth/forgot-password', 'AuthController::processForgotPassword');
$routes->post('/role-choice', 'RoleOptionController::chooseRole');

#Endpoint logout
$routes->post('logout', 'AuthController::logout');
$routes->get('logout', 'AuthController::logout');

# Coba endPoint approve reject sama eskalasi
$routes->post('/reject-tiket/(:num)', 'TicketController::rejectTiket/$1');
$routes->post('/escalated-tiket/(:num)', 'TicketController::escalated/$1');
$routes->post('/approve-tiket/(:num)', 'TicketController::approveTiket/$1');
$routes->post('/tutup-tiket/(:num)', 'TicketController::closeTicket/$1');
$routes->post('revisi-kaur', 'TicketController::revisiKaur');

# Assign task ke staff
$routes->post('/approve-task/(:num)', 'TicketController::approveTask/$1');
$routes->post('/assign-staff/(:num)', 'TicketController::asssignTiket/$1');
$routes->post('/edit-instruction/(:num)', 'TicketController::updateTaskInstruction/$1');
$routes->post('/upload-task/(:num)', 'TicketController::uploadTask/$1');
$routes->post('/verifikasi-tugas/(:num)', 'TicketController::verifikasiTask/$1');
$routes->post('/revisi-tugas/(:num)', 'TicketController::revisiTask/$1');
$routes->post('/selesaikan-tugas-kaur/(:num)', 'TicketController::selesaikanTugasKaur/$1');

# End point layanan
$routes->post('/layanan/(:num)', 'MasterController:getLayanan/$1');
