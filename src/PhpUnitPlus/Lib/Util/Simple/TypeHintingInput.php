<?php

namespace PhpUnitPlus\Lib\Util\Simple;

use PhpUnitPlus\Lib\Util\InputDataBase;

/**
 * Class TypeHintingInput
 * @package PhpUnitPlus\Lib\Util\Simple
 */
class TypeHintingInput extends InputDataBase
{
    /**
     * @param object|array|callable $value
     * @param bool $isNullAllowed
     */
    public function __construct($value, $isNullAllowed = false)
    {
        if (!is_object($value)
            && !is_array($value)
            && !is_callable($value)
        ) {
            throw new \InvalidArgumentException(
                'You must use only that types of variables which allowed by PHP type hinting'
            );
        }

        $valid      = [$value];
        $invalid    = [];

        if ($isNullAllowed === true) {
            $valid[] = null;
        } else {
            $invalid[] = null;
        }

        $this->valid    = $valid;
        $this->invalid  = $invalid;
    }
}
