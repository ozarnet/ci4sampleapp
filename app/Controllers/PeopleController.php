<?php  namespace App\Controllers;


use App\Models\PersonModel;

use App\Models\CityModel;
use App\Entities\Person;

class PeopleController extends GoBaseController { 

    protected static $primaryModelName = 'PersonModel';
    protected static $singularObjectName = 'Person';
    protected static $singularObjectNameCc = 'person';
    protected static $pluralObjectName = 'People';
    protected static $pluralObjectNameCc = 'people';

    protected static $viewPath = 'personViews/';

    protected $formValidationRules = [
		'sex' => 'trim',
		'birth_date' => 'valid_date|permit_empty',
		'person_type' => 'max_length[31]',
		'last_name' => 'trim|required|max_length[50]',
		'email_address' => 'trim|max_length[50]|valid_email|permit_empty',
		'first_name' => 'trim|required|max_length[40]',
		'phone_number' => 'trim|max_length[20]',
		'notes' => 'trim|max_length[16313]',
		'score' => 'decimal|permit_empty',
		'middle_name' => 'trim|max_length[40]',
		];

    public function index() {

         $this->viewData['usingDataTables'] = true;
         
		 $this->viewData['personList'] = $this->primaryModel->findAllWithCities('*');

         parent::index();

    }

    public function add() {

        $personModel = new PersonModel();

        $requestMethod = $this->request->getMethod();

        if ($requestMethod === 'post') :

            $postData = $this->request->getPost();
            $sanitizedData = [];
        
            foreach ($postData as $k => $v) :
                $sanitizationResult = goSanitize($v);
                $sanitizedData[$k] = $sanitizationResult[0];
            endforeach;

            $person = new Person($sanitizedData);

            $formValid = $this->canValidate();
            $successfulResult = true;
            
            if ($formValid) :
                try {
                    $personModel->save($person);
                } catch (\Exception $e) {
                    $successfulResult = false;
                    $userFriendlyErrMsg = 'An error occurred in an attempt to save a new '.static::$singularObjectName.' to the database :';
                    $result['error'] = $userFriendlyErrMsg;
                    $query = $personModel->db->getLastQuery();
                    log_message('error', $userFriendlyErrMsg.PHP_EOL.$e->getMessage().PHP_EOL.$query);
                    $dbError = $personModel->db->error();
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

                $insertedId = $this->primaryModel->db->insertID();
                $theId = $insertedId;

                $message = 'The ' . strtolower(static::$singularObjectName) . ' was successfully saved' . (empty($this->primaryModel::$labelField) ? 'with name <i>' . $person->{$this->primaryModel::$labelField} . '</i>' : '').'. ';
                $message .= '<a href="' . route_to('editPerson', $theId) . '">Continue editing?</a>';

                if ($thenRedirect) :
                    return $this->redirect2listView('successMessage', $message);
                else:
                    $this->viewData['successMessage'] = $message;
                endif;
            else:
                if ($formValid) {
                    $this->viewData['errorMessage'] .= 'The ' . strtolower(static::$singularObjectName) . ' was not saved due to an error';
                }
                if (!empty($result['error'])) :
                  $this->viewData['errorMessage'] .= ':<br>' . $result['error'];
                else:
                  $this->viewData['errorMessage'] .= '.';
                endif;
            endif;
        
        endif; // ($requestMethod === 'post')
        
        $this->viewData['person'] = $person ?? new Person();
		$this->viewData['cityList'] = $this->getCityListItems();
		$this->viewData['sexList'] = $this->getSexOptions();
		$this->viewData['personTypeList'] = $this->getPersonTypeOptions();


        $this->viewData['formAction'] = route_to('createPerson');

        $this->displayForm(__METHOD__);
    }

    public function edit($requestedId = null) {

        if ($requestedId == null) :
            return $this->redirect2listView();
        endif;
        $id = filter_var($requestedId, FILTER_SANITIZE_URL);
        $person = $this->primaryModel->find($id);

        if ($person == false) :
            $message = 'No such person ( with identifier ' . $id . ') was found in the database.';
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
        
            if ($this->request->getPost('is_friend') == null ) {
                $sanitizedData['is_friend'] = false;
            }
            if ($this->request->getPost('enabled') == null ) {
                $sanitizedData['enabled'] = false;
            }

        
            $formValid = $this->canValidate();
            $successfulResult = false; // for now

            if ($formValid) :
                try {
                    $successfulResult = $this->primaryModel->update($id, $sanitizedData);
                } catch (\Exception $e) {
                    $query = $this->primaryModel->db->getLastQuery();
                    $dbError = $this->primaryModel->db->error();
                    log_message('error', 'An error occurred in an attempt to update the '.static::$singularObjectName.' with ID '.$id.' to the database :'.PHP_EOL.$e->getMessage().PHP_EOL.$query.PHP_EOL.$dbError['code'].' : '.$dbError['message']);
                }
                $person = $person->mergeAttributes($sanitizedData);
            endif;

            $thenRedirect = true;

            if ($successfulResult) :
                $theId = $person->id;
                $message = 'The ' . strtolower(static::$singularObjectName) . (!empty($this->primaryModel::$labelField) ? ' named <b>' . $person->{$this->primaryModel::$labelField} . '</b>' : '');
                $message .= ' was successfully updated. ';
                $message .= '<a href="' . route_to('editPerson', $theId) . '">Continue editing?</a>';

                if ($thenRedirect) :
                    return $this->redirect2listView('successMessage', $message);
                else:
                    $this->viewData['successMessage'] = $message;
                endif;
            else: // ($successfulResult == false)
                if ($formValid) {
                    $this->viewData['errorMessage'] .= 'The ' . strtolower(static::$singularObjectName) . ' was not saved due to an error';
                }
                if (!empty($result['error'])) :
                    $this->viewData['errorMessage'] .= ':<br>' . $result['error'];
                else:
                    $this->viewData['errorMessage'] .= '.';
                endif;
            endif; // ($successfulResult)
        endif; // ($requestMethod === 'post')

        $this->viewData['person'] = $person;
		$this->viewData['cityList'] = $this->getCityListItems();
		$this->viewData['sexList'] = $this->getSexOptions();
		$this->viewData['personTypeList'] = $this->getPersonTypeOptions();

        
        $theId = $id;
		$this->viewData['formAction'] = route_to('updatePerson', $theId);

        
        $this->displayForm(__METHOD__, $id);
    } // function edit(...)

	protected function getCityListItems() { 
		$cityModel = new CityModel();
		$onlyActiveOnes = true;
		$data = $cityModel->getAllForMenu('id, city_name','city_name', $onlyActiveOnes);

		return $data;
	}



	protected function getSexOptions() { 
		$sexOptions = [ 
				'' => 'Please select...',
				'F' => 'Female',
				'M' => 'Male',
			];
		return $sexOptions;
	}



	protected function getPersonTypeOptions() { 
		$personTypeOptions = [ 
				'' => 'Please select...',
				'unspecified' => 'unspecified',
				'colleague' => 'colleague',
				'employee' => 'employee',
				'customer' => 'customer',
				'friend' => 'friend',
			];
		return $personTypeOptions;
	}


}
