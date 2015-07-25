<?php

namespace Tests\PhpUnitPlus\Component;

use PhpUnitPlus\Lib\Component\InputDataChecker;
use PhpUnitPlus\Lib\Component\InputDataInterface;
use PhpUnitPlus\Lib\Exception\PhpUnitPlusException;
use PhpUnitPlus\Lib\Util\Simple\AnyBool;
use PhpUnitPlus\Lib\Util\Simple\AnyFloat;
use PhpUnitPlus\Lib\Util\Simple\AnyInteger;
use PhpUnitPlus\Lib\Util\Simple\AnyString;
use PhpUnitPlus\Lib\Util\Simple\TypeHintingInput;

class InputDataCheckerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Counts of AssertTrue method calls into mocked class
     * @var int
     */
    private $mockedAssertTrueCount = 0;

    /**
     * Reset assertTrue counter for mocked class
     */
    private function resetAssertTrueCounter()
    {
        $this->mockedAssertTrueCount = 0;
    }

    /**
     * @param bool $exceptionOnFail
     * @return InputDataChecker
     */
    public function getChecker($exceptionOnFail = false)
    {
        $mock = $this->getMockForTrait(InputDataChecker::class, [], '', true, true, true, ['fail', 'assertTrue']);

        // Mock fail method
        if ($exceptionOnFail === true) {
            $mock->expects($this->any())->method('fail')->willThrowException(new PhpUnitPlusException('fail', 9003));
        } else {
            $mock->expects($this->any())->method('fail')->willReturnCallback(function () {
                return call_user_func_array(array($this, 'mockedFail'), func_get_args());
            });
        }

        // Mock assertTrue method
        $mock->expects($this->any())->method('assertTrue')->willReturnCallback(function() {
            return call_user_func_array(array($this, 'mockedAssertTrue'), func_get_args());
        });

        return $mock;
    }

    /**
     * @param string $msg
     */
    public function mockedFail($msg = '')
    {
        $this->fail($msg);
    }

    /**
     * @param bool $condition
     * @param string $msg
     */
    public function mockedAssertTrue($condition, $msg = '')
    {
        $this->mockedAssertTrueCount++;

        $this->assertTrue($condition, $msg);
    }

    /**
     * Test checker for valid inputData
     */
    public function testInputData()
    {
        $test = $this->getChecker();

        // Test valid
        try {
            $test->checkInputData([new TypeHintingInput(new \stdClass(), true)], function(){
                $this->assertTrue(true);
            });
        } catch (\InvalidArgumentException $e) {
            $this->fail("Test fall down with valid input data");
        }

        // Test invalid
        $invalid = [
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
        foreach ($invalid as $type => $value) {
            try {
                $test->checkInputData([$value], function(){
                    $this->fail("Test doesn`t fall down with invalid input data");
                });

                $this->fail("Test doesn`t fall down with invalid input data with elm type - [{$type}]");
            } catch (\InvalidArgumentException $e) {
                $this->assertTrue(true);
            }
        }
    }

    /**
     * Test all checker for correct check valid and invalid params
     */
    public function testCorrectWork()
    {
        $this->getChecker()->checkInputData(
            [
                new AnyString(true, false),
                new AnyInteger(true, true, false),
                new AnyFloat(true, false),
                new AnyBool(false),
                new TypeHintingInput([], false),
                new TypeHintingInput(new \DateTime(), false),
            ],
            function($one, $two, $three, $four, $five, $six) {
                $this->someMethod($one, $two, $three, $four, $five, $six);
            }
        );
    }

    /**
     * Test numbers of test casses in test
     */
    public function testCheckerForCorrectNumberOfTests()
    {
        $testData = [
            new AnyString(true, false),
            new AnyInteger(true, true, false),
            new AnyFloat(true, false),
            new AnyBool(false),
            new TypeHintingInput([], false),
            new TypeHintingInput(new \DateTime(), false),
        ];

        $expectedValidChecks    = 0;
        $expectedInvalidChecks  = 0;
        foreach ($testData as $input) {
            /**
             * @var InputDataInterface $input
             */
            $validCount = count($input->getValid());
            if ($validCount > $expectedValidChecks) {
                $expectedValidChecks = $validCount;
            }

            $expectedInvalidChecks += count($input->getInvalid());
        }

        $this->resetAssertTrueCounter();

        $this->getChecker()->checkInputData(
            $testData,
            function($one, $two, $three, $four, $five, $six) {
                $this->someMethod($one, $two, $three, $four, $five, $six);
            }
        );

        $this->assertEquals($expectedValidChecks + $expectedInvalidChecks, $this->mockedAssertTrueCount);
    }

    public function testFailConditionsOfChecker()
    {
        // Test another type of exception rethrow in valid check block
        try {
            $this->getChecker()->checkInputData(
                [
                    new AnyInteger(true, false),
                ],
                function ($one) {
                    $this->someAnotherMethod($one);
                }
            );
            $this->fail('Checker must rethrow not expected exceptions in valid block');
        } catch (PhpUnitPlusException $e) {
            if ($e->getCode() === 9001) {
                $this->assertTrue(true);
            } else {
                $this->fail('Checker must rethrow not expected exceptions in valid block');
            }
        }

        // Test another type of exception rethrow in invalid check block
        try {
            $this->getChecker()->checkInputData(
                [
                    new AnyString(true, false),
                ],
                function ($one) {
                    $this->someAnotherMethod($one);
                }
            );
            $this->fail('Checker must rethrow not expected exceptions in invalid block');
        } catch (PhpUnitPlusException $e) {
            if ($e->getCode() === 9002) {
                $this->assertTrue(true);
            } else {
                var_dump($e->getCode());
                $this->fail('Checker must rethrow not expected exceptions in invalid block');
            }
        }

        // Test for invalid params
        try {
            $this->getChecker(true)->checkInputData(
                [
                    new AnyInteger(true, true, false),
                    new AnyInteger(true, true, false),
                    new AnyFloat(true, false),
                    new AnyBool(false),
                    new TypeHintingInput([], false),
                    new TypeHintingInput(new \DateTime(), false),
                ],
                function($one, $two, $three, $four, $five, $six) {
                    $this->someMethod($one, $two, $three, $four, $five, $six);
                }
            );

            $this->fail('Test didn`t fall down with invalid params at valid check');
        } catch (PhpUnitPlusException $e) {
            if ($e->getCode() === 9003) {
                $this->assertTrue(true);
            } else {
                $this->fail('Test didn`t fall down with invalid params at valid check');
            }
        }

        // Test for not allowed subtype
        try {
            $this->getChecker(true)->checkInputData(
                [
                    new AnyString(false, false),
                    new AnyInteger(true, true, false),
                    new AnyFloat(true, false),
                    new AnyBool(false),
                    new TypeHintingInput([], false),
                    new TypeHintingInput(new \DateTime(), false),
                ],
                function($one, $two, $three, $four, $five, $six) {
                    $this->someMethod($one, $two, $three, $four, $five, $six);
                }
            );

            $this->fail('Test didn`t fall down with invalid params at invalid check');
        } catch (PhpUnitPlusException $e) {
            if ($e->getCode() === 9003) {
                $this->assertTrue(true);
            } else {
                $this->fail('Test didn`t fall down with invalid params at invalid check');
            }
        }
    }

    /**
     * Some method for internal test usage
     * @param string $one
     * @param int $two
     * @param float $three
     * @param bool $four
     * @param array $five
     * @param \DateTime $six
     * @return array
     */
    public function someMethod(
        $one,
        $two,
        $three,
        $four,
        array $five,
        \DateTime $six
    )
    {
        if (!is_string($one)) {
            throw new \InvalidArgumentException('one');
        }

        if (!is_int($two)) {
            throw new \InvalidArgumentException('two');
        }

        if (!is_float($three)) {
            throw new \InvalidArgumentException('three');
        }

        if (!is_bool($four)) {
            throw new \InvalidArgumentException('four');
        }

        // Just for add usage of variables
        return [$five, $six];
    }

    /**
     * @param string $one
     * @throws PhpUnitPlusException
     */
    public function someAnotherMethod($one)
    {
        if (!is_string($one)) {
            if ($one === null) {
                throw new PhpUnitPlusException('two', 9002);
            }

            throw new PhpUnitPlusException('one', 9001);
        }
    }
}
