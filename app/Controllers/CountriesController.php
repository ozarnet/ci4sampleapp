<?php  namespace App\Controllers;


use App\Models\CountryModel;
use App\Entities\Country;

class CountriesController extends GoBaseController { 

    protected static $primaryModelName = 'CountryModel';
    protected static $singularObjectName = 'Country';
    protected static $singularObjectNameCc = 'country';
    protected static $pluralObjectName = 'Countries';
    protected static $pluralObjectNameCc = 'countries';

    protected static $viewPath = 'countryViews/';

    protected $formValidationRules = [
		'iso_code' => 'trim|required|exact_length[2]',
		'country_name' => 'trim|required|max_length[60]',
		];

    public function index() {

         $this->viewData['usingDataTables'] = true;
         
         parent::index();

    }

    public function add() {

        $countryModel = new CountryModel();

        $requestMethod = $this->request->getMethod();

        if ($requestMethod === 'post') :

            $postData = $this->request->getPost();
            $sanitizedData = [];
        
            foreach ($postData as $k => $v) :
                $sanitizationResult = goSanitize($v);
                $sanitizedData[$k] = $sanitizationResult[0];
            endforeach;

            $country = new Country($sanitizedData);
			$this->formValidationRules['country_name'] .= '|is_unique[tbl_countries.country_name]';

            $formValid = $this->canValidate();
            $successfulResult = true;
            
            if ($formValid) :
                try {
                    $countryModel->insert($country);
                } catch (\Exception $e) {
                    $successfulResult = false;
                    $userFriendlyErrMsg = 'An error occurred in an attempt to save a new '.static::$singularObjectName.' to the database :';
                    $result['error'] = $userFriendlyErrMsg;
                    $query = $countryModel->db->getLastQuery();
                    log_message('error', $userFriendlyErrMsg.PHP_EOL.$e->getMessage().PHP_EOL.$query);
                    $dbError = $countryModel->db->error();
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

                $insertedId = $country->{$this->primaryModel->getPrimaryKeyName()};
                $theId = $insertedId;

                $message = 'The ' . strtolower(static::$singularObjectName) . ' was successfully saved <i>with ' . $this->primaryModel->getPrimaryKeyName() . ' : ' . $theId . '</i>. ';
                $message .= '<a href="' . route_to('editCountry', $theId) . '">Continue editing?</a>';

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
        
        $this->viewData['country'] = $country ?? new Country();


        $this->viewData['formAction'] = route_to('createCountry');

        $this->displayForm(__METHOD__);
    }

    public function edit($requestedId = null) {

        if ($requestedId == null) :
            return $this->redirect2listView();
        endif;
        $id = filter_var($requestedId, FILTER_SANITIZE_URL);
        $country = $this->primaryModel->find($id);

        if ($country == false) :
            $message = 'No such country ( with identifier ' . $id . ') was found in the database.';
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
                    $successfulResult = $this->primaryModel->update($id, $sanitizedData);
                } catch (\Exception $e) {
                    $query = $this->primaryModel->db->getLastQuery();
                    $dbError = $this->primaryModel->db->error();
                    log_message('error', 'An error occurred in an attempt to update the '.static::$singularObjectName.' with ID '.$id.' to the database :'.PHP_EOL.$e->getMessage().PHP_EOL.$query.PHP_EOL.$dbError['code'].' : '.$dbError['message']);
                }
                $country = $country->mergeAttributes($sanitizedData);
            endif;

            $thenRedirect = true;

            if ($successfulResult) :
                $theId = $country->iso_code;
                $message = 'The ' . strtolower(static::$singularObjectName) . (!empty($this->primaryModel::$labelField) ? ' named <b>' . $country->{$this->primaryModel::$labelField} . '</b>' : '');
                $message .= ' was successfully updated. ';
                $message .= '<a href="' . route_to('editCountry', $theId) . '">Continue editing?</a>';

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

        $this->viewData['country'] = $country;

        
        $theId = $id;
		$this->viewData['formAction'] = route_to('updateCountry', $theId);

        
        $this->displayForm(__METHOD__, $id);
    } // function edit(...)
}
