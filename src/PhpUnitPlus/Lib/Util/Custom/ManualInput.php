<?php

namespace PhpUnitPlus\Lib\Util\Custom;

use PhpUnitPlus\Lib\Exception\PhpUnitPlusException;
use PhpUnitPlus\Lib\Util\InputDataBase;
use PhpUnitPlus\Lib\Util\InputTypeParser;

class ManualInput extends InputDataBase
{
    use InputTypeParser;

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
                'boolean'           => (bool)mt_rand(0, 1),
                'object'            => new \stdClass(),
                'string'            => 'test',
                'emptyString'       => '',
                'integer'           => mt_rand(1, PHP_INT_MAX),
                'zeroInteger'       => 0,
                'negativeInteger'   => mt_rand(1, PHP_INT_MAX) * -1,
                'double'            => microtime(true),
                'negativeDouble'    => microtime(true) * -0.5,
                'array'             => ['test'],
                'emptyArray'        => [],
            ];

            $validTypes = $this->getTypesList($valid);
            $invalid    = array_diff_key($invalid, array_flip($validTypes));
        }

        $this->valid    = $valid;
        $this->invalid  = $invalid;
    }
}