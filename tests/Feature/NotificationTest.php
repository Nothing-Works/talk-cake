<?php

namespace Tests\Feature;

use App\Thread;
use App\User;
use Illuminate\Notifications\DatabaseNotification;
use Tests\TestCase;

class NotificationTest extends TestCase
{
    protected function setUp()
    {
        parent::setUp();

        $user = factory(User::class)->create();

        $this->actingAs($user);
    }

    public function test_a_notification_is_prepared_when_a_subscribed_thread_receives_a_new_reply_not_by_current_user()
    {
        $thread = factory(Thread::class)->create()->subscribe();

        $this->assertCount(1, $thread->subscriptions);

        $this->assertCount(0, auth()->user()->notifications);

        $thread->addReply([
            'user_id' => auth()->id(),
            'body' => 'Some reply here',
        ]);

        $this->assertCount(0, auth()->user()->fresh()->notifications);

        $thread->addReply([
            'user_id' => factory(User::class)->create()->id,
            'body' => 'Some reply here',
        ]);

        $this->assertCount(1, auth()->user()->fresh()->notifications);
    }

    public function test_a_user_can_mark_a_notification_as_read()
    {
        factory(DatabaseNotification::class)->create();

        $this->assertCount(1, auth()->user()->unreadNotifications);

        $this->delete('/profiles/'.auth()->user()->name.'/notifications/'. auth()->user()->unreadNotifications->first()->id);

        $this->assertCount(0, auth()->user()->fresh()->unreadNotifications);
    }

    public function test_a_user_can_fetch_their_unread_notifications()
    {
        factory(DatabaseNotification::class)->create();

        $this->assertCount(1, $this->getJson('/profiles/'.auth()->user()->name.'/notifications')->json());
    }
}
