<?php

namespace Tests\Unit;

use App\Activity;
use App\Reply;
use App\Thread;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
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

    public function test_it_fetches_a_feed_for_any_user()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);

        factory(Thread::class, 2)->create(['user_id' => auth()->id()]);

        Auth::user()->activities()->first()->update(['created_at' => Carbon::now()->subWeek()]);

        $feed = Activity::feed(Auth::user());

        $this->assertTrue($feed->keys()->contains(
            Carbon::now()->format('Y-m-d')
        ));

        $this->assertTrue($feed->keys()->contains(
            Carbon::now()->subWeek()->format('Y-m-d')
        ));
    }
}
