<?php
/**
 * App.php
 *
 * The file contains a singleton application class.
 *
 * @author Artem Kaplenko
 * @since 0.0.1
 * @version 0.0.1
 */

namespace RestCore\Core;

use RestCore\Core\General\BaseModule;
use RestCore\Core\General\Param;
use RestCore\Core\Helpers\ExceptionHelper;
use RestCore\Exceptions\FileNotFoundException;

/**
 * Class App
 * @package RestCore\Core
 */
class App
{
    /**
     * Application instance container for singleton pattern
     * @var App
     */
    protected static $instance;

    /**
     * Config storage
     * @var array
     */
    protected $config;

    /**
     * Router link
     * @var Router
     */
    protected $router;


    /**
     * Get an instance of a class
     * If it does not exist, create
     *
     * @param null $configFile
     * @return App
     * @throws \RestCore\Exceptions\FileNotFoundException
     */
    public static function getInstance($configFile = null)
    {
        if (null === static::$instance) {
            static::$instance = new static($configFile);
        }
        return static::$instance;
    }


    /**
     * App constructor.
     * Read the config, parse the input data
     *
     * @param string $configFile
     * @throws \RestCore\Exceptions\FileNotFoundException
     */
    private function __construct($configFile)
    {
        $this->config = @include ($configFile);
        if (false === $this->config) {
            ExceptionHelper::showError(new FileNotFoundException('Configuration file is missing'));
            die;
        }

        $this->router = new Router();
    }


    /**
     * Start application
     */
    public function start()
    {
        $config = new Param($this->config);

        $modules = $config->get('modules', []);

        foreach ($modules as $module) {
            if (is_subclass_of($module['class'], BaseModule::class)) {
                $module::setConfig($module);
            }
        }

        try {
            $result = $this->router->route($config->get('router', []));
        } catch (\Exception $e) {
            ExceptionHelper::showError($e);
            die;
        }

        echo $result;
    }
}
