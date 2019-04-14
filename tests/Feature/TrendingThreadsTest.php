<?php

namespace Tests\Feature;

use App\Thread;
use Illuminate\Support\Facades\Redis;
use Tests\TestCase;

class TrendingThreadsTest extends TestCase
{
    public function test_it_increment_a_threads_score_each_time_it_is_read()
    {
        $this->assertCount(0, Redis::zrevrange('treading_threads', 0, -1));
        $thread = factory(Thread::class)->create();
        $this->call('GET', $thread->path());
        $this->assertCount(1, Redis::zrevrange('treading_threads', 0, -1));
    }
}
