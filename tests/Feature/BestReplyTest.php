<?php

namespace Tests\Feature;

use App\Reply;
use App\Thread;
use App\User;
use Tests\TestCase;

class BestReplyTest extends TestCase
{
    public function test_a_thread_creator_may_mark_any_reply_as_the_best_reply()
    {
        $this->actingAs(factory(User::class)->create());

        $thread = factory(Thread::class)->create(['user_id' => auth()->id()]);

        $replies = factory(Reply::class, 2)->create(['thread_id' => $thread->id]);

        $this->assertFalse($replies[1]->isBest());

        $this->postJson(route('best-reply.store', [$replies[1]->id]));

        $this->assertTrue($replies[1]->fresh()->isBest());
    }

    public function test_only_the_thread_creator_may_mark_a_reply_as_best()
    {
        $this->actingAs(factory(User::class)->create());

        $thread = factory(Thread::class)->create(['user_id' => auth()->id()]);

        $replies = factory(Reply::class, 2)->create(['thread_id' => $thread->id]);

        $this->actingAs(factory(User::class)->create());

        $this->postJson(route('best-reply.store', [$replies[1]->id]))->assertStatus(403);

        $this->assertFalse($replies[1]->fresh()->isBest());

    }
}
