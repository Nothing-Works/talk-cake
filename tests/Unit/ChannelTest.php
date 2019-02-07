<?php

namespace Tests\Unit;

use App\Channel;
use App\Thread;
use Tests\TestCase;

class ChannelTest extends TestCase
{
    /**
     * @var Channel
     */
    protected $channel;

    protected function setUp()
    {
        parent::setUp();
        $this->channel = factory(Channel::class)->create();
    }

    public function test_it_has_many_threads()
    {
        factory(Thread::class, 3)->create(['channel_id' => $this->channel->id]);

        $this->assertContainsOnlyInstancesOf(Thread::class, $this->channel->threads);
    }
}
