<?php

namespace PhpUnitPlus\Lib\Util\Custom;

use PhpUnitPlus\Lib\Component\InputDataInterface;
use PhpUnitPlus\Lib\Util\InputDataBase;

/**
 * Class MergeInput
 *
 * @package PhpUnitPlus\Lib\Util\Custom
 */
class MergeInput extends InputDataBase{

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

            $parseParams = [
                'valid'     => $param->getValid(),
                'invalid'   => $param->getInvalid(),
            ];

            foreach ($parseParams as $name => $data) {
                foreach ($data as $elm) {
                    $tmp = [];
                    switch ($type = strtolower(gettype($elm))) {
                        case 'boolean':
                            $tmp['boolean'] = $elm;
                            break;

                        case 'null':
                            $tmp['null'] = $elm;
                            break;

                        case 'string':
                            if ($elm === '') {
                                $tmp['emptyString'] = $elm;
                            } else {
                                $tmp['string'] = $elm;
                            }
                            break;

                        case 'integer':
                            if ($elm > 0) {
                                $tmp['integer'] = $elm;
                            } elseif ($elm === 0) {
                                $tmp['zeroInteger'] = $elm;
                            } else {
                                $tmp['negativeInteger'] = $elm;
                            }
                            break;

                        case 'double':
                            if ($elm > 0) {
                                $tmp['double'] = $elm;
                            } else {
                                $tmp['negativeDouble'] = $elm;
                            }
                            break;

                        case 'array':
                            if (count($elm) > 0) {
                                $tmp['array'] = $elm;
                            } else {
                                $tmp['emptyArray'] = $elm;
                            }
                            break;

                        case 'object':
                            $tmp['object'] = $elm;
                            break;

                        default:
                            throw new \Exception("Not supported type of variable was given - {$elm}");
                    }

                    if ($name === 'valid') {
                        $valid = array_merge($valid, $tmp);
                    } elseif ($name === 'invalid') {
                        $invalid = array_merge($invalid, $tmp);
                    }
                }
            }
        }

        $this->valid    = array_values($valid);
        $this->invalid  = array_values(array_diff_key($invalid, $valid));
    }
}
