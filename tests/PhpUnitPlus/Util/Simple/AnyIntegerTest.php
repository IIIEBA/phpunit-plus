<?php

namespace Tests\PhpUnitPlus\Util\Simple;

use PhpUnitPlus\Lib\Util\InputTypeParser;
use PhpUnitPlus\Lib\Util\Simple\AnyInteger;

/**
 * Class AnyIntegerTest
 * @package Tests\PhpUnitPlus\Util\Simple
 */
class AnyIntegerTest extends \PHPUnit_Framework_TestCase
{
    use InputTypeParser;

    /**
     * Test correct generation of valid params
     * @throws \Exception
     */
    public function testConstruct()
    {
        $one = new AnyInteger(false, false, false);
        $this->assertTrue(count($one->getValid()) === 2);
        $expected   = ['integer'];
        $actual     = $this->getTypesList($one->getValid());
        sort($expected);
        sort($actual);
        $this->assertEquals($expected, $actual);

        $one = new AnyInteger(false, false, true);
        $this->assertTrue(count($one->getValid()) === 3);
        $expected   = ['integer', 'null'];
        $actual     = $this->getTypesList($one->getValid());
        sort($expected);
        sort($actual);
        $this->assertEquals($expected, $actual);

        $one = new AnyInteger(false, true, false);
        $this->assertTrue(count($one->getValid()) === 3);
        $expected   = ['integer', 'negativeInteger'];
        $actual     = $this->getTypesList($one->getValid());
        sort($expected);
        sort($actual);
        $this->assertEquals($expected, $actual);

        $one = new AnyInteger(true, false, false);
        $this->assertTrue(count($one->getValid()) === 3);
        $expected   = ['integer', 'zeroInteger'];
        $actual     = $this->getTypesList($one->getValid());
        sort($expected);
        sort($actual);
        $this->assertEquals($expected, $actual);

        $one = new AnyInteger(true, false, true);
        $this->assertTrue(count($one->getValid()) === 4);
        $expected   = ['integer', 'zeroInteger', 'null'];
        $actual     = $this->getTypesList($one->getValid());
        sort($expected);
        sort($actual);
        $this->assertEquals($expected, $actual);

        $one = new AnyInteger(true, true, false);
        $this->assertTrue(count($one->getValid()) === 4);
        $expected   = ['integer', 'zeroInteger', 'negativeInteger'];
        $actual     = $this->getTypesList($one->getValid());
        sort($expected);
        sort($actual);
        $this->assertEquals($expected, $actual);

        $one = new AnyInteger(true, true, true);
        $this->assertTrue(count($one->getValid()) === 5);
        $expected   = ['integer', 'zeroInteger', 'null', 'negativeInteger'];
        $actual     = $this->getTypesList($one->getValid());
        sort($expected);
        sort($actual);
        $this->assertEquals($expected, $actual);
    }
}
