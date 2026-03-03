<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'DashboardController::index');
$routes->get('tiket', 'TicketController::index');
$routes->get('tiket/create', 'TicketController::create');
$routes->get('tiket/(:num)', 'TicketController::show/$1');
