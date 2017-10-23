<?php
/**
 * Unit test for ActionInfo class
 *
 * for ActionInfo version 0.0.1
 *
 * @author Artem Kaplenko
 */

namespace RestCore\tests;

use PHPUnit\Framework\TestCase;
use RestCore\Core\General\ActionInfo;
use RestCore\Core\Enums\HttpMethods;

/**
 * Class ActionInfoTest
 * @package RestCore\tests
 */
class ActionInfoTest extends TestCase
{
    /**
     * Test default values in constructor
     */
    public function testConstructorDefault()
    {
        $actionInfo = new ActionInfo();

        $this->assertEquals(true, $actionInfo->get);
        $this->assertEquals(false, $actionInfo->post);
        $this->assertEquals(false, $actionInfo->put);
        $this->assertEquals(false, $actionInfo->path);
        $this->assertEquals(false, $actionInfo->delete);
        $this->assertEquals(false, $actionInfo->head);
        $this->assertEquals(false, $actionInfo->options);
    }


    /**
     * Test constructor with custom data
     */
    public function testConstructorCustom()
    {
        $actionInfo = new ActionInfo(false, true, true, true, true, true, true);

        $this->assertEquals(false, $actionInfo->get);
        $this->assertEquals(true, $actionInfo->post);
        $this->assertEquals(true, $actionInfo->put);
        $this->assertEquals(true, $actionInfo->path);
        $this->assertEquals(true, $actionInfo->delete);
        $this->assertEquals(true, $actionInfo->head);
        $this->assertEquals(true, $actionInfo->options);
    }


    /**
     * Test for testMethod method
     */
    public function testTestMethod()
    {
        $actionInfo = new ActionInfo(false, true, true, true, true, true, true);

        $this->assertEquals(false, $actionInfo->testMethod(HttpMethods::GET));
        $this->assertEquals(true, $actionInfo->testMethod(HttpMethods::POST));
        $this->assertEquals(true, $actionInfo->testMethod(HttpMethods::PUT));
        $this->assertEquals(true, $actionInfo->testMethod(HttpMethods::PATCH));
        $this->assertEquals(true, $actionInfo->testMethod(HttpMethods::DELETE));
        $this->assertEquals(true, $actionInfo->testMethod(HttpMethods::HEAD));
        $this->assertEquals(true, $actionInfo->testMethod(HttpMethods::OPTIONS));
    }


    /**
     * Test for getAllowedMethods method
     */
    public function testGetAllowedMethods()
    {
        $allOn = [
            HttpMethods::GET,
            HttpMethods::POST,
            HttpMethods::PUT,
            HttpMethods::PATCH,
            HttpMethods::DELETE,
            HttpMethods::HEAD,
            HttpMethods::OPTIONS,
        ];

        $allOff = [];

        $actionInfo = new ActionInfo(true, true, true, true, true, true, true);
        $this->assertEquals($allOn, $actionInfo->getAllowedMethods());

        $actionInfo = new ActionInfo(false);
        $this->assertEquals($allOff, $actionInfo->getAllowedMethods());
    }
}
