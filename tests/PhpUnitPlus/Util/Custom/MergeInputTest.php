<?php

namespace Tests\PhpUnitPlus\Util\Custom;

use PhpUnitPlus\Lib\Util\Custom\ManualInput;
use PhpUnitPlus\Lib\Util\Custom\MergeInput;
use PhpUnitPlus\Lib\Util\InputTypeParser;
use PhpUnitPlus\Lib\Util\Simple\AnyString;
use PhpUnitPlus\Lib\Util\Simple\TypeHintingInput;

/**
 * Class MergeInputTest
 *
 * @package Tests\PhpUnitPlus\Util\Custom
 */
class MergeInputTest extends \PHPUnit_Framework_TestCase
{
    use InputTypeParser;

    /**
     * Test merge for valid and invalid params
     * @throws \Exception
     */
    public function testMerge()
    {
        $foo = new ManualInput(['test', null], [23, false]);
        $bar = new ManualInput([1], [[]]);

        $merge = new MergeInput($foo, $bar);

        // Test valid
        $expected   = $this->getTypesList(['test', null, 1]);
        $actual     = $this->getTypesList($merge->getValid());
        sort($expected);
        sort($actual);
        $this->assertEquals($expected, $actual);

        // Test invalid
        $expected   = $this->getTypesList([false, []]);
        $actual     = $this->getTypesList($merge->getInvalid());
        sort($expected);
        sort($actual);
        $this->assertEquals($expected, $actual);
    }

    /**
     * @expectedException \PhpUnitPlus\Lib\Exception\PhpUnitPlusException
     */
    public function testMergeWithObjectInput()
    {
        new MergeInput(new AnyString(), new TypeHintingInput(new \DateTime()));
    }
}
