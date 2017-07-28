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


    /**
     * Get an instance of a class
     * If it does not exist, create
     *
     * @return App
     */
    public static function getInstance()
    {
        if (null === static::$instance) {
            static::$instance = new static();
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
    private function __construct($configFile = 'config.php')
    {
        try {
            $config = include $configFile;
        } catch (\Exception $e) {
            throw new FileNotFoundException('Configuration file is missing');
        }

        var_dump($config);
    }



    public function start()
    {

    }
}
