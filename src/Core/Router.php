<?php
/**
 * Base64Cypher.php
 *
 * @author Artem Kaplenko
 * @since 0.0.1
 * @version 0.0.1
 */

namespace RestCore\Core;

use RestCore\Core\Enums\HttpMethods;
use RestCore\Core\General\ActionAttribute;
use RestCore\Core\General\Cyphers\Base64Cypher;
use RestCore\Core\General\Cyphers\OpenSSLCypher;
use RestCore\Core\General\Cyphers\SimpleCypher;
use RestCore\Core\General\Param;
use RestCore\Core\Helpers\ReflectionHelper;
use RestCore\Core\Helpers\UrlHelper;
use RestCore\Core\Interfaces\ControllerInterface;
use RestCore\Core\Interfaces\CypherInterface;
use RestCore\Exceptions\ActionNotFoundException;
use RestCore\Exceptions\BadArgumentsException;
use RestCore\Exceptions\BadPathException;
use RestCore\Exceptions\ControllerNotFoundException;
use RestCore\Exceptions\MethodNotAllowedException;

/**
 * Class Router
 * @package RestCore\Core
 */
class Router
{
    /**
     * Method of current RestFull Api request
     * @var string
     */
    protected $method = HttpMethods::GET;

    /**
     * Cache for reflection method
     * @var \ReflectionMethod
     */
    protected $action;

    /**
     * Container for router configuration
     * @var Param
     */
    protected $config;

    /**
     * Cyp
     * @var CypherInterface
     */
    protected $cypher;


    /**
     * Const with cypthers aliases
     */
    const CYPHERS = [
        'base64' => Base64Cypher::class,
        'openssl' => OpenSSLCypher::class,
        'simple' => SimpleCypher::class,
    ];

    /**
     * @param array $config
     * @return string
     * @throws \ReflectionException
     * @throws ActionNotFoundException
     * @throws BadArgumentsException
     * @throws BadPathException
     * @throws ControllerNotFoundException
     * @throws MethodNotAllowedException
     */
    public function route(array $config = [])
    {
        $this->config = new Param($config);
        // get data from SERVER global variable
        $server = new Param($_SERVER);

        // encoding, cypher
        $cypher = $this->config->get('cypher');
        if (null !== $cypher) {
            if (array_key_exists($cypher, static::CYPHERS)) {
                $cypher = static::CYPHERS[$cypher];
            }
            if (!class_exists($cypher)) {
                throw new BadPathException('Cypher does not exists');
            }
            $this->cypher = new $cypher($this->config->get('cypherParams', []));
            if (!($this->cypher instanceof CypherInterface)) {
                throw new BadPathException('Cypher does not implements CypherInterface');
            }
        } else {
            $this->cypher = new SimpleCypher();
        }

        // get data, path and request method
        $this->method = strtoupper($server->get('REQUEST_METHOD', HttpMethods::GET));
        $data = $this->getRequestDataByMethod($this->method);
        $path = $server->get('REQUEST_URI', DIRECTORY_SEPARATOR);

        // parse url for get controller class name
        $url = parse_url($path);
        if ($url) {
            $url = $url['path'];
        }

        // custom url processing
        $url = $this->processRoutes($url);

        $url = explode(DIRECTORY_SEPARATOR, $url);
        // If the minimum required path is not passed
        if (count($url) < 2) {
            throw new BadPathException('Minimum 3 parts in path required');
        }
        unset($url[0]);

        $controller = 'App\\Controller';
        $action = lcfirst(UrlHelper::dashToCamelCase(array_pop($url)));

        foreach ($url as $urlPart) {
            $controller .= '\\' . UrlHelper::dashToCamelCase($urlPart);
        }

        // check for availability
        if (!class_exists($controller)) {
            throw new ControllerNotFoundException('Controller ' . $controller . ' not found');
        }
        $controller = new $controller;
        if (!($controller instanceof ControllerInterface)) {
            throw new ControllerNotFoundException('Controller ' . $controller . ' not found');
        }
        if (!method_exists($controller, $action)) {
            throw new ActionNotFoundException('Action ' . $action . ' not found');
        }

        // check method availability
        $actionsInfo = $controller->getMethods();
        if (isset($actionsInfo[$action]) && !$actionsInfo[$action]->testMethod($this->method)) {
            throw new MethodNotAllowedException('Method ' . $this->method . ' not allowed for this action');
        }

        // if this is OPTIONS request - get data about method
        if ($this->method === HttpMethods::OPTIONS) {
            return $this->getResult($this->getAllowedMethodsForRoute($controller, $action));
        }

        $arguments = $this->getActionArguments($controller, $action);

        // check for arguments
        foreach ($arguments as $argument) {
            if ($argument->isRequired && !isset($data[$argument->name])) {
                throw new BadArgumentsException('Required argument ' . $argument->name . ' not found');
            }
        }

        // call action with data from request
        return $this->getResult($this->callAction($controller, $action, $arguments, $data));
    }


