<?php

namespace PhpUnitPlus\Lib\Util\Custom;

use PhpUnitPlus\Lib\Component\InputDataInterface;
use PhpUnitPlus\Lib\Util\InputDataBase;
use PhpUnitPlus\Lib\Util\InputTypeParser;

/**
 * Class MergeInput
 *
 * @package PhpUnitPlus\Lib\Util\Custom
 */
class MergeInput extends InputDataBase{
    use InputTypeParser;

    public function __construct()
    {
        $params = func_get_args();
        if (count($params) < 2) {
            throw new \InvalidArgumentException('Must be at least two instances for merge');
        }

        $valid      = [];
        $invalid    = [];

        /**
         * @var InputDataInterface $param
         */
        foreach ($params as $param) {
            if (($param instanceof InputDataInterface) === false) {
                throw new \InvalidArgumentException('All params must be instance of InputDataInterface');
            }

            $valid   = array_merge($valid, $this->getTypesList($param->getValid(), true));
            $invalid = array_merge($invalid, $this->getTypesList($param->getInvalid(), true));
        }

        $this->valid    = array_values($valid);
        $this->invalid  = array_values(array_diff_key($invalid, $valid));
    }
}
