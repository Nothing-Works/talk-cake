<?php

namespace App\Inspections;

class Spam
{
    /**
     * @param $value
     *
     * @return bool
     *
     * @throws \Exception
     */
    public function detect($value)
    {
        $this->detectInvalidKeyWords($value);
        $this->detectKeyHeldDown($value);

        return false;
    }

    /**
     * @param $value
     *
     * @throws \Exception
     */
    protected function detectInvalidKeyWords($value)
    {
        $invalidKeyWords = [
            'yahoo customer support',
        ];

        foreach ($invalidKeyWords as $keyWord) {
            if (false !== stripos($value, $keyWord)) {
                throw new \Exception('Your reply contains spam');
            }
        }
    }

    /**
     * @param $value
     *
     * @throws \Exception
     */
    protected function detectKeyHeldDown($value)
    {
        if (preg_match('/(.)\\1{4,}/', $value)) {
            throw new \Exception('Your reply contains spam');
        }
    }
}
