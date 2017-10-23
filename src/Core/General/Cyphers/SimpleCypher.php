<?php
/**
 * SimpleCypher.php
 *
 * Without data cyphering
 *
 * @author Artem Kaplenko
 * @since 0.0.1
 * @version 0.0.1
 */

namespace RestCore\Core\General\Cyphers;

use RestCore\Core\Interfaces\CypherInterface;

/**
 * Class SimpleCypher
 * @package RestCore\Core\General\Cyphers
 */
class SimpleCypher implements CypherInterface
{
    /**
     * SimpleCypher empty constructor.
     * @param array $params
     */
    public function __construct(array $params = [])
    {
    }

    /**
     * Proxy data
     * @param string $data
     * @return string
     */
    public function encode($data)
    {
        return $data;
    }

    /**
     * Proxy data
     * @param string $data
     * @return string mixed
     */
    public function decode($data)
    {
        return $data;
    }
}
