<?php

namespace Tests\Feature;

use App\Thread;
use App\Trending;
use Tests\TestCase;

class TrendingThreadsTest extends TestCase
{
    /**
     * @var Trending
     */
    protected $trending;

    protected function setUp()
    {
        parent::setUp();
        $this->trending = new Trending();

        $this->trending->reset();
    }

    public function test_it_increment_a_threads_score_each_time_it_is_read()
    {
        $this->assertCount(0, $this->trending->get());
        $thread = factory(Thread::class)->create();
        $this->call('GET', $thread->path());
        $trending = $this->trending->get();
        $this->assertCount(1, $trending);
        $this->assertEquals($thread->title, $trending[0]->title);
    }
}
