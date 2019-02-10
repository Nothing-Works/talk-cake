<?php

namespace Tests\Unit;

use App\Activity;
use App\Reply;
use App\Thread;
use App\User;
use Tests\TestCase;

class ActivityTest extends TestCase
{
    public function test_it_records_an_activity_when_a_thread_is_created()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user);

        $thread = factory(Thread::class)->create();

        $this->assertDatabaseHas('activities', [
            'user_id' => $user->id,
           'subject_id' => $thread->id,
           'subject_type' => get_class($thread),
            'type' => 'created_thread',
        ]);

        $activity = Activity::firstOrFail();

        $this->assertEquals($activity->subject->id, $thread->id);
    }

    public function test_it_records_activities_when_a_reply_is_created()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user);

        factory(Reply::class)->create();

        $this->assertEquals(2, Activity::count());
    }
}
