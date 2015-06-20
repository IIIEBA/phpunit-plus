<?php

namespace PhpUnitPlus\Lib\Util;

use PhpUnitPlus\Lib\Component\InputDataInterface;

/**
 * Class InputDataBase
 * @package PhpUnitPlus\Lib\Util
 */
abstract class InputDataBase implements InputDataInterface
{
    /**
     * @var array
     */
    protected $valid;

    /**
     * @var array
     */
    protected $invalid;

    /**
     * Return list of valid params
     * @return array
     */
    public function getValid()
    {
        return $this->valid;
    }

    /**
     * Return list of invalid params
     * @return array
     */
    public function getInvalid()
    {
        return $this->invalid;
    }

}
