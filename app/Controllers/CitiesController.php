<?php  namespace App\Controllers;


use App\Controllers\GoBaseResourceController;

use App\Models\Collection;

use App\Entities\City;

use App\Models\CountryModel;

use App\Models\CityModel;

class CitiesController extends GoBaseResourceController { 

    protected $modelName = CityModel::class;
    protected $format = 'json';
    
    protected static $singularObjectName = 'City';
    protected static $singularObjectNameCc = 'city';
    protected static $pluralObjectName = 'Cities';
    
    protected static $controllerSlug = 'cities';
    
    protected static $viewPath = 'cityViews/';
    
    protected $indexRoute = 'cities';
    
    protected $formValidationRules = [
    		'country_code' => 'trim',
		'city_name' => 'trim|required|max_length[60]',
		];
    
    public function index() {
        if ($this->request->isAJAX()) {
            $start = $this->request->getGet('start');
            $length = $this->request->getGet('length');
            $search = $this->request->getGet('search[value]');
            $requestedOrder = $this->request->getGet('order[0][column]');
            $order = CityModel::SORTABLE[$requestedOrder > 0 ? $requestedOrder : 1];
            $dir = $this->request->getGet('order[0][dir]');
    
            return $this->respond(Collection::datatable(
                $this->model->getResource($search)->orderBy($order, $dir)->limit($length, $start)->get()->getResultObject(),
                $this->model->getResource()->countAllResults(),
                $this->model->getResource($search)->countAllResults()
            ));
        }
    
        $viewData = [
                'currentModule' => static::$controllerSlug,
                'pageTitle' => 'Cities',
                'pageSubTitle' => 'Manage All City Records',
                'city' => new \App\Entities\City(),
            ];
    
        $viewData = array_merge($this->viewData, $viewData);
    
        return view('cityViews/viewCityList', $viewData);
    }        
        
        public function add() {
        
            $cityModel = $this->model;
        
            $requestMethod = $this->request->getMethod();
        
            if ($requestMethod === 'post') :
        
                $postData = $this->request->getPost();
                $sanitizedData = [];
        
                foreach ($postData as $k => $v) :
                    $sanitizationResult = goSanitize($v);
                    $sanitizedData[$k] = $sanitizationResult[0];
                endforeach;
        
                $city = new \App\Entities\City($sanitizedData);
    
                $formValid = $this->canValidate();
        
                if ($formValid) :
                    try {
                        $successfulResult = $cityModel->save($city);
                    } catch (\Exception $e) {
                        $successfulResult = false;
                        $userFriendlyErrMsg = 'An error occurred in an attempt to save a new '.static::$singularObjectName.' to the database :';
                        $result['error'] = $userFriendlyErrMsg;
                        $query = $cityModel->db->getLastQuery();
                        log_message('error', $userFriendlyErrMsg.PHP_EOL.$e->getMessage().PHP_EOL.$query);
                        $dbError = $cityModel->db->error();
                    if (!empty($dbError['message'])) :
                        log_message('error', $dbError['code'].' : '.$dbError['message']);
                        $result['error'] .= '<br><br>'.$dbError['code'].' : '.$dbError['message'];
                    endif;
                    }
        
                else:
                    $successfulResult = false;
                    $this->viewData['errorMessage'] .= "The errors on the form need to be corrected";
                endif;
        
                $thenRedirect = true;
        
                if ($successfulResult) :
        
                    $insertedId = $this->model->db->insertID();
                    $theId = $insertedId;
        
                    $message = 'The ' . strtolower(static::$singularObjectName) . ' was successfully saved' . (empty($this->model::$labelField) ? 'with name <i>' . $city->{$this->model::$labelField} . '</i>' : '').'. ';
                    $message .= anchor( 'cities/' . $theId . '/edit' , 'Continue editing?');
        
                    if ($thenRedirect) :
                        if (!empty($this->indexRoute)) :
                            return redirect()->to(route_to($this->indexRoute))->with('successMessage', $message);
                        else:
                            return $this->redirect2listView('successMessage', $message);
                        endif;
                    else:
                        $this->viewData['successMessage'] = $message;
                    endif;
                else:
                    if ($formValid) :
                        $this->viewData['errorMessage'] .= 'The ' . strtolower(static::$singularObjectName) . ' was not saved due to an error';
                    endif;
                    if (!empty($result['error'])) :
                        $this->viewData['errorMessage'] .= ':<br>' . $result['error'];
                    else:
                        $this->viewData['errorMessage'] .= '.';
                    endif;
                endif;
        
            endif; // ($requestMethod === 'post')
        
            $this->viewData['city'] = $city ?? new City();
            		$this->viewData['countryList'] = $this->getCountryListItems();

        
            $this->viewData['formAction'] = route_to('createCity');

            $this->displayForm(__METHOD__);
        }

        
        
