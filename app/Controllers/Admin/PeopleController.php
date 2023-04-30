<?php  namespace App\Controllers\Admin;


use App\Models\Admin\CityModel;
use App\Entities\Admin\Person;

class PeopleController extends \App\Controllers\GoBaseController { 

	use \CodeIgniter\API\ResponseTrait;

    protected static $primaryModelName = 'App\Models\Admin\PersonModel';

    protected static $singularObjectNameCc = 'person';
    protected static $singularObjectName = 'Person';
    protected static $pluralObjectName = 'People';
    protected static $controllerSlug = 'people';

    protected static $viewPath = 'admin/personViews/';

    protected $indexRoute = 'personList';

    

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger) {
        $this->viewData['pageTitle'] = lang('People.moduleTitle');
        parent::initController($request, $response, $logger);
                 $this->viewData['usingSweetAlert'] = true;

         if (session('errorMessage')) {
            $this->session->setFlashData('sweet-error', session('errorMessage'));
         }
         if (session('successMessage')) {
            $this->session->setFlashData('sweet-success', session('successMessage'));
         }
    }

    public function index() {
        
        $this->viewData['usingClientSideDataTable'] = true;
        
		 $this->viewData['personList'] = $this->model->findAllWithCities('*');

		$this->viewData['pageSubTitle'] = lang('Basic.global.ManageAllRecords', [lang('People.person')]);
        parent::index();

    }

    public function add() {
        
        

        $requestMethod = $this->request->getMethod();

        if ($requestMethod === 'post') :

            $nullIfEmpty = true; // !(phpversion() >= '8.1');

            $postData = $this->request->getPost();
			$sanitizedData = $this->sanitized($postData, $nullIfEmpty);


            $noException = true;
            $successfulResult = false; // for now
            

				if ($this->canValidate()) :
					try {
						$successfulResult = $this->model->skipValidation(true)->save($sanitizedData);
					} catch (\Exception $e) {
						$noException = false;
						$this->dealWithException($e);
					}
				else:
					$this->viewData['errorMessage'] = lang('Basic.global.formErr1', [mb_strtolower(lang('People.person'))]);
						$this->session->setFlashdata('formErrors', $this->model->errors());
				endif;
            
            $thenRedirect = true;  // Change this to false if you want your user to stay on the form after submission
            
            if ($noException && $successfulResult) :

                $id = $this->model->db->insertID();

                $message = lang('Basic.global.saveSuccess', [mb_strtolower(lang('People.person'))]).'.';
                $message .= anchor(route_to('editPerson', $id), lang('Basic.global.continueEditing').'?');
                $message = ucfirst(str_replace("'", "\'", $message));

                if ($thenRedirect) :
                    if (!empty($this->indexRoute)) :
                        return redirect()->to(route_to($this->indexRoute))->with('sweet-success', $message);
                    else:
                        return $this->redirect2listView('sweet-success', $message);
                    endif;
                else:
                    $this->session->setFlashData('sweet-success', $message);
                endif;

            endif; // $noException && $successfulResult

        endif; // ($requestMethod === 'post')

        $this->viewData['person'] = isset($sanitizedData) ? new Person($sanitizedData) : new Person();
		$this->viewData['cityList'] = $this->getCityListItems($person->city_id ?? null);
		$this->viewData['sexList'] = $this->getSexOptions();
		$this->viewData['personTypeList'] = $this->getPersonTypeOptions();

        $this->viewData['formAction'] = route_to('createPerson');

        $this->viewData['boxTitle'] = lang('Basic.global.addNew').' '.lang('People.person').' '.lang('Basic.global.addNewSuffix');
        

        return $this->displayForm(__METHOD__);
    } // end function add()

    public function edit($requestedId = null) {
        
        if ($requestedId == null) :
            return $this->redirect2listView();
        endif;
        $id = filter_var($requestedId, FILTER_SANITIZE_URL);
        $person = $this->model->find($id);

        if ($person == false) :
            $message = lang('Basic.global.notFoundWithIdErr', [mb_strtolower(lang('People.person')), $id]);
            return $this->redirect2listView('sweet-error', $message);
        endif;

        $requestMethod = $this->request->getMethod();

        if ($requestMethod === 'post') :

            $nullIfEmpty = true; // !(phpversion() >= '8.1');
        
            $postData = $this->request->getPost();
            			$sanitizedData = $this->sanitized($postData, $nullIfEmpty);
            if ($this->request->getPost('is_friend') == null ) {
                $sanitizedData['is_friend'] = false;
            }
            if ($this->request->getPost('enabled') == null ) {
                $sanitizedData['enabled'] = false;
            }


            
            $noException = true;
            $successfulResult = false; // for now
            
            

            	if ($this->canValidate()) :
            	    try {
            	        $successfulResult = $this->model->skipValidation(true)->update($id, $sanitizedData);
            	    } catch (\Exception $e) {
            	        $noException = false;
            	        $this->dealWithException($e);
            	    }
            	else:
            	    $this->viewData['warningMessage'] = lang('Basic.global.formErr1', [mb_strtolower(lang('People.person'))]);
            	    $this->session->setFlashdata('formErrors', $this->model->errors());
            	
            	endif;
            	
            	$person->fill($sanitizedData);

            	$thenRedirect = true;
            
            if ($noException && $successfulResult) :
                $id = $person->id ?? $id;
                $message = lang('Basic.global.updateSuccess', [mb_strtolower(lang('People.person'))]).'.';
                $message .= anchor(route_to('editPerson', $id), lang('Basic.global.continueEditing').'?');
                $message = ucfirst(str_replace("'", "\'", $message));

                if ($thenRedirect) :
                    if (!empty($this->indexRoute)) :
                        return redirect()->to(route_to($this->indexRoute))->with('sweet-success', $message);
                    else:
                        return $this->redirect2listView('sweet-success', $message);
                    endif;
                else:
                    $this->session->setFlashData('sweet-success', $message);
                endif;
        
            endif; // $noException && $successfulResult
        endif; // ($requestMethod === 'post')

        $this->viewData['person'] = $person;
		$this->viewData['cityList'] = $this->getCityListItems($person->city_id ?? null);
		$this->viewData['sexList'] = $this->getSexOptions();
		$this->viewData['personTypeList'] = $this->getPersonTypeOptions();

        $this->viewData['formAction'] = route_to('updatePerson', $id);

        $this->viewData['boxTitle'] = lang('Basic.global.edit2').' '.lang('People.person').' '.lang('Basic.global.edit3');
        
        
        return $this->displayForm(__METHOD__, $id);
    } // end function edit(...)
    
    

    public function allItemsSelect() {
        if ($this->request->isAJAX()) {
            $onlyActiveOnes = true;
            $reqVal = $this->request->getPost('val') ?? 'id';
            $menu = $this->model->getAllForMenu($reqVal.', email_address', 'email_address', $onlyActiveOnes, false);
            $nonItem = new \stdClass;
            $nonItem->id = '';
            $nonItem->email_address = '- '.lang('Basic.global.None').' -';
            array_unshift($menu , $nonItem);

            $newTokenHash = csrf_hash();
            $csrfTokenName = csrf_token();
            $data = [
                'menu' => $menu,
                $csrfTokenName => $newTokenHash
            ];
            return $this->respond($data);
        } else {
            return $this->failUnauthorized('Invalid request', 403);
        }
    }
    
    public function menuItems() {
        if ($this->request->isAJAX()) {
            $searchStr = goSanitize($this->request->getPost('searchTerm'))[0];
            $reqId = goSanitize($this->request->getPost('id'))[0];
            $reqText = goSanitize($this->request->getPost('text'))[0];
            $onlyActiveOnes = false;
            $columns2select = [$reqId ?? 'id', $reqText ?? 'email_address'];
            $onlyActiveOnes = false;
            $menu = $this->model->getSelect2MenuItems($columns2select, $columns2select[1], $onlyActiveOnes, $searchStr);
            $nonItem = new \stdClass;
            $nonItem->id = '';
            $nonItem->text = '- '.lang('Basic.global.None').' -';
            array_unshift($menu , $nonItem);

            $newTokenHash = csrf_hash();
            $csrfTokenName = csrf_token();
            $data = [
                'menu' => $menu,
                $csrfTokenName => $newTokenHash
            ];
            return $this->respond($data);
        } else {
            return $this->failUnauthorized('Invalid request', 403);
        }
    }
        

	protected function getCityListItems($selId = null) { 
		$data = [''=>lang('Basic.global.pleaseSelectA', [mb_strtolower(lang('Cities.city'))])];
        if (!empty($selId)) :
            	$cityModel = model('App\Models\Admin\CityModel');

            $selOption = $cityModel->where('id', $selId)->findColumn('city_name');
            if (!empty($selOption)) :
                $data[$selId] = $selOption[0];
            endif;
        endif;
		return $data;
	}


	protected function getSexOptions() { 
		$sexOptions = [ 
				'' => lang('Basic.global.pleaseSelect'),
				'F' => 'Female',
				'M' => 'Male',
				'N' => 'Non-binary',
				'U' => 'Unspecified',
			];
		return $sexOptions;
	}



	protected function getPersonTypeOptions() { 
		$personTypeOptions = [ 
				'' => lang('Basic.global.pleaseSelect'),
				'unspecified' => 'unspecified',
				'colleague' => 'colleague',
				'employee' => 'employee',
				'customer' => 'customer',
				'friend' => 'friend',
			];
		return $personTypeOptions;
	}


}
