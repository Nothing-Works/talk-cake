<?php

namespace Tests\Feature;

use App\Thread;
use App\User;
use Tests\TestCase;

class NotificationTest extends TestCase
{
    public function test_a_notification_is_prepared_when_a_subscribed_thread_receives_a_new_reply_not_by_current_user()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user);

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
        $user = factory(User::class)->create();

        $this->actingAs($user);

        $thread = factory(Thread::class)->create()->subscribe();

        $thread->addReply([
            'user_id' => factory(User::class)->create()->id,
            'body' => 'Some reply here',
        ]);

        $this->assertCount(1, auth()->user()->unreadNotifications);

        $notificationId = auth()->user()->unreadNotifications->first()->id;

        $this->delete('/profiles/'.auth()->user()->name.'/notifications/'.$notificationId);

        $this->assertCount(0, auth()->user()->fresh()->unreadNotifications);
    }

    public function test_a_user_can_fetch_their_unread_notifications()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user);

        $thread = factory(Thread::class)->create()->subscribe();

        $thread->addReply([
            'user_id' => factory(User::class)->create()->id,
            'body' => 'Some reply here',
        ]);

        $response = $this->getJson('/profiles/'.auth()->user()->name.'/notifications')->json();

        $this->assertCount(1, $response);
    }
}
