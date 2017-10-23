<?php
/**
 * Unit test for OpenSSLCypher class
 *
 * for OpenSSLCypher version 0.0.1
 *
 * @author Artem Kaplenko
 */

namespace RestCore\tests\Cypher;

use PHPUnit\Framework\TestCase;
use RestCore\Core\General\Cyphers\OpenSSLCypher;

/**
 * Class OpenSSLCypherTest
 * @package RestCore\tests\Cypher
 */
class OpenSSLCypherTest extends TestCase
{
    public $data = 'testString';

    public $method = 'aes128';
    public $key = 'testKey';
    public $iv;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        $this->iv = false;
        $cStrong = false;
        while ($this->iv === false || !$cStrong) {
            $this->iv = openssl_random_pseudo_bytes(16, $cStrong);
            if ($cStrong === false) {
                continue;
            }
        }

        parent::__construct($name, $data, $dataName);
    }

    /**
     * Test encoding data
     */
    public function testEncode()
    {
        $testData = openssl_encrypt($this->data, $this->method, $this->key, 0, $this->iv);
        $cypher = new OpenSSLCypher([
            'method' => $this->method,
            'key' => $this->key,
            'iv' => $this->iv,
        ]);

        $this->assertEquals($testData, $cypher->encode($this->data));
    }

    /**
     * Test for decoding data
     */
    public function testDecode()
    {
        $testData = openssl_encrypt($this->data, $this->method, $this->key, 0, $this->iv);
        $cypher = new OpenSSLCypher([
            'method' => $this->method,
            'key' => $this->key,
            'iv' => $this->iv,
        ]);

        $this->assertEquals($this->data, $cypher->decode($testData));
    }
}
