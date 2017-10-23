<?php
/**
 * Base64Cypher.php
 *
 * Example of cypher data
 *
 * add to router section of config key 'cypher' with value 'base64'
 *
 * @author Artem Kaplenko
 * @since 0.0.1
 * @version 0.0.1
 */

namespace RestCore\Core\General\Cyphers;

use RestCore\Core\Interfaces\CypherInterface;

/**
 * Class Base64Cypher
 * @package RestCore\Core\General\Cyphers
 */
class Base64Cypher implements CypherInterface
{
    /**
     * Base64Cypher empty constructor.
     * @param array $params
     */
    public function __construct(array $params = [])
    {
    }


    /**
     * Encode data in base64
     * @param string $data
     * @return string
     */
    public function encode($data)
    {
        return base64_encode($data);
    }


    /**
     * Decode data from base64
     * @param string $data
     * @return bool|string
     */
    public function decode($data)
    {
        return base64_decode($data);
    }
}
