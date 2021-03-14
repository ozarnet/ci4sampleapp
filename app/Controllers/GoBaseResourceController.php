<?php


namespace App\Controllers;


use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

abstract class GoBaseResourceController extends \CodeIgniter\RESTful\ResourceController
{
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
     * Path for the views directory for the extending view controller
     * 
     * @var string 
     */
    protected static $viewPath;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = ['session', 'go_common', 'form'];

    /**
     * Initializer method.
     *
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @param LoggerInterface $logger
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);

        $this->session = \Config\Services::session();

        if ((!isset($this->viewData['pageTitle']) || empty($this->viewData['pageTitle'])) && isset(static::$pluralObjectName) && !empty(static::$pluralObjectName)) {
            $this->viewData['pageTitle'] = ucfirst(static::$pluralObjectName);
        }

        if ($this->usePageSubTitle) {
            $this->pageSubTitle = config('Basics')->appName;
            $this->viewData['pageSubTitle'] = ' in ' . $this->pageSubTitle;
        }
        $this->viewData['errorMessage'] = $this->session->getFlashdata('errorMessage');
        $this->viewData['successMessage'] = $this->session->getFlashdata('successMessage');

        if (isset(static::$controllerSlug) && empty(static::$controllerSlug)) {
            $reflect = new \ReflectionClass($this);
            $className = $reflect->getShortName();
            $this->viewData['currentModule'] = slugify(convertToSnakeCase(str_replace('Controller', '', $className)));

        } else {
            $this->viewData['currentModule'] = strtolower(static::$controllerSlug);
        }

        $this->viewData['usingSweetAlert'] = true;

        $this->viewData['viewPath'] = static::$viewPath;
    }

    protected function displayForm($forMethod, $objId = null)
    {

        helper('form');
        $this->viewData['usingSelect2'] = true;

        $validation = \Config\Services::validation();

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
            $this->viewData['formAction'] = base_url(strtolower($this->viewData['currentModule']) . '/' . $formActionSuffix . '/' . $action );
        }

        if ((!isset($this->viewData['boxTitle']) || empty($this->viewData['boxTitle'])) && isset(static::$singularObjectName) && !empty(static::$singularObjectName)) {
            $this->viewData['boxTitle'] = ucfirst($action) . $actionSuffix . ucfirst(static::$singularObjectName);
        }

        $this->viewData['validation'] = $validation;

        $viewFilePath = static::$viewPath . 'view' . ucfirst(static::$singularObjectNameCc) . 'Form';

        echo view($viewFilePath, $this->viewData);
    }

    protected function redirect2listView($flashDataKey = null, $flashDataValue = null)
    {

        if (isset($this->indexRoute) && !empty($this->indexRoute)) {
            $uri = base_url(route_to($this->indexRoute));
        } else {

            $reflect = new \ReflectionClass($this);
            $className = $reflect->getShortName();

            $routes = \Config\Services::routes();
            $routesOptions = $routes->getRoutesOptions();

            if (isset(static::$controllerSlug) && !empty(static::$controllerSlug)) {

                if (isset($routesOptions[static::$controllerSlug])) {
                    $namedRoute = $routesOptions[static::$controllerSlug]['as'];
                    $uri = route_to($namedRoute);
                } else {
                    $getHandlingRoutes = $routes->getRoutes('get');

                    $indexMethod = array_search('\\App\\Controllers\\' . $className . '::index', $getHandlingRoutes);
                    if ($indexMethod) {
                        $uri = route_to('App\\Controllers\\' . $className . '::index');
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

    /**
     * Delete the designated resource object from the model.
     *
     * @param int $id
     *
     * @return array an array
     */
    public function delete($id = null)
    {
        if (!$this->model->delete($id)) {
            return $this->failNotFound('No ' . static::$singularObjectName . ' could be deleted now, because it was probably deleted already or it did not exist.');
        }

        return $this->respondDeleted(['id' => $id], 'The ' . static::$singularObjectName . ' was successfully deleted.');
    }


    

    protected function canValidate()
    {

        $validationRules = $this->formValidationRules ?? null;

        if ($validationRules == null) {
            return true;
        }

        $validationErrors = $this->formValidationErrors ?? null;

        $validation = \Config\Services::validation();

        // $validation->setRules($validationRules, $validationErrors)

        if ($validationErrors != null) {
            $valid = $this->validate($validationRules, $validationErrors);
        } else {
            $valid = $this->validate($validationRules);
        }

        /* // As of version 1.1.5 of CodeIgniter Wizard, the following is replaced by custom validation errors template supported by CodeIgniter 4
        if (!$valid) {
            $this->viewData['errorMessage'] .= $validation->listErrors();
        }
        */
        return $valid;
    }
}