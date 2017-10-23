<?php
/**
 * Unit test for SimpleCypher class
 *
 * for SimpleCypher version 0.0.1
 *
 * @author Artem Kaplenko
 */

namespace RestCore\tests\Cypher;

use PHPUnit\Framework\TestCase;
use RestCore\Core\General\Cyphers\SimpleCypher;

class SimpleCypherTest extends TestCase
{
    public $data = 'testString';

    /**
     * Test encoding data
     */
    public function testEncode()
    {
        $cypher = new SimpleCypher();

        $this->assertEquals($this->data, $cypher->encode($this->data));
    }

    /**
     * Test for decoding data
     */
    public function testDecode()
    {
        $cypher = new SimpleCypher();

        $this->assertEquals($this->data, $cypher->decode($this->data));
    }
}
