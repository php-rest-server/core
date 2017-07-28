<?php
/**
 * Param.php
 *
 * The class simplifies the work with arrays, for example settings. Now there is no need to write a lot of checks,
 * just create an object with a config array, and use the get method to get the value by key, or to replace
 * the default value
 *
 * @author Artem Kaplenko
 * @since 0.0.1
 * @version 0.0.1
 */

namespace RestCore\Core\General;

/**
 * Class Param
 * @package RestCore\Core\General
 */
class Param
{
    /**
     * Store data in object
     * @var array
     */
    protected $dataContainer;


    /**
     * Setup dataContainer var in class
     *
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->dataContainer = $data;
    }


    /**
     * Get value by key. If value does not exists then return default value
     *
     * @param string $name
     * @param mixed $default
     * @return mixed|null
     */
    public function get($name, $default = null)
    {
        if (isset($this->dataContainer[$name])) {
            return $this->dataContainer[$name];
        }

        return $default;
    }
}
