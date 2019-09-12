<?php

namespace Tests\Feature;

use App\Thread;
use App\User;
use Tests\TestCase;

class UpdateThreadsTest extends TestCase
{
    public function test_a_thread_requires_a_title_and_body_to_be_updated()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);
        $thread = factory(Thread::class)->create(['user_id' => $user->id]);
        $this->patch($thread->path(), [])->assertSessionHasErrors(['body', 'title']);
    }

    public function test_unauthorized_users_may_not_update_threads()
    {
        $user1 = factory(User::class)->create();
        $user2 = factory(User::class)->create();
        $this->actingAs($user1);
        $thread = factory(Thread::class)->create(['user_id' => $user2->id]);
        $this->patch($thread->path(), [])->assertStatus(403);
    }

    public function test_a_thread_can_be_updated_by_its_creator()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);
        $thread = factory(Thread::class)->create(['user_id' => $user->id]);
        $this->patch($thread->path(), [
            'body' => 'updated',
            'title' => 'changed',
        ]);
        tap($thread->fresh(), function ($thread) {
            $this->assertEquals('changed', $thread->title);
            $this->assertEquals('updated', $thread->body);
        });
    }
}
