<?php

namespace Tests\Feature;

use App\Thread;
use App\User;
use Tests\TestCase;

class SubscribeThreadsTest extends TestCase
{
    public function test_a_user_can_subscribe_to_threads()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user);

        $thread = factory(Thread::class)->create();

        $this->post($thread->path().'/subscriptions');

        $this->assertCount(1, $thread->subscriptions);


    }
}
