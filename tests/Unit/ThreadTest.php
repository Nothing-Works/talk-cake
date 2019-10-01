<?php

namespace Tests\Unit;

use App\Channel;
use App\Notifications\ThreadWasUpdated;
use App\Reply;
use App\Thread;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class ThreadTest extends TestCase
{
    /**
     * @var Thread
     */
    protected $thread;

    protected function setUp()
    {
        parent::setUp();

        $this->thread = factory(Thread::class)->create();

        factory(Reply::class, 2)->create(['thread_id' => $this->thread->id]);
    }

    public function test_it_has_a_path()
    {
        $this->assertEquals('/threads/'.$this->thread->channel->slug.'/'.$this->thread->slug, $this->thread->path());
    }

    public function test_it_has_a_user()
    {
        $this->assertInstanceOf(User::class, $this->thread->user);
    }

    public function test_it_has_many_replies()
    {
        $this->assertContainsOnlyInstancesOf(Reply::class, $this->thread->replies);
    }

    public function test_it_can_add_a_reply()
    {
        $attributes = [
            'body' => $this->faker->paragraph,
            'user_id' => 1,
        ];
        $this->thread->addReply($attributes);

        $this->assertDatabaseHas('replies', $attributes);
    }

    public function test_it_belong_to_a_channel()
    {
        $this->assertInstanceOf(Channel::class, $this->thread->channel);
    }

    public function test_a_thread_can_be_subscribed_to()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);
        $thread = factory(Thread::class)->create();

        $thread->subscribe();

        $this->assertEquals(1, $thread->subscriptions()->where('user_id', auth()->id())->count());
    }

    public function test_a_thread_can_be_unsubscribed_from()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user);

        $thread = factory(Thread::class)->create();

        $thread->subscribe();

        $thread->unsubscribe();

        $this->assertEquals(0, $thread->subscriptions()->where('user_id', auth()->id())->count());
    }

    public function test_it_knows_if_the_authenticated_user_is_subscribed_to_it()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user);

        $thread = factory(Thread::class)->create();

        $this->assertFalse($thread->isSubscribed);

        $thread->subscribe();

        $this->assertTrue($thread->isSubscribed);
    }

    public function test_a_thread_notifies_all_registered_subscribers_when_a_reply_is_added()
    {
        Notification::fake();

        $user = factory(User::class)->create();

        $this->actingAs($user);

        $this->thread->subscribe()->addReply([
        'body' => $this->faker->paragraph,
        'user_id' => 1, ]);

        Notification::assertSentTo(auth()->user(), ThreadWasUpdated::class);
    }

    public function test_a_thread_can_check_if_the_authenticated_user_has_read_all_replies()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user);

        $thread = factory(Thread::class)->create();

        $this->assertTrue($thread->hasUpdate());

        Auth::user()->readTHread($thread);

        $this->assertFalse($thread->hasUpdate());
    }

    public function test_a_thread_body_is_sanitized_automatically()
    {
        $thread = factory(Thread::class)->make(['body' => '<script>alert("andy")</script><p>This is ok</p>']);
        $this->assertEquals('<p>This is ok</p>', $thread->body);
    }

    public function test_a_thread_may_be_locked()
    {
        $this->assertFalse($this->thread->locked);
        $this->thread->lockThread();
        $this->assertTrue($this->thread->fresh()->locked);
    }
}
