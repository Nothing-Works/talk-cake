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
}
