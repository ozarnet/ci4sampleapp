<?php

namespace App\Controllers;


use App\Models\CityModel;

use App\Models\PersonModel;
use App\Entities\Person;

class PeopleController extends GoBaseController
{

    protected static $primaryModelName = 'PersonModel';
    protected static $singularObjectName = 'Person';
    protected static $singularObjectNameCc = 'person';
    protected static $singularObjectNameSc = 'person';
    protected static $pluralObjectName = 'People';
    protected static $pluralObjectNameCc = 'people';
    protected static $pluralObjectNameSc = 'people';
    protected static $controllerSlug = 'people';

    protected static $viewPath = 'personViews/';

    protected $indexRoute = 'people';

    protected $formValidationRules = [
        'birth_date' => 'valid_date|permit_empty',
        'score' => 'decimal|permit_empty',
        'email_address' => 'trim|max_length[50]|valid_email|permit_empty',
        'notes' => 'trim|max_length[16313]',
        'phone_number' => 'trim|max_length[20]',
        'last_name' => 'trim|required|max_length[50]',
        'middle_name' => 'trim|max_length[40]',
        'first_name' => 'trim|required|max_length[40]',
        'sex' => 'trim',
        'person_type' => 'max_length[31]',
    ];

    public function index()
    {

        $this->viewData['usingClientSideDataTable'] = true;

        $this->viewData['personList'] = $this->primaryModel->findAllWithCities('*');

        parent::index();
    }