    /**
     * Encoding and cypher result
     * @param array|string $data
     * @return string
     */
    protected function getResult($data)
    {
        if (is_array($data)) {
            header('content-type: application/json');
            return $this->cypher->encode(json_encode($data));
        }

        return $data;
    }


    /**
     * Process custom routes in router->route section in config
     * more information in *routing* section of README.MD
     *
     * @param string $url
     * @return string
     */
    protected function processRoutes($url)
    {
        $routes = $this->config->get('routes', []);

        foreach ($routes as $from => $to) {
            $result = UrlHelper::routeParse($from, $to, $url);
            if (false !== $result && (empty($result->methods) || in_array($this->method, $result->methods, true))) {
                return $result->url;
            }
        }

        return $url;
    }


    /**
     * Returns the incoming array of parameters based on the type of the request
     *
     * @param string $method
     * @return array
     */
    protected function getRequestDataByMethod($method = HttpMethods::GET)
    {
        switch ($method) {
            // POST method
            case HttpMethods::POST:
                $postData = array_merge($_GET, $_POST);
                return $postData ?: [];
                break;
            // PUT method
            case HttpMethods::PUT:
            // PATH method
            case HttpMethods::PATCH:
                $data = $this->cypher->decode(file_get_contents('php://input'));
                parse_str($data, $patchData);
                $patchData = array_merge($_GET, $patchData);
                return $patchData ?: [];
                break;

            // methods with empty payload
            case HttpMethods::DELETE:
            case HttpMethods::HEAD:
            case HttpMethods::OPTIONS:
                return [];
                break;

            // GET method (default)
            case HttpMethods::GET:
            default:
                return $_GET;
                break;
        }
    }


    /**
     * It goes through the parameters of the method and checks for the default value and requirement
     *
     * @param string $class
     * @param string $action
     * @return ActionAttribute[]
     * @throws \ReflectionException
     */
    protected function getActionArguments($class, $action)
    {
        $method = new \ReflectionMethod($class, $action);
        $this->action = $method;

        $parameters = $method->getParameters();

        $result = [];

        foreach ($parameters as $parameter) {
            $attribute = new ActionAttribute();
            $attribute->name = $parameter->getName();
            $attribute->isRequired = !$parameter->isDefaultValueAvailable();
            if (!$attribute->isRequired) {
                $attribute->defaultValue = $parameter->getDefaultValue();
            }
            $result[] = $attribute;
        }

        return $result;
    }


    /**
     * Calling action with request data in params
     *
     * @param ControllerInterface $class
     * @param string $action
     * @param ActionAttribute[] $arguments
     * @param array $data
     * @return array|string
     * @throws \ReflectionException
     */
    protected function callAction(ControllerInterface $class, $action, $arguments, array $data)
    {
        if (null !== $this->action || $this->action->getName() !== $this->action) {
            $this->action = new \ReflectionMethod($class, $action);
        }

        $params = [];

        $dataBox = new Param($data);

        foreach ($arguments as $argument) {
            $params[$argument->name] = $dataBox->get($argument->name, $argument->defaultValue);
        }

        return $this->action->invokeArgs($class, $params);
    }


    /**
     * Return action description and set headers to output
     *
     * @param ControllerInterface $class
     * @param string $action
     * @return array
     */
    protected function getAllowedMethodsForRoute(ControllerInterface $class, $action)
    {
        $actionsInfo = $class->getMethods();
        if (isset($actionsInfo[$action])) {
            $methods = implode(', ', $actionsInfo[$action]->getAllowedMethods());

            $methodInfo = ReflectionHelper::getMethodInfo($class, $action);

            header('Access-Control-Allow-Origin : *');
            header('Access-Control-Allow-Methods : ' . $methods);
            header('Access-Control-Allow-Headers : *');

            return $methodInfo;
        }

        return [];
    }
}
