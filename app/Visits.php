<?php

namespace App;

use Illuminate\Support\Facades\Redis;

class Visits
{
    /**
     * @var mixed;
     */
    protected $thread;

    /**
     * Visits constructor.
     *
     * @param mixed
     */
    public function __construct($thread)
    {
        $this->thread = $thread;
    }

    public function record()
    {
        Redis::incr($this->cacheKey());

        return $this;
    }

    public function reset()
    {
        Redis::del([$this->cacheKey()]);

        return $this;
    }

    public function count(): int
    {
        return Redis::get($this->cacheKey()) ?? 0;
    }

    protected function cacheKey(): string
    {
        return "threads.{$this->thread->id}.visits";
    }
}
