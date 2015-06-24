<?php

namespace Tests\PhpUnitPlus\Util;

use PhpUnitPlus\Lib\Util\InputDataBase;

/**
 * Class InputDataBaseTest
 * @package Tests\PhpUnitPlus\Util
 */
class InputDataBaseTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @return InputDataBase
     */
    public function mockInputDataBase()
    {
        return $this->getMockForAbstractClass(InputDataBase::class);
    }

    /**
     * Test abstract class getters
     */
    public function testGetters()
    {
        $foo        = $this->mockInputDataBase();
        $reflection = new \ReflectionClass($foo);
        $valid      = $reflection->getProperty('valid');
        $valid->setAccessible(true);
        $invalid    = $reflection->getProperty('invalid');
        $invalid->setAccessible(true);

        // Test default values
        $this->assertEquals(null, $foo->getValid());
        $this->assertEquals(null, $foo->getInvalid());

        // Test custom
        $validData = ['test_valid'];
        $valid->setValue($foo, $validData);
        $this->assertEquals($validData, $foo->getValid());

        $invalidData = ['test_invalid'];
        $invalid->setValue($foo, $invalidData);
        $this->assertEquals($invalidData, $foo->getInvalid());
    }
}
