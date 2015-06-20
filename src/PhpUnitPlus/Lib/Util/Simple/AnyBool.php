<?php

namespace PhpUnitPlus\Lib\Util\Simple;

use PhpUnitPlus\Lib\Util\InputDataBase;

/**
 * Class AnyBool
 * @package PhpUnitPlus\Lib\Util\Simple
 */
class AnyBool extends InputDataBase
{
    /**
     * Configure class
     * @param bool $isNullAllowed
     */
    public function __construct($isNullAllowed = false)
    {
        $valid      = [true];
        $invalid    = ['test_string', mt_rand(1, 1000), 52.6, [], new \stdClass()];;

        if ($isNullAllowed === true) {
            $valid[] = null;
        } else {
            $invalid[] = null;
        }

        $this->valid    = $valid;
        $this->invalid  = $invalid;
    }
}
