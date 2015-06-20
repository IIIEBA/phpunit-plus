<?php

namespace PhpUnitPlus\Lib\Util\Simple;

use PhpUnitPlus\Lib\Util\InputDataBase;

/**
 * Class AnyInteger
 * @package PhpUnitPlus\Lib\Util\Simple
 */
class AnyInteger extends InputDataBase
{
    /**
     * Configure class
     * @param bool $isZeroAllowed
     * @param bool $isMinusAllowed
     * @param bool $isNullAllowed
     */
    public function __construct($isZeroAllowed = true, $isMinusAllowed = true, $isNullAllowed = false)
    {
        $valid      = [mt_rand(1, 1000), PHP_INT_MAX];
        $invalid    = ['test_string', 15.2, [], false, new \stdClass()];

        if ($isZeroAllowed === true) {
            $valid[] = 0;
        } else {
            $invalid[] = 0;
        }

        if ($isMinusAllowed === true) {
            $valid[] = mt_rand(-1000, -1);
        } else {
            $invalid[] = mt_rand(-1000, -1);
        }

        if ($isNullAllowed === true) {
            $valid[] = null;
        } else {
            $invalid[] = null;
        }
    }
}
