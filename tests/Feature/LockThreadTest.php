<?php

namespace Tests\Feature;

use App\Thread;
use App\User;
use Tests\TestCase;

class LockThreadTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_an_administrator_can_lock_any_thread()
    {
        $this->actingAs(factory(User::class)->create());
        $thread = factory(Thread::class)->create();

        $thread->lockThread();

        $this->post($thread->path().'/replies', [
            'body' => 'Foobar',
            'user_id' => auth()->id(),
        ])->assertStatus(422);
    }
}
