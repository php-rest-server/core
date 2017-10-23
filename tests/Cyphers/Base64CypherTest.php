<?php
/**
 * Unit test for Base64Cypher class
 *
 * for Base64Cypher version 0.0.1
 *
 * @author Artem Kaplenko
 */

namespace RestCore\tests\Cypher;

use PHPUnit\Framework\TestCase;
use RestCore\Core\General\Cyphers\Base64Cypher;

class Base64CypherTest extends TestCase
{
    public $data = 'testString';

    /**
     * Test encoding data
     */
    public function testEncode()
    {
        $cypher = new Base64Cypher();

        $this->assertEquals(base64_encode($this->data), $cypher->encode($this->data));
    }

    /**
     * Test for decoding data
     */
    public function testDecode()
    {
        $cypher = new Base64Cypher();

        $this->assertEquals($this->data, $cypher->decode(base64_encode($this->data)));
    }
}
