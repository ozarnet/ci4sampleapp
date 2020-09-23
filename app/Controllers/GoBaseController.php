<?php

namespace App\Controllers;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 *
 * @package CodeIgniter
 */
use CodeIgniter\Controller;
use CodeIgniter\Database\Query;

// use App\Controllers\CodeIgniter\Database\Query;

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
    protected $helpers = ['session', 'go_common']; // $helpers = ['session', 'url', 'go_common'];

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

        if ($this->usePageSubTitle) {
            $this->pageSubTitle = config('Basics')->appName;
            $this->viewData['pageSubTitle'] = ' in '.$this->pageSubTitle;
        }
        $this->viewData['errorMessage'] = $this->session->getFlashdata('errorMessage');
        $this->viewData['successMessage'] = $this->session->getFlashdata('successMessage');

        if (empty(static::$pluralObjectName)) {
            $reflect = new \ReflectionClass($this);
            $className = $reflect->getShortName();
            $this->viewData['currentModule'] = $className;
        } else {
            $this->viewData['currentModule'] = ucfirst(strtolower(static::$pluralObjectName));
        }

        $this->viewData['viewPath'] = static::$viewPath;

        if (!empty(static::$primaryModelName)) {
            $primaryModel = model(static::$primaryModelName, true);
            $this->primaryModel = $primaryModel;
        }
    }

    public function index() {

        if ((!isset($this->viewData['pageTitle']) || empty($this->viewData['pageTitle']) ) && isset(static::$pluralObjectName) && !empty(static::$pluralObjectName)) {
            $this->viewData['pageTitle'] = ucfirst(static::$pluralObjectName);
        }

        if (isset($this->primaryModel) && isset(static::$singularObjectNameCc) && !empty(static::$singularObjectNameCc) && !isset($this->viewData[(static::$singularObjectNameCc) . 'List'])) {
            $this->viewData[(static::$singularObjectNameCc) . 'List'] = $this->primaryModel->asObject()->findAll();
        }

        if ($this->isBackEnd) {
            $this->viewData['usingDataTables'] = true;
        }

        // if $this->currentView is assigned a view name, use it, otherwise assume the view something like 'view_singleobject_list'
        $viewFilePath = static::$viewPath . (empty($this->currentView) ? 'view' . ucfirst(static::$singularObjectNameCc) . 'List' : $this->currentView);
        // var_dump($viewFilePath);
        echo view($viewFilePath, $this->viewData);
    }

    protected function redirect2listView($flashDataKey = null, $flashDataValue = null) {

        if ($this->viewData['currentModule']) {
            $uri = '/' . strtolower($this->viewData['currentModule']);
        } elseif (isset(static::$pluralObjectNameSc) && !empty(static::$pluralObjectNameSc)) {
            $uri = '/' . static::$controllerPath . static::$pluralObjectNameSc;
        } else {
            $uri = '/';
        }
        if ($flashDataKey != null && $flashDataValue != null) {
            return redirect()->to($uri)->with($flashDataKey, $flashDataValue);
        } else {
            return redirect()->to($uri);
        }
    }

    protected function displayForm($forMethod, $objId = null) {

        helper('form');
        $this->viewData['usingSelect2'] = true;
        
        $validation =  \Config\Services::validation();

        $action = str_replace(static::class . '::', '', $forMethod);
        $actionSuffix = ' ';
        $formActionSuffix = '';

        if ($action === 'add') {
            $actionSuffix = ' a New ';
        } elseif ($action === 'edit' && $objId != null) {
            $formActionSuffix = $objId . '/';
        }

        $this->viewData['action'] = $action;
        $this->viewData['formAction'] = base_url(strtolower($this->viewData['currentModule'])  . '/' . $action . '/' . $formActionSuffix);

        $this->viewData['pageTitle'] = ucfirst($action) . $actionSuffix . ucfirst(static::$singularObjectName);
        
        $this->viewData['validation'] = $validation;

        $viewFilePath = static::$viewPath . 'view' . static::$singularObjectNameCc . 'Form';

        echo view($viewFilePath, $this->viewData);
    }

    public function delete($requestedId, bool $deletePermanently = true) {

        if (is_string($requestedId)) :
            if (is_numeric($requestedId)) :
                $id = filter_var($requestedId, FILTER_SANITIZE_NUMBER_INT);
            else:
                $onlyAlphaNumeric = true;
                $fromGetRequest = true;
                $idSanitization = goSanitize($requestedId, $onlyAlphaNumeric, $fromGetRequest); // filter_var(trim($requestedId), FILTER_SANITIZE_STRING);
                $id = $idSanitization[0];
            endif;
        else:
            $id = intval($requestedId);
        endif;

        if (empty($id) || $id === 0) :
            $error = 'Invalid identifier provided to delete object.';
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
                log_message('error', "GO Exception: Error deleting object id $id :\r\n".$e->getMessage());
            }
        endif;

        $ar = $this->primaryModel->db->affectedRows();
        
        $dbError = $this->primaryModel->db->error();
        if (!empty($dbError['message'])) {
            // var_dump($countryModel->db->error());
            log_message('error', $this->primaryModel->db->error());
        }

        $result = ['persisted'=>$ar>0, 'ar'=>$ar, 'persistedId'=>null, 'affectedRows'=>$ar, 'errorCode'=>$dbError['code'], 'error'=>$dbError['message']];
        
        if ($ar < 1) :
            $errorMessage = 'No ' . static::$singularObjectName . ' was deleted now, because it probably had already been deleted.';
            return $this->redirect2listView('errorMessage', $errorMessage);
        else:
            $message = 'The ' . static::$singularObjectName . ' was successfully deleted.';
            
            if ($result['affectedRows']>1) :
                log_message('warning', "More than one row has been deleted in attempt to delete object id: $id");
            endif;
            return $this->redirect2listView('successMessage', $message);
        endif;

        var_dump("BaseController.delete(...) fell into a black hole here.");
    }

    protected function canValidate() {
        
        $validationRules = $this->formValidationRules ?? null;
        
        if ($validationRules == null) {
            return true;
        }
        
        $validationErrors = $this->formValidationErrors ?? null;;

        $validation =  \Config\Services::validation();
        
        // $validation->setRules($validationRules, $validationErrors)

        if ($validationErrors!=null) {
            $valid = $this->validate($validationRules, $validationErrors);
        } else {
            $valid = $this->validate($validationRules);
        }

        if (!$valid) {

            $this->viewData['errorMessage'] .= $validation->listErrors();
        }
        return $valid;
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