    public function add()
    {

        $personModel = $this->primaryModel; // = new PersonModel();

        $requestMethod = $this->request->getMethod();

        if ($requestMethod === 'post') :

            $postData = $this->request->getPost();
            $sanitizedData = [];

            foreach ($postData as $k => $v) :
                $sanitizationResult = goSanitize($v);
                $sanitizedData[$k] = $sanitizationResult[0];
            endforeach;

            $person = new Person($sanitizedData);


            $noException = true;

            $formValid = $this->canValidate();

            if ($formValid) :
                try {
                    $successfulResult = $personModel->save($person);
                } catch (\Exception $e) {
                    $noException = false;
                    $successfulResult = false;
                    $query = $this->primaryModel->db->getLastQuery()->getQuery();
                    $dbError = $this->primaryModel->db->error();
                    $userFriendlyErrMsg = 'An error occurred in an attempt to save a new ' . static::$singularObjectName . ' to the database : ';
                    if ($dbError['code'] == 1062) :
                        $userFriendlyErrMsg .= PHP_EOL . 'There is an existing ' . static::$singularObjectName . ' on our database with the same data.';
                    endif;
                    $result['error'] = $userFriendlyErrMsg;
                    log_message('error', $userFriendlyErrMsg . PHP_EOL . $e->getMessage() . PHP_EOL . $query);
                    if (!empty($dbError['message'])) :
                        log_message('error', $dbError['code'] . ' : ' . $dbError['message']);
                        $result['error'] .= '<br><br>' . $dbError['code'] . ' : ' . $dbError['message'];
                    endif;
                }
            else :
                $successfulResult = false;
                $this->viewData['errorMessage'] .= "The errors on the form need to be corrected: ";
            endif;

            // if ($formValid && !$successfulResult && !is_numeric($person->{$this->primaryModel->getPrimaryKeyName()}) && $noException) :
            if ($formValid && !$successfulResult && $noException) :
                $successfulResult = true; // Work around CodeIgniter bug returning falsy value from insert operation in case of alpha-numeric PKs
            endif;

            $thenRedirect = true;

            if ($successfulResult) :

                $insertedId = $this->primaryModel->db->insertID();
                $theId = $insertedId;

                $message = 'The ' . strtolower(static::$singularObjectName) . ' was successfully saved' . (empty($this->primaryModel::$labelField) ? 'with name <i>' . $person->{$this->primaryModel::$labelField} . '</i>' : '') . '. ';
                $message .= anchor(route_to('editPerson', $theId), 'Continue editing?');

                if ($thenRedirect) :
                    if (!empty($this->indexRoute)) :
                        return redirect()->to(route_to($this->indexRoute))->with('successMessage', $message);
                    else :
                        return $this->redirect2listView('successMessage', $message);
                    endif;
                else :
                    $this->viewData['successMessage'] = $message;
                endif;
            else :
                if (!$formValid) :
                    $this->viewData['errorMessage'] .= 'The ' . strtolower(static::$singularObjectName) . ' was not saved due to an erroneous value entered on the form. ';
                else :
                    $this->viewData['errorMessage'] .= 'The ' . strtolower(static::$singularObjectName) . ' was not saved because of an error. ';
                endif;
                if (!empty($result['error'])) :
                    $this->viewData['errorMessage'] = (!empty($this->viewData['errorMessage']) ? $this->viewData['errorMessage'] . '<br>' : '') . $result['error'];
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

    public function edit($requestedId = null)
    {

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

            if ($this->request->getPost('enabled') == null) {
                $sanitizedData['enabled'] = false;
            }


            $noException = true; // for now

            $formValid = $this->canValidate();

            if ($formValid) :
                try {
                    $successfulResult = $this->primaryModel->update($id, $sanitizedData);
                } catch (\Exception $e) {
                    $noException = false;
                    $successfulResult = false;
                    $query = $this->primaryModel->db->getLastQuery()->getQuery();
                    $dbError = $this->primaryModel->db->error();
                    $userFriendlyErrMsg = 'An error occurred in an attempt to update the ' . static::$singularObjectName . ' with ID ' . $id . ' to the database : ';
                    if ($dbError['code'] == 1062) :
                        $userFriendlyErrMsg .= PHP_EOL . 'There is an existing ' . static::$singularObjectName . ' on our database with the same data.';
                    endif;
                    $result['error'] = $userFriendlyErrMsg;
                    log_message('error', $userFriendlyErrMsg . PHP_EOL . $e->getMessage() . PHP_EOL . $query);
                    if (!empty($dbError['message'])) :
                        log_message('error', $dbError['code'] . ' : ' . $dbError['message']);
                        $result['error'] .= '<br><br>' . $dbError['code'] . ' : ' . $dbError['message'];
                    endif;
                }
            else :
                $successfulResult = false;
                $this->viewData['errorMessage'] .= "The errors on the form need to be corrected: ";
            endif;

            $person = $person->mergeAttributes($sanitizedData);

            $thenRedirect = true;

            if ($successfulResult) :
                $theId = $person->id;
                $message = 'The ' . strtolower(static::$singularObjectName) . (!empty($this->primaryModel::$labelField) ? ' named <b>' . $person->{$this->primaryModel::$labelField} . '</b>' : '');
                $message .= ' was successfully updated. ';
                $message .= anchor(route_to('editPerson', $theId), 'Continue editing?');

                if ($thenRedirect) :
                    if (!empty($this->indexRoute)) :
                        return redirect()->to(route_to($this->indexRoute))->with('successMessage', $message);
                    else :
                        return $this->redirect2listView('successMessage', $message);
                    endif;
                else :
                    $this->viewData['successMessage'] = $message;
                endif;
            else : // ($successfulResult == false)
                if (!$formValid) :
                    $this->viewData['errorMessage'] .= 'The ' . strtolower(static::$singularObjectName) . ' was not saved due to an erroneous value entered on the form. ';
                else :
                    $this->viewData['errorMessage'] .= 'The ' . strtolower(static::$singularObjectName) . ' was not saved because of an error. ';
                endif;
                if (!empty($result['error'])) :
                    $this->viewData['errorMessage'] = (!empty($this->viewData['errorMessage']) ? $this->viewData['errorMessage'] . '<br>' : '') . $result['error'];
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

    protected function getCityListItems()
    {
        $cityModel = new CityModel();
        $onlyActiveOnes = true;
        $data = $cityModel->getAllForMenu('id, city_name', 'city_name', $onlyActiveOnes);

        return $data;
    }



    protected function getSexOptions()
    {
        $sexOptions = [
            '' => 'Please select...',
            'F' => 'Female',
            'M' => 'Male',
        ];
        return $sexOptions;
    }



    protected function getPersonTypeOptions()
    {
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
