<?php

namespace PhpUnitPlus\Lib\Util\Simple;

use PhpUnitPlus\Lib\Util\Custom\ManualInput;
use PhpUnitPlus\Lib\Util\InputDataBase;

/**
 * Class AnyFloat
 * @package PhpUnitPlus\Lib\Util\Simple
 */
class AnyFloat extends InputDataBase
{
    /**
     * Configure class
     * @param bool $isNegativeAllowed
     * @param bool $isNullAllowed
     */
    public function __construct($isNegativeAllowed = true, $isNullAllowed = false)
    {
        $valid = [microtime(true)];

        if ($isNegativeAllowed === true) {
            $valid[] = microtime(true) * -0.5;
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
