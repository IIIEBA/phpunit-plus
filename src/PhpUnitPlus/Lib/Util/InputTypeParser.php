<?php

namespace PhpUnitPlus\Lib\Util;

use PhpUnitPlus\Lib\Exception\PhpUnitPlusException;

trait InputTypeParser
{
    /**
     * Get list fo types for given array (with custom, like emptyString etc)
     * @param array $data
     * @param bool $withValues
     * @return array
     * @throws \Exception
     */
    public function getTypesList(array $data, $withValues = false)
    {
        $result = [];

        foreach ($data as $elm) {
            switch (strtolower(gettype($elm))) {
                case 'boolean':
                    $result['boolean'] = $elm;
                    break;

                case 'null':
                    $result['null'] = $elm;
                    break;

                case 'string':
                    if ($elm === '') {
                        $result['emptyString'] = $elm;
                    } else {
                        $result['string'] = $elm;
                    }
                    break;

                case 'integer':
                    if ($elm > 0) {
                        $result['integer'] = $elm;
                    } elseif ($elm === 0) {
                        $result['zeroInteger'] = $elm;
                    } else {
                        $result['negativeInteger'] = $elm;
                    }
                    break;

                case 'double':
                    if ($elm > 0) {
                        $result['double'] = $elm;
                    } else {
                        $result['negativeDouble'] = $elm;
                    }
                    break;

                case 'array':
                    if (count($elm) > 0) {
                        $result['array'] = $elm;
                    } else {
                        $result['emptyArray'] = $elm;
                    }
                    break;

                case 'object':
                    $result['object'] = $elm;
                    break;

                default:
                    throw new PhpUnitPlusException("Not supported type of variable was given - {$elm}");
            }
        }

        return $withValues === true ? $result : array_keys($result);
    }
}
