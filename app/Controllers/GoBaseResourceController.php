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
    protected $helpers = ['session', 'go_common', 'form', 'text'];

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
            $this->viewData['pageSubTitle'] = ' ' . $this->pageSubTitle;
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
        
        $this->viewData['currentLocale'] = $this->request->getLocale();
    }

    /**
     * Convenience method to display the form of a module
     * @param $forMethod
     * @param null $objId
     * @return string
     */
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

        return view($viewFilePath, $this->viewData);
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
        if (!empty(static::$pluralObjectNameCc) && !empty(static::$singularObjectNameCc)) {
            $objName = mb_strtolower(lang(ucfirst(static::$pluralObjectNameCc).'.'.static::$singularObjectNameCc));
        } else {
            $objName = lang('Basic.global.record');
        }
        
        if (!$this->model->delete($id)) {
            return $this->failNotFound(lang('Basic.global.deleteError', [$objName]));
        }
        
        $message = lang('Basic.global.deleteSuccess', [$objName]);
        $response = $this->respondDeleted(['id' => $id, 'msg' => $message]);
        return $response;
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
     * Custom fail method needed when CSRF token regeneration is on in security settings
     * @param string|array $messages
     * @param int $status
     * @param string|null $code
     * @param string $customMessage
     * @return mixed
     */
    protected function failWithNewToken($messages, int $status = 400, string $code = null, string $customMessage = '') {

        if (! is_array($messages))
        {
            $messages = ['error' => $messages];
        }
        $response = [
            'status'   => $status,
            'error'    => $status,
            'messages' => $messages,
            csrf_token() => csrf_hash()
        ];

        return $this->respond($response, $status);
    }

    /**
     * Used when a specified resource cannot be found and send back a new CSRF token.
     *
     * @param string $description
     * @param string $code
     * @param string $message
     *
     * @return mixed
     */
    public function failNotFoundWithNewToken(string $description = 'Not Found', string $code = null, string $message = '')
    {
        return $this->failWithNewToken($description, $this->codes['resource_not_found'], $code, $message);
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
}