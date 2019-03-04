<?php

namespace App;

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
}
