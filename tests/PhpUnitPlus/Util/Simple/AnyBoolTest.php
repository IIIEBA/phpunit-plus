<?php

namespace Tests\PhpUnitPlus\Util\Simple;

use PhpUnitPlus\Lib\Util\InputTypeParser;
use PhpUnitPlus\Lib\Util\Simple\AnyBool;

/**
 * Class AnyBoolTest
 * @package Tests\PhpUnitPlus\Util\Simple
 */
class AnyBoolTest extends \PHPUnit_Framework_TestCase
{
    use InputTypeParser;

    /**
     * Test correct generation of valid params
     * @throws \Exception
     */
    public function testConstruct()
    {
        $one = new AnyBool(false);
        $this->assertTrue(count($one->getValid()) === 1);
        $expected   = ['boolean'];
        $actual     = $this->getTypesList($one->getValid());
        sort($expected);
        sort($actual);
        $this->assertEquals($expected, $actual);

        $two = new AnyBool(true);
        $this->assertTrue(count($two->getValid()) === 2);
        $expected   = ['boolean', 'null'];
        $actual     = $this->getTypesList($two->getValid());
        sort($expected);
        sort($actual);
        $this->assertEquals($expected, $actual);
    }
}
