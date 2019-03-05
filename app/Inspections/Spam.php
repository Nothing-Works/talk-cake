<?php

namespace App\Inspections;

class Spam
{
    protected $inspections = [
        InvalidKeyWords::class,
        KeyHeldDown::class,
    ];

    /**
     * @param $value
     *
     * @return bool
     *
     * @throws \Exception
     */
    public function detect($value)
    {
        foreach ($this->inspections as $inspection) {
            app()->makeWith($inspection, ['value' => $value])->detect();
        }

        return false;
    }
}