        public function edit($requestedId = null) {
        
            if ($requestedId == null) :
                return $this->redirect2listView();
            endif;
        
            $id = filter_var($requestedId, FILTER_SANITIZE_URL);
        
            $city = $this->model->find($id);
        
            if ($city == false) :
                $message = 'No such city ( with identifier ' . $id . ') was found in the database.';
                return $this->redirect2listView("errorMessage", $message);
            endif;
        
            $requestMethod = $this->request->getMethod();
        
            if ($requestMethod === 'post') :
                $postData = $this->request->getPost();
                $sanitizedData = [];
                foreach ($postData as $k => $v) :
                    $sanitizationResult = goSanitize($v);
                    $sanitizedData[$k] = $sanitizationResult[0];
                endforeach;
        
                if ($this->request->getPost('enabled') == null ) {
$sanitizedData['enabled'] = false;
}

        
                $formValid = $this->canValidate();
                $successfulResult = false; // for now
        
                if ($formValid) :
                    try {
                        $successfulResult = $this->model->update($id, $sanitizedData);
                    } catch (\Exception $e) {
                        $query = $this->model->db->getLastQuery();
                        $dbError = $this->model->db->error();
                        log_message('error', 'An error occurred in an attempt to update the '.static::$singularObjectName.' with ID '.$id.' to the database :'.PHP_EOL.$e->getMessage().PHP_EOL.$query.PHP_EOL.$dbError['code'].' : '.$dbError['message']);
                    }
                endif;
                $city = $city->mergeAttributes($sanitizedData);
        
                $thenRedirect = true;
        
                if ($successfulResult) :
                    $theId = $city->id;
                    $message = 'The ' . strtolower(static::$singularObjectName) . (!empty($this->model::$labelField) ? ' named <b>' . $city->{$this->model::$labelField} . '</b>' : '');
                    $message .= ' was successfully updated. ';
                    $message .= anchor( 'cities/' . $theId . '/edit' , 'Continue editing?');
        
                    if ($thenRedirect) :
                        if (!empty($this->indexRoute)) :
                            return redirect()->to(route_to($this->indexRoute))->with('successMessage', $message);
                        else:
                            return $this->redirect2listView('successMessage', $message);
                        endif;
                    else:
                        $this->viewData['successMessage'] = $message;
                    endif;
                else: // ($successfulResult == false)
                    if ($formValid) :
                        $this->viewData['errorMessage'] .= 'The ' . strtolower(static::$singularObjectName) . ' was not saved due to an error';
                    endif;
                    if (!empty($result['error'])) :
                        $this->viewData['errorMessage'] .= ':<br>' . $result['error'];
                    endif;
                endif; // ($successfulResult)
            endif; // ($requestMethod === 'post')
        
            $this->viewData['city'] = $city;
            		$this->viewData['countryList'] = $this->getCountryListItems();

        
            $theId = $id;
		$this->viewData['formAction'] = route_to('updateCity', $theId);

        
            $this->displayForm(__METHOD__, $id);
        } // function edit(...)

	protected function getCountryListItems() { 
		$countryModel = new CountryModel();
		$onlyActiveOnes = true;
		$data = $countryModel->getAllForMenu('iso_code, country_name','country_name', $onlyActiveOnes );

		return $data;
	}


}
