<?php  namespace App\Controllers;


use App\Controllers\GoBaseResourceController;

use App\Models\Collection;

use App\Entities\City;

use App\Models\CityModel;

use App\Models\CountryModel;

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
    		'city_name' => 'trim|required|max_length[60]',
		'country_code' => 'trim',
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
                'usingServerSideDataTable' => true,
                'usingSweetAlert' => true,
                'additionalFooterView2include' => 'cityViews/_cityFooterAdditions',
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
                
        
                $noException = true;
        
                $formValid = $this->canValidate();
        
                if ($formValid) :
                    try {
                        $successfulResult = $cityModel->save($city);
                    } catch (\Exception $e) {
                        $noException = false;
                        $successfulResult = false;
                        $query = $this->model->db->getLastQuery()->getQuery();
                        $dbError = $this->model->db->error();
                        $userFriendlyErrMsg = 'An error occurred in an attempt to save a new '.static::$singularObjectName.' to the database : ';
                        if ($dbError['code'] == 1062) :
                            $userFriendlyErrMsg .= PHP_EOL.'There is an existing '.static::$singularObjectName.' on our database with the same data.';
                        endif;
                        $result['error'] = $userFriendlyErrMsg;
                        log_message('error', $userFriendlyErrMsg.PHP_EOL.$e->getMessage().PHP_EOL.$query);
                        if (!empty($dbError['message'])) :
                            log_message('error', $dbError['code'].' : '.$dbError['message']);
                            $result['error'] .= '<br><br>'.$dbError['code'].' : '.$dbError['message'];
                        endif;
                }
                else:
                $successfulResult = false;
                $this->viewData['errorMessage'] .= "The errors on the form need to be corrected: ";
                endif;
        
                // if ($formValid && !$successfulResult && !is_numeric($city->{$this->model->getPrimaryKeyName()}) && $noException) :
			if ($formValid && !$successfulResult && $noException) :
    			$successfulResult = true; // Work around CodeIgniter bug returning falsy value from insert operation in case of alpha-numeric PKs
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
                    if (!$formValid) :
                        $this->viewData['errorMessage'] .= 'The ' . strtolower(static::$singularObjectName) . ' was not saved due to an erroneous value entered on the form. ';
                    else:
                        $this->viewData['errorMessage'] .= 'The ' . strtolower(static::$singularObjectName) . ' was not saved because of an error. ';
                    endif;
                    if (!empty($result['error'])) :
                        $this->viewData['errorMessage'] = (!empty($this->viewData['errorMessage']) ? $this->viewData['errorMessage'].'<br>' : '') . $result['error'];
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

        
                $noException = true; // for now
        
                $formValid = $this->canValidate();
        
                if ($formValid) :
                    try {
                        $successfulResult = $this->model->update($id, $sanitizedData);
                    } catch (\Exception $e) {
                        $noException = false;
                        $successfulResult = false;
                        $query = $this->model->db->getLastQuery()->getQuery();
                        $dbError = $this->model->db->error();
                        $userFriendlyErrMsg = 'An error occurred in an attempt to update the '.static::$singularObjectName.' with ID '.$id.' to the database : ';
                        if ($dbError['code'] == 1062) :
                            $userFriendlyErrMsg .= PHP_EOL.'There is an existing '.static::$singularObjectName.' on our database with the same data.';
                        endif;
                        $result['error'] = $userFriendlyErrMsg;
                        log_message('error', $userFriendlyErrMsg.PHP_EOL.$e->getMessage().PHP_EOL.$query);
                        if (!empty($dbError['message'])) :
                            log_message('error', $dbError['code'].' : '.$dbError['message']);
                            $result['error'] .= '<br><br>'.$dbError['code'].' : '.$dbError['message'];
                        endif;
                    }
                else:
                    $successfulResult = false;
                    $this->viewData['errorMessage'] .= "The errors on the form need to be corrected: ";
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
                    if (!$formValid) :
                        $this->viewData['errorMessage'] .= 'The ' . strtolower(static::$singularObjectName) . ' was not saved due to an erroneous value entered on the form. ';
                    else:
                        $this->viewData['errorMessage'] .= 'The ' . strtolower(static::$singularObjectName) . ' was not saved because of an error. ';
                    endif;
                    if (!empty($result['error'])) :
                        $this->viewData['errorMessage'] = (!empty($this->viewData['errorMessage']) ? $this->viewData['errorMessage'].'<br>' : '') . $result['error'];
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
