<?php

namespace PhpUnitPlus\Lib\Util\Simple;

use PhpUnitPlus\Lib\Util\Custom\ManualInput;
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
        $valid = [['test']];

        if ($isEmptyAllowed === true) {
            $valid[] = [];
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
