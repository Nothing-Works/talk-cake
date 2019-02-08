<?php

namespace Tests\Feature;

use App\Channel;
use App\Reply;
use App\Thread;
use App\User;
use Tests\TestCase;

class ReadThreadsTest extends TestCase
{
    /**
     * @var Thread
     */
    protected $thread;

    protected function setUp()
    {
        parent::setUp();

        $this->thread = factory(Thread::class)->create();
    }

    /**
     * A basic test example.
     */
    public function test_a_user_can_view_all_threads()
    {
        $this->get('/threads')
            ->assertStatus(200)
            ->assertSee($this->thread->title)
            ->assertSee($this->thread->body);
    }

    public function test_a_user_can_view_a_single_thread()
    {
        $this->get($this->thread->path())
            ->assertStatus(200)
            ->assertSee($this->thread->title)
            ->assertSee($this->thread->body);
    }

    public function test_a_user_can_read_replies_that_are_associated_with_a_thread()
    {
        $reply = factory(Reply::class)->create(['thread_id' => $this->thread->id]);
        $this->get($this->thread->path())
        ->assertStatus(200)
        ->assertSee($reply->body);
    }

    public function test_a_user_can_filter_threads_by_a_channel()
    {
        $channel = factory(Channel::class)->create();

        $threadInChannel = factory(Thread::class)->create(['channel_id' => $channel->id]);

        $threadNotInChannel = factory(Thread::class)->create();

        $this->get('/threads/'.$channel->slug)
            ->assertSee($threadInChannel->title)
            ->assertDontSee($threadNotInChannel->title);
    }

    public function test_a_user_can_filter_threads_by_any_name()
    {
        $user = factory(User::class)->create();

        $thread = factory(Thread::class)->create(['user_id' => $user->id]);

        $this->get('/threads?by='.$user->name)
            ->assertSee($thread->tiitle)
            ->assertDontSee($this->thread->title);
    }
}
