<?php

namespace PhpUnitPlus\Lib\Util\Simple;

use PhpUnitPlus\Lib\Util\Custom\ManualInput;
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
        $valid = [(bool)mt_rand(0, 1)];

        if ($isNullAllowed === true) {
            $valid[] = null;
        }

        $tmp = new ManualInput($valid);
        $this->valid    = $valid;
        $this->invalid  = $tmp->getInvalid();

        unset($tmp);
    }
}
