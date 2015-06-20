<?php

namespace PhpUnitPlus\Lib\Util\Simple;

use PhpUnitPlus\Lib\Util\InputDataBase;

/**
 * Class AnyFunction
 * @package PhpUnitPlus\Lib\Util\Simple
 */
class AnyFunction extends InputDataBase
{
    /**
     * Configure class
     * @param bool $isNullAllowed
     */
    public function __construct($isNullAllowed = false)
    {
        $valid      = [function(){}];
        $invalid    = ['test_string', mt_rand(1, 1000), 52.6, false, [], new \stdClass()];;

        if ($isNullAllowed === true) {
            $valid[] = null;
        } else {
            $invalid[] = null;
        }

        $this->valid    = $valid;
        $this->invalid  = $invalid;
    }
}
