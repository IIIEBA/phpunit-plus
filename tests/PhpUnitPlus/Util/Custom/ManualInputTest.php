<?php

namespace Tests\PhpUnitPlus\Util\Custom;

use PhpUnitPlus\Lib\Util\Custom\ManualInput;
use PhpUnitPlus\Lib\Util\InputTypeParser;

/**
 * Class ManualInputTest
 *
 * @package Tests\PhpUnitPlus\Util\Custom
 */
class ManualInputTest extends \PHPUnit_Framework_TestCase
{
    use InputTypeParser;

    /**
     * Test for manual set valid and invalid params
     */
    public function testManualParamsSet()
    {
        $valid      = [1, 'test'];
        $invalid    = [null, [], -32];

        $foo = new ManualInput($valid, $invalid);

        $this->assertEquals($valid, $foo->getValid());
        $this->assertEquals($invalid, $foo->getInvalid());
    }

    /**
     * Test for auto generating invalid params based on valid
     */
    public function testInvalidGenerator()
    {
        $valid = ['', 'test', 1, null];
        $expectedTypes = [
            'boolean',
            'object',
            'zeroInteger',
            'negativeInteger',
            'double',
            'negativeDouble',
            'array',
            'emptyArray',
        ];

        $foo = new ManualInput($valid);
        $actualTypes = $this->getTypesList($foo->getInvalid());
        sort($expectedTypes);
        sort($actualTypes);
        $this->assertEquals($expectedTypes, $actualTypes);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testManualInputWithEmptyParams()
    {
        new ManualInput([]);
    }
}
