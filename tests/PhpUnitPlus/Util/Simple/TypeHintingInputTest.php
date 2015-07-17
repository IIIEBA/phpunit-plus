<?php

namespace Tests\PhpUnitPlus\Util\Simple;

use PhpUnitPlus\Lib\Util\InputTypeParser;
use PhpUnitPlus\Lib\Util\Simple\TypeHintingInput;

/**
 * Class TypeHintingInputTest
 * @package Tests\PhpUnitPlus\Util\Simple
 */
class TypeHintingInputTest extends \PHPUnit_Framework_TestCase
{
    use InputTypeParser;

    /**
     * Test correct work of isNullAllowed flag
     */
    public function testConstructNullParam()
    {
        $value = [];

        $one = new TypeHintingInput($value, false);
        $this->assertTrue(count($one->getValid()) === 1);
        $this->assertTrue(count($one->getInvalid()) === 1);
        $expected   = ['emptyArray'];
        $actual     = $this->getTypesList($one->getValid());
        sort($expected);
        sort($actual);
        $this->assertEquals($expected, $actual);
        $expected   = ['null'];
        $actual     = $this->getTypesList($one->getInvalid());
        sort($expected);
        sort($actual);
        $this->assertEquals($expected, $actual);

        $two = new TypeHintingInput($value, true);
        $this->assertTrue(count($two->getValid()) === 2);
        $this->assertTrue(count($two->getInvalid()) === 0);
        $expected   = ['emptyArray', 'null'];
        $actual     = $this->getTypesList($two->getValid());
        sort($expected);
        sort($actual);
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test value for valid and invalid input params
     */
    public function testConstructForTypeHintingTypes()
    {
        // Test valid data
        $valid = [
            'object'            => new \stdClass(),
            'array'             => ['test'],
            'emptyArray'        => [],
        ];
        foreach ($valid as $type => $elm) {
            try {
                new TypeHintingInput($elm);
                $this->assertTrue(true);
            } catch (\InvalidArgumentException $e) {
                $this->fail("Test fail on correct value with type - {$type}");
            }
        }

        // Test invalid data
        $invalid = [
            'boolean'           => (bool)mt_rand(0, 1),
            'string'            => 'test',
            'emptyString'       => '',
            'integer'           => mt_rand(1, PHP_INT_MAX),
            'zeroInteger'       => 0,
            'negativeInteger'   => mt_rand(1, PHP_INT_MAX) * -1,
            'double'            => microtime(true),
            'negativeDouble'    => microtime(true) * -0.5,
        ];
        foreach ($invalid as $type => $elm) {
            try {
                new TypeHintingInput($elm);
                $this->fail("Test doesn`t fail on incorrect value with type - {$type}");
            } catch (\InvalidArgumentException $e) {
                $this->assertTrue(true);
            }
        }
    }
}
