<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'Auth::index');
$routes->get('/login', 'Auth::index');
$routes->post('/auth', 'Auth::auth');
$routes->get('/dashboard', 'Dashboard::index');
$routes->get('/logout', 'Auth::logout');

// User Acounts routes

$routes->get('/users', 'Users::index');
$routes->post('users/save', 'Users::save');
$routes->get('users/edit/(:segment)', 'Users::edit/$1');
$routes->post('users/update', 'Users::update');
$routes->delete('users/delete/(:num)', 'Users::delete/$1');
$routes->post('users/fetchRecords', 'Users::fetchRecords');
// Person Routes
$routes->get('person', 'Person::index');
$routes->post('person/save', 'Person::save');
$routes->post('person/delete/(:any)', 'Person::delete/$1');
$routes->get('person/edit/(:any)', 'Person::edit/$1');
$routes->post('person/update', 'Person::update_person');
// Dashboard routing
$routes->get('dashboard/new-orders', 'Dashboard::newOrders');
$routes->get('dashboard/bounce-rate', 'Dashboard::bounceRate');
$routes->get('dashboard/user-registrations', 'Dashboard::userRegistrations');
$routes->get('dashboard/unique-visitors', 'Dashboard::uniqueVisitors');
// This maps the URL with a dash to your controller method
$routes->get('user-registrations', 'Dashboard::userRegistrations');
$routes->get('log', 'Logs::index');
$routes->get('dashboard', 'Dashboard::log');
//Parent routes
$routes->get('/parent', 'Parent::index');
$routes->post('parent/save', 'Parent::save');
$routes->get('parent/edit/(:segment)', 'Parent::edit/$1');
$routes->post('parent/update', 'Parent::update');
$routes->delete('parent/delete/(:num)', 'Parent::delete/$1');
$routes->post('parent/fetchRecords', 'Parent::fetchRecords');