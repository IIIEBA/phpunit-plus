<?php

namespace PhpUnitPlus\Lib\Util\Simple;

use PhpUnitPlus\Lib\Util\Custom\ManualInput;
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
     * @param bool $isNegativeAllowed
     * @param bool $isNullAllowed
     */
    public function __construct($isZeroAllowed = true, $isNegativeAllowed = true, $isNullAllowed = false)
    {
        $valid = [mt_rand(1, PHP_INT_MAX), PHP_INT_MAX];

        if ($isZeroAllowed === true) {
            $valid[] = 0;
        }

        if ($isNegativeAllowed === true) {
            $valid[] = mt_rand(1, PHP_INT_MAX) * -1;
        }

        if ($isNullAllowed === true) {
            $valid[] = null;
        }

        $tmp = new ManualInput($valid);
        $this->valid    = $valid;
        $this->invalid  = $tmp->getInvalid();

        unset($tmp);
    }
}
