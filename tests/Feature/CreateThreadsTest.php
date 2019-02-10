<?php

namespace Tests\Feature;

use App\Channel;
use App\Reply;
use App\Thread;
use App\User;
use Tests\TestCase;

class CreateThreadsTest extends TestCase
{
    public function test_authenticated_user_can_create_new_thread()
    {
        $this->actingAs(factory(User::class)->create());

        $thread = factory(Thread::class)->make();

        $this->post('/threads', $thread->toArray());

        $this->get($thread->path().'1')
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

    public function test_it_requires_title()
    {
        $this->publishThread(['title' => null])
            ->assertSessionHasErrors('title');
    }

    public function test_it_requires_channel()
    {
        factory(Channel::class, 2)->create();
        $this->publishThread(['channel_id' => null])
            ->assertSessionHasErrors('channel_id');

        $this->publishThread(['channel_id' => 999])
            ->assertSessionHasErrors('channel_id');
    }

    public function test_it_requires_body()
    {
        $this->publishThread(['body' => null])
            ->assertSessionHasErrors('body');
    }

    public function test_unauthorized_can_not_delete_threads()
    {
        $thread = factory(Thread::class)->create();

        $this->delete($thread->path())
            ->assertRedirect('/login');

        $user = factory(User::class)->create();

        $this->actingAs($user);

        $this->delete($thread->path())
            ->assertStatus(403);
    }

    public function test_authorized_thread_can_be_deleted()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);

        $thread = factory(Thread::class)->create(['user_id' => $user->id]);

        $reply = factory(Reply::class)->create(['thread_id' => $thread->id]);

        $this->json('DELETE', $thread->path());

        $this->assertDatabaseMissing('threads', ['id' => $thread->id]);
        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);
    }

    protected function publishThread($overrides = [])
    {
        $this->actingAs(factory(User::class)->create());

        $thread = factory(Thread::class)->raw($overrides);

        return $this->post('/threads', $thread);
    }
}
