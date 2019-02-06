<?php

namespace Tests\Feature;

use App\Thread;
use Tests\TestCase;

class ThreadsTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_a_user_can_view_all_threads()
    {
        $thread = factory(Thread::class)->create();

        $this->get('/threads')
            ->assertStatus(200)
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }

    public function test_a_user_can_view_a_single_thread()
    {
        $thread = factory(Thread::class)->create();

        $this->get($thread->path())
            ->assertStatus(200)
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }
}
