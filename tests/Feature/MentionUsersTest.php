<?php

namespace Tests\Feature;

use App\Reply;
use App\User;
use App\Thread;
use Tests\TestCase;

class MentionUsersTest extends TestCase
{
    public function test_mentioned_users_are_notified()
    {
        $john = factory(User::class)->create(['name' => 'john']);

        $jane = factory(User::class)->create(['name' => 'jane']);

        $this->actingAs($john);

        $thread = factory(Thread::class)->create();

        $reply = factory(Reply::class)->make(['body' => '@jane look at this']);

        $this->post($thread->path().'/replies', $reply->toArray());

        $this->assertCount(1, $jane->notifications);
    }
}
