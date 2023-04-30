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

$routes->group('admin', [], function($routes) {
	
	$routes->group('cities', ['namespace' => 'App\Controllers\Admin'], function ($routes) {
		$routes->get('', 'CitiesController::index', ['as' => 'cityList']);
		$routes->get('add', 'CitiesController::add', ['as' => 'newCity']);
		$routes->post('add', 'CitiesController::add', ['as' => 'createCity']);
		$routes->post('create', 'CitiesController::create', ['as' => 'ajaxCreateCity']);
		$routes->put('(:num)/update', 'CitiesController::update/$1', ['as' => 'ajaxUpdateCity']);
		$routes->post('(:num)/edit', 'CitiesController::edit/$1', ['as' => 'updateCity']);
		$routes->post('datatable', 'CitiesController::datatable', ['as' => 'dataTableOfCities']);
		$routes->post('allmenuitems', 'CitiesController::allItemsSelect', ['as' => 'select2ItemsOfCities']);
		$routes->post('menuitems', 'CitiesController::menuItems', ['as' => 'menuItemsOfCities']);
	});
	$routes->resource('cities', ['namespace'  => 'App\Controllers\Admin', 'controller' => 'CitiesController', 'except' => 'show,new,create,update']);

	
	$routes->group('countries', ['namespace' => 'App\Controllers\Admin'], function ($routes) {
		$routes->get('', 'CountriesController::index', ['as' => 'countryList']);
		$routes->get('add', 'CountriesController::add', ['as' => 'newCountry']);
		$routes->post('add', 'CountriesController::add', ['as' => 'createCountry']);
		$routes->post('create', 'CountriesController::create', ['as' => 'ajaxCreateCountry']);
		$routes->put('(:any)/update', 'CountriesController::update/$1', ['as' => 'ajaxUpdateCountry']);
		$routes->post('(:any)/edit', 'CountriesController::edit/$1', ['as' => 'updateCountry']);
		$routes->post('datatable', 'CountriesController::datatable', ['as' => 'dataTableOfCountries']);
		$routes->post('allmenuitems', 'CountriesController::allItemsSelect', ['as' => 'select2ItemsOfCountries']);
		$routes->post('menuitems', 'CountriesController::menuItems', ['as' => 'menuItemsOfCountries']);
	});
	$routes->resource('countries', ['namespace'  => 'App\Controllers\Admin', 'controller' => 'CountriesController', 'except' => 'show,new,create,update']);

	
	$routes->group('people', ['namespace' => 'App\Controllers\Admin'], function ($routes) {
		$routes->get('', 'PeopleController::index', ['as' => 'personList']);
		$routes->get('index', 'PeopleController::index', ['as' => 'personIndex']);
		$routes->get('list', 'PeopleController::index', ['as' => 'personList2']);
		$routes->get('add', 'PeopleController::add', ['as' => 'newPerson']);
		$routes->post('add', 'PeopleController::add', ['as' => 'createPerson']);
		$routes->get('edit/(:num)', 'PeopleController::edit/$1', ['as' => 'editPerson']);
		$routes->post('edit/(:num)', 'PeopleController::edit/$1', ['as' => 'updatePerson']);
		$routes->get('delete/(:num)', 'PeopleController::delete/$1', ['as' => 'deletePerson']);
		$routes->post('allmenuitems', 'PeopleController::allItemsSelect', ['as' => 'select2ItemsOfPeople']);
		$routes->post('menuitems', 'PeopleController::menuItems', ['as' => 'menuItemsOfPeople']);
	});

});


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