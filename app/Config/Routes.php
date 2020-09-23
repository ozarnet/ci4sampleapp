<?php namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php'))
{
    require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/**
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');

// Additional in-file definitions
$routes->get('countries', 'Countries::index');
$routes->get('countries/index', 'Countries::index');
$routes->get('countries/list', 'Countries::index');
$routes->get('countries/add', 'Countries::add');
$routes->post('countries/add', 'Countries::add');
$routes->get('countries/edit/(:alphanum)', 'Countries::edit/$1');
$routes->post('countries/edit/(:alphanum)', 'Countries::edit/$1');
$routes->get('countries/delete/(:alphanum)', 'Countries::delete/$1');
$routes->get('cities', 'Cities::index');
$routes->get('cities/index', 'Cities::index');
$routes->get('cities/list', 'Cities::index');
$routes->get('cities/add', 'Cities::add');
$routes->post('cities/add', 'Cities::add');
$routes->get('cities/edit/(:num)', 'Cities::edit/$1');
$routes->post('cities/edit/(:num)', 'Cities::edit/$1');
$routes->get('cities/delete/(:num)', 'Cities::delete/$1');
$routes->get('people', 'People::index');
$routes->get('people/index', 'People::index');
$routes->get('people/list', 'People::index');
$routes->get('people/add', 'People::add');
$routes->post('people/add', 'People::add');
$routes->get('people/edit/(:num)', 'People::edit/$1');
$routes->post('people/edit/(:num)', 'People::edit/$1');
$routes->get('people/delete/(:num)', 'People::delete/$1');

/**
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}