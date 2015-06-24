<?php

namespace Tests\PhpUnitPlus\Util\Simple;

use PhpUnitPlus\Lib\Util\InputTypeParser;
use PhpUnitPlus\Lib\Util\Simple\AnyArray;

/**
 * Class AnyArrayTest
 * @package Tests\PhpUnitPlus\Util\Simple
 */
class AnyArrayTest extends \PHPUnit_Framework_TestCase
{
    use InputTypeParser;

    /**
     * Test correct generation of valid params
     * @throws \Exception
     */
    public function testConstruct()
    {
        $one = new AnyArray(false, false);
        $this->assertTrue(count($one->getValid()) === 1);
        $expected   = ['array'];
        $actual     = $this->getTypesList($one->getValid());
        sort($expected);
        sort($actual);
        $this->assertEquals($expected, $actual);

        $one = new AnyArray(false, true);
        $this->assertTrue(count($one->getValid()) === 2);
        $expected   = ['array' , 'null'];
        $actual     = $this->getTypesList($one->getValid());
        sort($expected);
        sort($actual);
        $this->assertEquals($expected, $actual);

        $one = new AnyArray(true, false);
        $this->assertTrue(count($one->getValid()) === 2);
        $expected   = ['array', 'emptyArray'];
        $actual     = $this->getTypesList($one->getValid());
        sort($expected);
        sort($actual);
        $this->assertEquals($expected, $actual);

        $one = new AnyArray(true, true);
        $this->assertTrue(count($one->getValid()) === 3);
        $expected   = ['array', 'null', 'emptyArray'];
        $actual     = $this->getTypesList($one->getValid());
        sort($expected);
        sort($actual);
        $this->assertArraySubset($expected, $actual);
    }
}
