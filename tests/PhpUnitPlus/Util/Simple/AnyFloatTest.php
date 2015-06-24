<?php

namespace Tests\PhpUnitPlus\Util\Simple;

use PhpUnitPlus\Lib\Util\InputTypeParser;
use PhpUnitPlus\Lib\Util\Simple\AnyFloat;

/**
 * Class AnyFloatTest
 * @package Tests\PhpUnitPlus\Util\Simple
 */
class AnyFloatTest extends \PHPUnit_Framework_TestCase
{
    use InputTypeParser;

    /**
     * Test correct generation of valid params
     * @throws \Exception
     */
    public function testConstruct()
    {
        $one = new AnyFloat(false, false);
        $this->assertTrue(count($one->getValid()) === 1);
        $expected   = ['double'];
        $actual     = $this->getTypesList($one->getValid());
        sort($expected);
        sort($actual);
        $this->assertEquals($expected, $actual);

        $one = new AnyFloat(false, true);
        $this->assertTrue(count($one->getValid()) === 2);
        $expected   = ['double', 'null'];
        $actual     = $this->getTypesList($one->getValid());
        sort($expected);
        sort($actual);
        $this->assertEquals($expected, $actual);

        $one = new AnyFloat(true, false);
        $this->assertTrue(count($one->getValid()) === 2);
        $expected   = ['double', 'negativeDouble'];
        $actual     = $this->getTypesList($one->getValid());
        sort($expected);
        sort($actual);
        $this->assertEquals($expected, $actual);

        $one = new AnyFloat(true, true);
        $this->assertTrue(count($one->getValid()) === 3);
        $expected   = ['double', 'null', 'negativeDouble'];
        $actual     = $this->getTypesList($one->getValid());
        sort($expected);
        sort($actual);
        $this->assertEquals($expected, $actual);
    }
}
