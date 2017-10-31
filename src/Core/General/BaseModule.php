<?php
/**
 * Base module class
 */

namespace RestCore\Core\General;

/**
 * Class BaseModule
 * @package RestCore\Core\General
 */
abstract class BaseModule
{
    private static $config;

    public static function setConfig($config)
    {
        self::$config = $config;
    }

    public static function getConfig()
    {
        return self::$config;
    }
}
