<?php

namespace PhpUnitPlus\Lib\Util\Custom;

use PhpUnitPlus\Lib\Exception\PhpUnitPlusException;
use PhpUnitPlus\Lib\Util\InputDataBase;

class Manual extends InputDataBase
{
    /**
     * Check construct method for correct validation
     * @param array $valid
     * @param array $invalid
     * @throws \Exception
     */
    public function __construct(array $valid, array $invalid = [])
    {
        if (count($valid) === 0) {
            throw new \InvalidArgumentException('Valid params cant be empty');
        }

        // Auto generate invalid params if they not set
        if (count($invalid) === 0) {
            $invalid = [
                'null'              => null,
                'boolean'           => false,
                'object'            => new \stdClass(),
                'string'            => 'test',
                'emptyString'       => '',
                'integer'           => mt_rand(1, 1000),
                'zeroInteger'       => 0,
                'negativeInteger'   => -634,
                'double'            => 5.3,
                'negativeDouble'    => -27.3,
                'array'             => ['test'],
                'emptyArray'        => [],
            ];

            foreach ($valid as $elm) {
                switch ($type = strtolower(gettype($elm))) {
                    case 'null':
                        unset($invalid['null']);
                        break;

                    case 'boolean':
                        unset($invalid['boolean']);
                        break;

                    case 'object':
                        unset($invalid['object']);
                        break;

                    case 'string':
                        if ($elm === '') {
                            unset($invalid['emptyString']);
                        } else {
                            unset($invalid['string']);
                        }
                        break;

                    case 'integer':
                        if ($elm > 0) {
                            unset($invalid['integer']);
                        } elseif ($elm === 0) {
                            unset($invalid['zeroInteger']);
                        } else {
                            unset($invalid['negativeInteger']);
                        }
                        break;

                    case 'double':
                        if ($elm > 0) {
                            unset($invalid['double']);
                        } else {
                            unset($invalid['negativeDouble']);
                        }
                        break;

                    case 'array':
                        if (count($elm) > 0) {
                            unset($invalid['array']);
                        } else {
                            unset($invalid['emptyArray']);
                        }
                        break;

                    default:
                        throw new PhpUnitPlusException("Not supported type of variable was given - {$elm}");
                }
            }
        }

        $this->valid    = $valid;
        $this->invalid  = $invalid;
    }
}