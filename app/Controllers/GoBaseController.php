<?php

namespace App\Controllers;

/**
 * Class GoBaseController
 *
 * GoBaseController is an extension of BaseController class that 
 * provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends GoBaseController
 *
 * For security be sure to declare any new methods as protected or private.
 *
 * @package CodeIgniter
 */
use CodeIgniter\Controller;
use CodeIgniter\Database\Query;


abstract class GoBaseController extends Controller {

    /**
     *
     * @var string
     */
    public $pageTitle;

    /**
     * Additional string to display after page title
     * 
     * @var string
     */
    public $pageSubTitle;

    /**
     *
     * @var boolean
     */
    protected $usePageSubTitle = true;

    /**
     * Whether this is a front-end controller
     * 
     * @var boolean 
     */
    protected $isFrontEnd = false;

    /**
     * Whether this is a back-end controller
     * 
     * @var boolean 
     */
    protected $isBackEnd = false;

    /**
     * Name of the primary Model class
     * 
     * @var string
     */
    protected static $primaryModelName;
    protected static $modelPath = '';

    /**
     * Singular noun of primary object
     * 
     * @var string 
     */
    protected static $singularObjectName;

    /**
     * Plural form of primary object name
     * 
     * @var string 
     */
    protected static $pluralObjectName;

    /** 
     * Singular object name in camel case
     */
    protected static $singularObjectNameCc = 'record';

    /**
     * Current error message to obtain from session flash data
     * 
     * @var string 
     */
    protected $errorMessage;

    /**
     * Current success message to obtain from session flash data
     * 
     * @var string 
     */
    protected $successMessage;

    /**
     * Refactored class-wide data array variable
     * 
     * @var array
     */
    public $viewData;
    
    public $currentAction;

    /**
     * Path of the views directory for this controller
     * 
     * @var string 
     */
    protected static $viewPath;
    protected $currentView;
    protected static $controllerPath = '';

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = ['session', 'go_common', 'text']; 

    public static $queries = [];

