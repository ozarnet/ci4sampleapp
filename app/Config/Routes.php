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
$routes->get('countries', 'CountriesController::index', ['as' => 'countries']);
$routes->get('countries/index', 'CountriesController::index', ['as' => 'countryIndex']);
$routes->get('countries/list', 'CountriesController::index', ['as' => 'countryList']);
$routes->get('countries/add', 'CountriesController::add', ['as' => 'newCountry']);
$routes->post('countries/add', 'CountriesController::add', ['as' => 'createCountry']);
$routes->get('countries/edit/(:alphanum)', 'CountriesController::edit/$1', ['as' => 'editCountry']);
$routes->post('countries/edit/(:alphanum)', 'CountriesController::edit/$1', ['as' => 'updateCountry']);
$routes->get('countries/delete/(:alphanum)', 'CountriesController::delete/$1', ['as' => 'deleteCountry']);
$routes->get('cities', 'CitiesController::index', ['as' => 'cities']);
$routes->get('cities/index', 'CitiesController::index', ['as' => 'cityIndex']);
$routes->get('cities/list', 'CitiesController::index', ['as' => 'cityList']);
$routes->get('cities/add', 'CitiesController::add', ['as' => 'newCity']);
$routes->post('cities/add', 'CitiesController::add', ['as' => 'createCity']);
$routes->get('cities/edit/(:num)', 'CitiesController::edit/$1', ['as' => 'editCity']);
$routes->post('cities/edit/(:num)', 'CitiesController::edit/$1', ['as' => 'updateCity']);
$routes->get('cities/delete/(:num)', 'CitiesController::delete/$1', ['as' => 'deleteCity']);
$routes->get('people', 'PeopleController::index', ['as' => 'people']);
$routes->get('people/index', 'PeopleController::index', ['as' => 'personIndex']);
$routes->get('people/list', 'PeopleController::index', ['as' => 'personList']);
$routes->get('people/add', 'PeopleController::add', ['as' => 'newPerson']);
$routes->post('people/add', 'PeopleController::add', ['as' => 'createPerson']);
$routes->get('people/edit/(:num)', 'PeopleController::edit/$1', ['as' => 'editPerson']);
$routes->post('people/edit/(:num)', 'PeopleController::edit/$1', ['as' => 'updatePerson']);
$routes->get('people/delete/(:num)', 'PeopleController::delete/$1', ['as' => 'deletePerson']);

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