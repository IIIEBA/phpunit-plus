<?php

namespace Tests\PhpUnitPlus\Util\Custom;

use PhpUnitPlus\Lib\Util\Custom\ManualInput;

class ManualInputTest extends \PHPUnit_Framework_TestCase
{
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
        $invalidList = [
            'null'              => null,
            'boolean'           => (bool)mt_rand(0, 1),
            'object'            => new \stdClass(),
            'string'            => 'test',
            'emptyString'       => '',
            'integer'           => mt_rand(1, PHP_INT_MAX),
            'zeroInteger'       => 0,
            'negativeInteger'   => mt_rand(1, PHP_INT_MAX) * -1,
            'double'            => microtime(true),
            'negativeDouble'    => microtime(true) * -0.5,
            'array'             => ['test'],
            'emptyArray'        => [],
        ];

        $valid  = ['', 'test', 1, null];
        $foo    = new ManualInput($valid);
    }
}
