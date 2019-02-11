<?php

namespace Tests\Feature;

use App\Reply;
use App\Thread;
use App\User;
use Tests\TestCase;

class ParticipateInForumTest extends TestCase
{
    public function test_an_authenticated_user_may_participate_in_forum_threads()
    {
        $this->actingAs(factory(User::class)->create());
        $thread = factory(Thread::class)->create();
        $reply = factory(Reply::class)->make();
        $this->post($thread->path().'/replies', $reply->toArray());

        $this->get($thread->path())
            ->assertStatus(200)
            ->assertSee($reply->body);
    }

    public function test_unauthenticated_user_can_not_add_reply()
    {
        $this->post('threads/andy/1/replies', [])
            ->assertRedirect('/login');
    }

    public function test_reply_requires_body()
    {
        $this->actingAs(factory(User::class)->create());

        $thread = factory(Thread::class)->create();
        $reply = factory(Reply::class)->make(['body' => null]);
        $this->post($thread->path().'/replies', $reply->toArray())
            ->assertSessionHasErrors('body');
    }

    public function test_an_authorised_can_delete_a_reply()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);
        $reply = factory(Reply::class)->create(['user_id' => $user->id]);
        $this->delete('/replies/'.$reply->id)
            ->assertStatus(302);
        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);
    }

    public function test_unauthenticated_can_not_delete_a_reply()
    {
        $reply = factory(Reply::class)->create();

        $this->delete('/replies/'.$reply->id)
            ->assertRedirect('/login');
    }

    public function test_unauthorised_can_not_delete_a_reply()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);
        $reply = factory(Reply::class)->create();
        $this->delete('/replies/'.$reply->id)
            ->assertStatus(403);
    }
}
