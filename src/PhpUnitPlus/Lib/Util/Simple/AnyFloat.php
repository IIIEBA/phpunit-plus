<?php

namespace PhpUnitPlus\Lib\Util\Simple;

use PhpUnitPlus\Lib\Util\InputDataBase;

/**
 * Class AnyFloat
 * @package PhpUnitPlus\Lib\Util\Simple
 */
class AnyFloat extends InputDataBase
{
    /**
     * Configure class
     * @param bool $isZeroAllowed
     * @param bool $isMinusAllowed
     * @param bool $isNullAllowed
     */
    public function __construct($isZeroAllowed = true, $isMinusAllowed = true, $isNullAllowed = false)
    {
        $valid      = [63.3];
        $invalid    = ['test_string', mt_rand(1, 1000), [], false, new \stdClass()];

        if ($isZeroAllowed === true) {
            $valid[] = 0;
        } else {
            $invalid[] = 0;
        }

        if ($isMinusAllowed === true) {
            $valid[] = -52.3;
        } else {
            $invalid[] = -2.2;
        }

        if ($isNullAllowed === true) {
            $valid[] = null;
        } else {
            $invalid[] = null;
        }

        $this->valid    = $valid;
        $this->invalid  = $invalid;
    }
}
