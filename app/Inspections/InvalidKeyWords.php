<?php

namespace App\Inspections;

use Exception;

class InvalidKeyWords implements ISpam
{
    protected $keyWords = ['yahoo customer support'];

    private $value;

    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * @throws \Exception
     */
    public function detect()
    {
        foreach ($this->keyWords as $keyWord) {
            if (false !== stripos($this->value, $keyWord)) {
                throw new Exception('Your reply contains spam');
            }
        }
    }
}
