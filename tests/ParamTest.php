<?php
/**
 * Unit test for Param class
 *
 * for Param version 0.0.1
 *
 * @author Artem Kaplenko
 */

namespace RestCore\tests;

use PHPUnit\Framework\TestCase;
use RestCore\Core\General\Param;

/**
 * Class ParamTest
 * @package RestCore\tests
 */
class ParamTest extends TestCase
{
    const TEST_EQUAL_VALUE = 'testValueForParam';

    /**
     * Container for Param class instance
     * @var Param
     */
    protected $param;

    /**
     * Data for test param
     * @var array
     */
    protected $data = [
        'test1' => [1,2,3],
        'test2' => 'test',
        'test3' => 1
    ];


    /**
     * Create param object
     *
     * @param null $name
     * @param array $data
     * @param string $dataName
     */
    public function __construct($name = null, array $data = [], $dataName = '')
    {
        $this->param = new Param($this->data);

        parent::__construct($name, $data, $dataName);
    }


    /**
     * Test for array value
     */
    public function testArray()
    {
        $this->assertEquals($this->data['test1'], $this->param->get('test1'));
    }


    /**
     * Test for string value
     */
    public function testString()
    {
        $this->assertEquals($this->data['test2'], $this->param->get('test2'));
    }


    /**
     * Test for integer value
     */
    public function testInt()
    {
        $this->assertEquals($this->data['test3'], $this->param->get('test3'));
    }


    /**
     * Test for return default value when key don't exists
     */
    public function testDefaultValue()
    {
        $this->assertEquals(self::TEST_EQUAL_VALUE, $this->param->get('test4', self::TEST_EQUAL_VALUE));
    }


    /**
     * Test for return null when key don't exists and default value don't set
     */
    public function testExceptedValue()
    {
        $this->assertEquals(null, $this->param->get('test4'));
    }
}