    /**
     * Constructor.
     */
    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger) {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        //--------------------------------------------------------------------
        // Preload any models, libraries, etc, here.
        //--------------------------------------------------------------------
        // E.g.:
        $this->session = \Config\Services::session();

        if ((!isset($this->viewData['pageTitle']) || empty($this->viewData['pageTitle']) ) && isset(static::$pluralObjectName) && !empty(static::$pluralObjectName)) {
            $this->viewData['pageTitle'] = ucfirst(static::$pluralObjectName);
        }

        if ($this->usePageSubTitle) {
            $this->pageSubTitle = config('Basics')->appName;
            $this->viewData['pageSubTitle'] = ' '.$this->pageSubTitle;
        }
        $this->viewData['errorMessage'] = $this->session->getFlashdata('errorMessage');
        $this->viewData['successMessage'] = $this->session->getFlashdata('successMessage');

        if (empty(static::$controllerSlug)) {
            $reflect = new \ReflectionClass($this);
            $className = $reflect->getShortName();
            $this->viewData['currentModule'] = slugify(convertToSnakeCase(str_replace('Controller','',$className)));

        } else {
            $this->viewData['currentModule'] = strtolower(static::$controllerSlug);
        }

        $this->viewData['viewPath'] = static::$viewPath;

        if (!empty(static::$primaryModelName)) {
            $primaryModel = model(static::$primaryModelName, true);
            $this->primaryModel = $primaryModel;
            $this->model = &$this->primaryModel;
        }
        
        $this->viewData['currentLocale'] = $this->request->getLocale();

    }

    public function index() {

        helper('text');

        if ((!isset($this->viewData['boxTitle']) || empty($this->viewData['boxTitle']) ) && isset(static::$pluralObjectName) && !empty(static::$pluralObjectName)) {
            $this->viewData['boxTitle'] = ucfirst(static::$pluralObjectName);
        }

        if (isset($this->primaryModel) && isset(static::$singularObjectNameCc) && !empty(static::$singularObjectNameCc) && !isset($this->viewData[(static::$singularObjectNameCc) . 'List'])) {
            $this->viewData[(static::$singularObjectNameCc) . 'List'] = $this->primaryModel->asObject()->findAll();
        }

        // if $this->currentView is assigned a view name, use it, otherwise assume the view something like 'viewSingleObjectList'
        $viewFilePath = static::$viewPath . (empty($this->currentView) ? 'view' . ucfirst(static::$singularObjectNameCc) . 'List' : $this->currentView);
    
        echo view($viewFilePath, $this->viewData);
    }

    /**
     * Convenience method to display the form of a module
     * @param $forMethod
     * @param null $objId
     * @return string
     */
    protected function displayForm($forMethod, $objId = null) {

        helper('form');
        $this->viewData['usingSelect2'] = true;
        
        $validation =  \Config\Services::validation();

        $action = str_replace(static::class . '::', '', $forMethod);
        $actionSuffix = ' ';
        $formActionSuffix = '';

        if ($action === 'add') {
            $actionSuffix = empty(static::$singularObjectName) || stripos(static::$singularObjectName, 'new') === false ? ' a New ' : ' ';
        } elseif ($action === 'edit' && $objId != null) {
            $formActionSuffix = $objId . '/';
        }

        if (!isset($this->viewData['action'])) {
            $this->viewData['action'] = $action;
        }

        if (!isset($this->viewData['formAction'])) {
            $this->viewData['formAction'] = base_url(strtolower($this->viewData['currentModule'])  . '/' . $action . '/' . $formActionSuffix);
        }

        if ((!isset($this->viewData['boxTitle']) || empty($this->viewData['boxTitle']) ) && isset(static::$singularObjectName) && !empty(static::$singularObjectName)) {
            $this->viewData['boxTitle'] = ucfirst($action) . $actionSuffix . ucfirst(static::$singularObjectName);
        }
        
        $this->viewData['validation'] = $validation;

        $viewFilePath = static::$viewPath . 'view' . ucfirst(static::$singularObjectNameCc) . 'Form';

        return view($viewFilePath, $this->viewData);
    }

    protected function redirect2listView($flashDataKey = null, $flashDataValue = null) {

        if (!empty($this->indexRoute)) {
            $uri = base_url(route_to($this->indexRoute));
        } else {

            $reflect = new \ReflectionClass($this);
            $className = $reflect->getShortName();

            $routes = \Config\Services::routes();
            $routesOptions = $routes->getRoutesOptions();

            if (!empty(static::$controllerSlug)) {

                if (isset($routesOptions[static::$controllerSlug])) {
                    $namedRoute = $routesOptions[static::$controllerSlug]['as'];
                    $uri = route_to($namedRoute);
                } else {
                    $getHandlingRoutes = $routes->getRoutes('get');

                    $indexMethod = array_search('\\App\\Controllers\\'.$className.'::index', $getHandlingRoutes);
                    if ($indexMethod) {
                        $uri = route_to('App\\Controllers\\'.$className.'::index');
                    } else {
                        $uri = base_url(static::$controllerSlug);
                    }
                }
            } else {
                $uri = base_url($className);
            }
        }
        
        if ($flashDataKey != null && $flashDataValue != null) {
            return redirect()->to($uri)->with($flashDataKey, $flashDataValue);
        } else {
            return redirect()->to($uri);
        }
    }

    public function delete($requestedId, bool $deletePermanently = true) {

        if (is_string($requestedId)) :
            if (is_numeric($requestedId)) :
                $id = filter_var($requestedId, FILTER_SANITIZE_NUMBER_INT);
            else:
                $onlyAlphaNumeric = true;
                $fromGetRequest = true;
                $idSanitization = goSanitize($requestedId, $onlyAlphaNumeric, $fromGetRequest); // filter_var(trim($requestedId), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $id = $idSanitization[0];
            endif;
        else:
            $id = intval($requestedId);
        endif;

        if (empty($id) || $id === 0) :
            $error = 'Invalid identifier provided to delete the object.';
        endif;

        $rawResult = null;

        if (!isset($error)) :
            try {
            if ($deletePermanently) :
                if (is_numeric($id)) :
                    $rawResult = $this->primaryModel->delete($id);
                else:
                    $rawResult = $this->primaryModel->where($this->primaryModel->getPrimaryKeyName(), $id)->delete();
                endif;
            else:
                $rawResult = $this->primaryModel->update($id, ['deleted' => true]);
            endif;
            } catch (\Exception $e) {
                log_message('error', "Exception: Error deleting object named '".(static::$singularObjectName ?? 'unknown')."' with  $id :\r\n".$e->getMessage());
            }
        endif;

        $ar = $this->primaryModel->db->affectedRows();
        
        try {
            $dbError = $this->primaryModel->db->error();
        } catch (\Exception $e2) {
            if ($e2->getMessage() != "Trying to get property 'errno' of non-object") {
               log_message('error', $e2->getCode() . ' : ' . $e2->getMessage()) ;
            }
        }
        if (isset($dbError['code']) && isset($dbError['message'])) {
            log_message('error', $dbError['code'].' '.$dbError['message']);
        } else {
            $dbError = ['code' => '', 'message'=>''];
        }

        $result = ['persisted'=>$ar>0, 'ar'=>$ar, 'persistedId'=>null, 'affectedRows'=>$ar, 'errorCode'=>$dbError['code'], 'error'=>$dbError['message']];
        
        $nameOfDeletedObject = static::$singularObjectNameCc;
        
        if ($ar < 1) :
            $errorMessage = lang('Basic.global.deleteError', [$nameOfDeletedObject]); // 'No ' . static::$singularObjectName . ' was deleted now, because it probably had already been deleted.';
            $fdKey = isset($this->viewData['usingSweetAlert'] ) && $this->viewData['usingSweetAlert'] ? 'sweet-error' : 'errorMessage';
            $errorMessage = str_replace("'", "\'", $errorMessage);
            return $this->redirect2listView($fdKey, str_replace("'", '', $errorMessage));
        else:
            $message = lang('Basic.global.deleteSuccess', [$nameOfDeletedObject]); // 'The ' . static::$singularObjectName . ' was successfully deleted.';
            $fdKey = isset($this->viewData['usingSweetAlert'] ) && $this->viewData['usingSweetAlert'] ? 'sweet-success' : 'successMessage';
            if ($result['affectedRows']>1) :
                log_message('warning', "More than one row has been deleted in attempt to delete row for object named '".(static::$singularObjectName ?? 'unknown')."' with id: $id");
            endif;
            $message = str_replace("'", "\'", $message);
            return $this->redirect2listView($fdKey, $message);
        endif;

    }

   /**
     * Convenience method to validate form submission
     * @return bool
     */
    protected function canValidate()
    {

        $validationRules = $this->model->validationRules ?? $this->formValidationRules ?? null;

        if ($validationRules == null) {
            return true;
        }

        $validationErrorMessages = $this->model->validationMessages ??  $this->formValidationErrorMessagess ?? null;;

        if ($validationErrorMessages != null) {
            $valid = $this->validate($validationRules, $validationErrorMessages);
        } else {
            $valid = $this->validate($validationRules);
        }
        
        $this->validationErrors = $valid ? '' : $this->validator->getErrors();

        /*
        // As of version 1.1.5 of CodeIgniter Wizard, the following is replaced by custom validation errors template supported by CodeIgniter 4
        // If you are not using Bootstrap templates, however, you might want to uncomment this block...
        $validation =  \Config\Services::validation();
        $this->validation = $validation;
        if (!$valid) {
            $this->viewData['errorMessage'] .= $validation->listErrors();
        }
        */
        return $valid;
    }

    /**
     * Method for post(ed) input sanitization. Override this when you have custom transformation needs, etc.
     * @param array|null $postData
     * @return array
     */
    protected function sanitized(array $postData = null, bool $nullIfEmpty = false) {
        if ($postData == null) {
            $postData = $this->request->getPost();
        }
        $sanitizedData = [];
        foreach ($postData as $k => $v) {
            if ($k == csrf_token()) {
                continue;
            }
            $sanitizationResult = goSanitize($v, $nullIfEmpty);
            $sanitizedData[$k] = $sanitizationResult[0];
        }
        return $sanitizedData;
    }

    /**
     * Convenience method for common exception handling
     * @param \Exception $e
     */
    protected function dealWithException(\Exception $e) {
        // using another try / catch block to prevent to avoid CodeIgniter bug throwing trivial exceptions for querying DB errors
        try {
            $query = $this->model->db->getLastQuery();
            $queryStr = !is_null($query) ? $query->getQuery() : '';
            $dbError = $this->model->db->error();
            $userFriendlyErrMsg = lang('Basic.global.persistErr1', [static::$singularObjectNameCc]);
            if (isset($dbError['code']) && $dbError['code'] == 1062) :
                $userFriendlyErrMsg .= PHP_EOL.lang('Basic.global.persistDuplErr', [static::$singularObjectNameCc]);
            endif;
            // $userFriendlyErrMsg = str_replace("'", "\'", $userFriendlyErrMsg); // Uncomment if experiencing unescaped single quote errors
            log_message('error', $userFriendlyErrMsg.PHP_EOL.$e->getMessage().PHP_EOL.$queryStr);
            if (isset($dbError['message']) && !empty($dbError['message'])) :
                log_message('error', $dbError['code'].' : '.$dbError['message']);
            endif;
            $this->viewData['errorMessage'] = $userFriendlyErrMsg;
        } catch (\Exception $e2) {
            log_message('debug', 'You can probably safely ignore this: In attempt to check DB errors, CodeIgniter threw: '.PHP_EOL.$e2->getMessage());
        }
    }

    // Collect the queries so something can be done with them later.
    public static function collect(Query $query) {
        static::$queries[] = $query;
    }

    /**
     * Class casting
     *
     * @param string|object $destination
     * @param object $sourceObject
     * @return object
     */
    function cast($destination, $sourceObject) {
        if (is_string($destination)) {
            $destination = new $destination();
        }
        $sourceReflection = new ReflectionObject($sourceObject);
        $destinationReflection = new ReflectionObject($destination);
        $sourceProperties = $sourceReflection->getProperties();
        foreach ($sourceProperties as $sourceProperty) {
            $sourceProperty->setAccessible(true);
            $name = $sourceProperty->getName();
            $value = $sourceProperty->getValue($sourceObject);
            if ($destinationReflection->hasProperty($name)) {
                $propDest = $destinationReflection->getProperty($name);
                $propDest->setAccessible(true);
                $propDest->setValue($destination, $value);
            } else {
                $destination->$name = $value;
            }
        }
        return $destination;
    }

}
