<?php

namespace App\Controllers;

class Home extends BaseController {

	public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger) {
		$this->viewData['currentModule'] = 'Dashboard';
		parent::initController($request, $response, $logger);
	}

	/**
	* Index Page for this controller.
	*
	* @return string
	*/
	public function index() {

		$this->viewData['pageTitle'] = 'Welcome';

		$countryModel = new \App\Models\CountryModel();

		$cityModel = new \App\Models\CityModel();

		$personModel = new \App\Models\PersonModel();

		$this->viewData['totalNrOfCountries'] = $countryModel->getCount();

		$this->viewData['countryList'] = $countryModel->findAll(5);

		$this->viewData['totalNrOfCities'] = $cityModel->getCount();

		$this->viewData['cityList'] = $cityModel->findAll(5);

		$this->viewData['totalNrOfPeople'] = $personModel->getCount();

		$this->viewData['personList'] = $personModel->findAll(5);

		return view('dashboardHome', $this->viewData);
	}
}