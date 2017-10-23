<?php
/**
 * OpenSSLCypher.php
 *
 * @author Artem Kaplenko
 * @since 0.0.1
 * @version 0.0.1
 */

namespace RestCore\Core\General\Cyphers;

use RestCore\Core\Interfaces\CypherInterface;

/**
 * Class OpenSSLCypher
 *
 * Example config:
 * --------------------
 * 'router' => [
 *     ...
 *     'cypher' => 'openssl',
 *     'cypherParams' => [
 *         'method' => 'aes128',
 *         'key' => 'bcb04b7e103a0cd8b54763051cef08bc55abe0295e1d417e2ffb2a00a3',
 *         'iv' => hex2bin('34857d973953e44afb49ea9d61104d8c'),
 *     ],
 * ],
 * ---------------------
 *
 * @package RestCore\Core\General\Cyphers
 */
class OpenSSLCypher implements CypherInterface
{
    protected $method = 'aes128';
    protected $key = '';
    protected $iv = '';

    public function __construct(array $params = [])
    {
        if (isset($params['method'])) {
            $this->method = $params['method'];
        }
        if (isset($params['key'])) {
            $this->key = $params['key'];
        }
        if (isset($params['iv'])) {
            $this->iv = $params['iv'];
        }
    }


    /**
     * Encode data by openssl_encrypt
     *
     * @param string $data
     * @return string
     */
    public function encode($data)
    {
        return openssl_encrypt($data, $this->method, $this->key, 0, $this->iv);
    }


    /**
     * Decode data by openssl_decrypt
     *
     * @param string $data
     * @return string
     */
    public function decode($data)
    {
        return openssl_decrypt($data, $this->method, $this->key, 0, $this->iv);
    }
}
