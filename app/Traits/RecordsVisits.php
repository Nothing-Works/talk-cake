<?php

namespace App\Traits;

use Illuminate\Support\Facades\Redis;

trait RecordsVisits
{
    public function recordVisit()
    {
        Redis::incr($this->visitCacheKey());

        return $this;
    }

    public function resetVisits()
    {
        Redis::del([$this->visitCacheKey()]);

        return $this;
    }

    public function visits(): int
    {
        return Redis::get($this->visitCacheKey()) ?? 0;
    }

    protected function visitCacheKey(): string
    {
        return "threads.{$this->id}.visits";
    }
}
