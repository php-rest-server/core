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
    protected $config;

    public function __construct($config = [])
    {
        $this->setConfig($config);
    }

    public function setConfig($config)
    {
        $this->config = $config;
    }

    public function getConfig()
    {
        return $this->config;
    }
}
