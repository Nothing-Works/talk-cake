<?php

namespace Tests\Feature;

use App\Reply;
use App\Thread;
use App\User;
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

    public function test_it_can_fetch_all_mentioned_users_starting_with_the_given_characters()
    {
        factory(User::class)->create(['name' => 'andy1']);
        factory(User::class)->create(['name' => 'andy2']);

        factory(User::class)->create(['name' => 'jane1']);
        factory(User::class)->create(['name' => 'jane2']);
        factory(User::class)->create(['name' => 'jane3']);

        $results1 = $this->json('GET', '/api/users', ['name' => 'andy']);
        $results2 = $this->json('GET', '/api/users', ['name' => 'jane']);
        $this->assertCount(2, $results1->json());
        $this->assertCount(3, $results2->json());
    }
}
