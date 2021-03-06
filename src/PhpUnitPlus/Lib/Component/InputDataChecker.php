<?php

namespace PhpUnitPlus\Lib\Component;

use PHPUnit_Framework_Error;

/**
 * Class InputDataChecker
 * @package PhpUnitPlus\Lib\Component
 */
trait InputDataChecker
{
    /**
     * Method for testing constructor with valid and invalid arrays of data, with callback function
     * @param InputDataInterface[] $inputDataList
     * @param callable $userFunc
     */
    public function checkInputData(array $inputDataList, callable $userFunc)
    {
        /**
         * @var \PHPUnit_Framework_TestCase $this
         */

        // Test input data
        foreach ($inputDataList as $elm) {
            if (!is_object($elm)) {
                throw new \InvalidArgumentException("Only object allowed for input data elements");
            }

            if (($elm instanceof InputDataInterface) === false) {
                throw new \InvalidArgumentException("Input data elements must be instance of InputDataInterface");
            }
        }

        // Prepare data
        $validPrepared = [];
        $maxCountValid = 0;
        foreach ($inputDataList as $name => $inputData) {
            if (($count = count($inputData->getValid())) > $maxCountValid) {
                $maxCountValid = $count;
            }

            $data = $inputData->getValid();
            $validPrepared[$name] = reset($data);
        }

        // Check valid params
        for ($num = 0; $num < $maxCountValid; $num++) {
            try {
                if ($num !== 0) {
                    $validPrepared = [];
                    foreach ($inputDataList as $name => $inputData) {
                        $values = $inputData->getValid();
                        $validPrepared[$name] = array_key_exists($num, $values) ? $values[$num] : reset($values);
                    }
                }

                call_user_func_array($userFunc, $validPrepared);
                $this->assertTrue(true);
            } catch (\TypeError $e) {
                $this->fail("Test fall down with correct value with error: " . $e->getMessage());
            } catch (\Exception $e) {
                if ($e instanceof \InvalidArgumentException
                    || ($e instanceof PHPUnit_Framework_Error && $e->getCode() === E_RECOVERABLE_ERROR)
                ) {
                    $this->fail("Test fall down with correct value with error: " . $e->getMessage());
                } else {
                    throw $e;
                }
            }
        }

        // Check invalid data
        foreach ($inputDataList as $num => $inputData) {
            foreach ($inputData->getInvalid() as $elm) {
                try {
                    $invalidParams          = $validPrepared;
                    $invalidParams[$num]    = $elm;

                    call_user_func_array($userFunc, $invalidParams);
                    $this->fail(
                        "Test didn`t fall down with incorrect value with id - {$num},  and type - " . gettype($elm)
                    );
                } catch (\TypeError $e) {
                    $this->assertTrue(true);
                } catch (\Exception $e) {
                    if ($e instanceof \InvalidArgumentException
                        || ($e instanceof PHPUnit_Framework_Error && $e->getCode() === E_RECOVERABLE_ERROR)
                    ) {
                        $this->assertTrue(true);
                    } else {
                        throw $e;
                    }
                }
            }
        }
    }
}
