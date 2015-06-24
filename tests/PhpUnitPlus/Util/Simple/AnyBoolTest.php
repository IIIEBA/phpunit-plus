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
        $expected   = ['bool'];
        $actual     = $this->getTypesList($one->getValid());
        $this->assertEquals(sort($expected), sort($actual));

        $two = new AnyBool(true);
        $this->assertTrue(count($two->getValid()) === 2);
        $expected   = ['bool', 'null'];
        $actual     = $this->getTypesList($two->getValid());
        $this->assertEquals(sort($expected), sort($actual));
    }
}
