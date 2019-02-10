<?php

namespace Tests\Feature;

use App\Thread;
use App\User;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    public function test_a_user_has_a_profile()
    {
        $user = factory(User::class)->create();

        $this->get('/profiles/'.$user->name)
            ->assertSee($user->name);
    }

    public function test_profiles_display_all_threads_created_by_the_associated_user()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);

        $thread = factory(Thread::class)->create(['user_id' => $user->id]);

        $this->get('/profiles/'.$user->name)
            ->assertSee($thread->body)
            ->assertSee($thread->title);
    }
}
