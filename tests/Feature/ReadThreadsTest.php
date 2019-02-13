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

    public function test_a_user_can_filter_threads_by_popularity()
    {
        $thread3 = factory(Thread::class)->create();
        $thread2 = factory(Thread::class)->create();
        $thread1 = factory(Thread::class)->create();

        factory(Reply::class, 3)->create(['thread_id' => $thread3->id]);
        factory(Reply::class, 2)->create(['thread_id' => $thread2->id]);
        factory(Reply::class, 1)->create(['thread_id' => $thread1->id]);

        $this->get('/threads?popular=1')
            ->assertSeeInOrder([
                $thread3->title,
                $thread2->title,
                $thread1->title,
            ]);
    }

    public function test_a_user_can_request_all_replies_for_a_given_thread()
    {
        $thread = factory(Thread::class)->create();

        $replies = factory(Reply::class, 2)->create(['thread_id' => $thread->id]);

        $response = $this->getJson($thread->path().'/replies')->json();

        $this->assertCount(1,$response['data']);
        $this->assertEquals(2,$response['total']);
    }
}
