<?php

namespace Tests\Unit;

use App\Reply;
use App\Thread;
use App\User;
use Tests\TestCase;

class ReplyTest extends TestCase
{
    /**
     * @var Reply
     */
    protected $reply;

    protected function setUp()
    {
        parent::setUp();

        $this->reply = factory(Reply::class)->create();
    }

    public function test_it_has_a_user()
    {
        $this->assertInstanceOf(User::class, $this->reply->user);
    }

    public function test_it_has_a_thread()
    {
        $this->assertInstanceOf(Thread::class, $this->reply->thread);
    }
}
