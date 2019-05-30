<?php

namespace Tests\Feature;

use App\Thread;
use App\User;
use Tests\TestCase;

class LockThreadTest extends TestCase
{
    public function test_once_locked_thread_may_not_receive_new_replies()
    {
        $this->actingAs(factory(User::class)->create());
        $thread = factory(Thread::class)->create();

        $thread->lockThread();

        $this->post($thread->path().'/replies', [
            'body' => 'Foobar',
            'user_id' => auth()->id(),
        ])->assertStatus(422);
    }

    public function test_non_administrators_may_not_lock_threads()
    {
        $this->actingAs(factory(User::class)->create());
        $thread = factory(Thread::class)->create();
        $this->post(route('lock-thread.store', $thread))->assertStatus(403);
        $this->assertFalse($thread->fresh()->locked);
    }

    public function test_administrators_can_lock_threads()
    {
        $this->actingAs(factory(User::class)->states('admin')->create());
        $thread = factory(Thread::class)->create();
        $this->post(route('lock-thread.store', $thread));
        $this->assertTrue($thread->fresh()->locked);
    }
}
