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

use RestCore\Core\General\Param;
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

    protected $config;


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
        try {
            $this->config = include ($configFile);
        } catch (\Exception $e) {
            throw new FileNotFoundException('Configuration file is missing');
        }
    }



    public function start()
    {
        return $this->config;
    }
}
