<?php

namespace App\Inspections;

use Exception;

class KeyHeldDown implements ISpam
{
    private $value;

    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * @throws Exception
     */
    public function detect()
    {
        if (preg_match('/(.)\\1{4,}/', $this->value)) {
            throw new \Exception('Your reply contains spam');
        }
    }
}
