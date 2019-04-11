<?php

namespace Tests\Unit;

use App\Reply;
use App\Thread;
use App\User;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * @var User
     */
    protected $user;

    protected function setUp()
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
        factory(Thread::class, 2)->create(['user_id' => $this->user->id]);
        factory(Reply::class, 2)->create(['user_id' => $this->user->id]);
    }

    public function test_it_has_many_threads()
    {
        $this->assertContainsOnlyInstancesOf(Thread::class, $this->user->threads);
    }

    public function test_it_has_many_replies()
    {
        $this->assertContainsOnlyInstancesOf(Reply::class, $this->user->replies);
    }

    public function test_a_user_can_fetch_their_most_recent_reply()
    {
        $user = factory(User::class)->create();
        $reply = factory(Reply::class)->create(['user_id' => $user->id]);
        $this->assertEquals($user->lastReply->id, $reply->id);
    }

    public function test_a_user_can_determine_their_avatar_path()
    {
        $user = factory(User::class)->create();
        $this->assertEquals('/img/default.jpg', $user->avatar());

        $user->avatar_path = 'avatars/me.jpg';

        $this->assertEquals('/storage/avatars/me.jpg', $user->avatar());
    }
}
