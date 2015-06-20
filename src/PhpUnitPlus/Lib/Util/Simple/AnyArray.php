<?php

namespace PhpUnitPlus\Lib\Util\Simple;

use PhpUnitPlus\Lib\Util\InputDataBase;

/**
 * Class AnyArray
 * @package PhpUnitPlus\Lib\Util\Simple
 */
class AnyArray extends InputDataBase
{
    /**
     * Configure class
     * @param bool $isEmptyAllowed
     * @param bool $isNullAllowed
     */
    public function __construct($isEmptyAllowed = true, $isNullAllowed = false)
    {
        $valid      = [['test']];
        $invalid    = ['test_string', mt_rand(1, 1000), 52.6, false, new \stdClass()];

        if ($isEmptyAllowed === true) {
            $valid[] = [];
        } else {
            $invalid[] = [];
        }

        if ($isNullAllowed === true) {
            $valid[] = null;
        } else {
            $invalid[] = null;
        }
    }
}
