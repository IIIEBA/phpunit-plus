<?php

namespace PhpUnitPlus\Lib\Util\Simple;

use PhpUnitPlus\Lib\Util\InputDataBase;

/**
 * Class AnyString
 * @package PhpUnitPlus\Lib\Util\Simple
 */
class AnyString extends InputDataBase
{
    /**
     * Configure class
     * @param bool $isEmptyAllowed
     * @param bool $isNullAllowed
     */
    public function __construct($isEmptyAllowed = true, $isNullAllowed = false)
    {
        $valid      = ['test_string'];
        $invalid    = [mt_rand(-100, 100), 15.2, [], false, new \stdClass()];

        if ($isEmptyAllowed === true) {
            $valid[] = '';
        } else {
            $invalid[] = '';
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
