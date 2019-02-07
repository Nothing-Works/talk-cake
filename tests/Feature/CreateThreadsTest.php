<?php

namespace Tests\Feature;

use App\Thread;
use App\User;
use Tests\TestCase;

class CreateThreadsTest extends TestCase
{
    public function test_authenticated_user_can_create_new_thread()
    {
        $this->actingAs(factory(User::class)->create());

        $thread = factory(Thread::class)->create();

        $this->post('/threads', $thread->toArray());

        $this->get($thread->path())
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }

    public function test_unauthenticated_user_can_not_create_new_thread()
    {
        $this->post('/threads', [])
            ->assertRedirect('/login');
    }

    public function test_unauthenticated_user_can_not_visit_create_page()
    {
        $this->get('/threads/create')
            ->assertRedirect('/login');
    }
}
