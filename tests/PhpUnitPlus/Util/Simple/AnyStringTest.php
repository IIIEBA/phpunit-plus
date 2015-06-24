<?php

namespace Tests\PhpUnitPlus\Util\Simple;

use PhpUnitPlus\Lib\Util\InputTypeParser;
use PhpUnitPlus\Lib\Util\Simple\AnyString;

/**
 * Class AnyStringTest
 * @package Tests\PhpUnitPlus\Util\Simple
 */
class AnyStringTest extends \PHPUnit_Framework_TestCase
{
    use InputTypeParser;

    /**
     * Test correct generation of valid params
     * @throws \Exception
     */
    public function testConstruct()
    {
        $one = new AnyString(false, false);
        $this->assertTrue(count($one->getValid()) === 1);
        $expected   = ['string'];
        $actual     = $this->getTypesList($one->getValid());
        sort($expected);
        sort($actual);
        $this->assertEquals($expected, $actual);

        $two = new AnyString(false, true);
        $this->assertTrue(count($two->getValid()) === 2);
        $expected   = ['string', 'null'];
        $actual     = $this->getTypesList($two->getValid());
        sort($expected);
        sort($actual);
        $this->assertEquals($expected, $actual);

        $three = new AnyString(true, false);
        $this->assertTrue(count($three->getValid()) === 2);
        $expected   = ['emptyString', 'string'];
        $actual     = $this->getTypesList($three->getValid());
        sort($expected);
        sort($actual);
        $this->assertEquals($expected, $actual);

        $four = new AnyString(true, true);
        $this->assertTrue(count($four->getValid()) === 3);
        $expected   = ['string', 'emptyString', 'null'];
        $actual     = $this->getTypesList($four->getValid());
        sort($expected);
        sort($actual);
        $this->assertEquals($expected, $actual);
    }
}
