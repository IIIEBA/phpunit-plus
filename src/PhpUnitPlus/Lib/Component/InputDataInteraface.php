<?php

namespace PhpUnitPlus\Lib\Component;

/**
 * Interface InputDataInterface
 * @package PhpUnitPlus\Lib\Component
 */
interface InputDataInterface
{
    /**
     * Return list of valid params
     * @return array
     */
    public function getValid();

    /**
     * Return list of invalid params
     * @return array
     */
    public function getInvalid();
}
