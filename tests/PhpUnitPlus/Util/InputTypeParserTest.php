<?php

namespace Tests\PhpUnitPlus\Util;

use PhpUnitPlus\Lib\Util\InputTypeParser;

/**
 * Class InputTypeParserTest
 * @package Tests\PhpUnitPlus\Util
 */
class InputTypeParserTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @return InputTypeParser
     */
    public function getInputTypeParser()
    {
        return $this->getMockForTrait(InputTypeParser::class);
    }

    /**
     * Test parser for all types of data
     * @throws \Exception
     */
    public function testParser()
    {
        $parser = $this->getInputTypeParser();

        $data = [null];
        $this->assertEquals(['null'], $parser->getTypesList($data));
        $this->assertEquals(['null' => null], $parser->getTypesList($data, true));

        $data = ['test'];
        $this->assertEquals(['string'], $parser->getTypesList($data));
        $this->assertEquals(['string' => 'test'], $parser->getTypesList($data, true));

        $data = [''];
        $this->assertEquals(['emptyString'], $parser->getTypesList($data));
        $this->assertEquals(['emptyString' => ''], $parser->getTypesList($data, true));

        $data = [32];
        $this->assertEquals(['integer'], $parser->getTypesList($data));
        $this->assertEquals(['integer' => 32], $parser->getTypesList($data, true));

        $data = [0];
        $this->assertEquals(['zeroInteger'], $parser->getTypesList($data));
        $this->assertEquals(['zeroInteger' => 0], $parser->getTypesList($data, true));

        $data = [-15];
        $this->assertEquals(['negativeInteger'], $parser->getTypesList($data));
        $this->assertEquals(['negativeInteger' => -15], $parser->getTypesList($data, true));

        $data = [25.2];
        $this->assertEquals(['double'], $parser->getTypesList($data));
        $this->assertEquals(['double' => 25.2], $parser->getTypesList($data, true));

        $data = [-82.6];
        $this->assertEquals(['negativeDouble'], $parser->getTypesList($data));
        $this->assertEquals(['negativeDouble' => -82.6], $parser->getTypesList($data, true));

        $data = [['test']];
        $this->assertEquals(['array'], $parser->getTypesList($data));
        $this->assertEquals(['array' => ['test']], $parser->getTypesList($data, true));

        $data = [[]];
        $this->assertEquals(['emptyArray'], $parser->getTypesList($data));
        $this->assertEquals(['emptyArray' => []], $parser->getTypesList($data, true));

        $data = [new \stdClass()];
        $this->assertEquals(['object'], $parser->getTypesList($data));
        $this->assertEquals(['object' => new \stdClass()], $parser->getTypesList($data, true));
    }

    /**
     * @expectedException \PhpUnitPlus\Lib\Exception\PhpUnitPlusException
     */
    public function testUnsupportedInputType()
    {
        $parser = $this->getInputTypeParser();

        $parser->getTypesList([curl_init()]);
    }
}
