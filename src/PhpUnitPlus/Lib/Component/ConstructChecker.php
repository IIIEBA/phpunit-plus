<?php

namespace PhpUnitPlus\Lib\Component;

/**
 * Class ConstructChecker
 * @package PhpUnitPlus\Lib\Component
 */
trait ConstructChecker
{
    /**
     * Method for testing constructor with valid and invalid arrays of data, with callback function
     * @param InputDataInterface $inputData
     * @param callable $userFunc
     */
    public function checkConstructor(InputDataInterface $inputData, callable $userFunc)
    {
        // Prepare data
        $validPrepared = [];
        $maxCountValid = 0;
        foreach ($inputData->getValid() as $name => $elmPool) {
            if (($count = count($elmPool)) > $maxCountValid) {
                $maxCountValid = $count;
            }

            $validPrepared[$name] = reset($elmPool);
        }

        // Check valid params
        for ($num = 0; $num < $maxCountValid; $num++) {
            try {
                if ($num !== 0) {
                    $validPrepared = [];
                    foreach ($inputData->getValid() as $name => $values) {
                        $validPrepared[$name] = array_key_exists($num, $values) ? $values[$num] : reset($values);
                    }
                }

                call_user_func_array($userFunc, $validPrepared);
                $this->assertTrue(true);
            } catch (\InvalidArgumentException $e) {
                $this->fail("Test fall down with correct value with error: " . $e->getMessage());
            }
        }

        // Check invalid data
        foreach ($inputData->getInvalid() as $num => $elmPool) {
            foreach ($elmPool as $elm) {
                try {
                    $invalidParams          = $validPrepared;
                    $invalidParams[$num]    = $elm;

                    call_user_func_array($userFunc, $invalidParams);
                    $this->fail(
                        "Test didnt fall down with incorrect value with id - {$num},  and type - " . gettype($elm)
                    );
                } catch (\InvalidArgumentException $e) {
                    $this->assertTrue(true);
                }
            }
        }
    }
}
