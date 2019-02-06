<?php

namespace Tests\Unit;

use App\Reply;
use App\User;
use Tests\TestCase;

class ReplyTest extends TestCase
{
    public function test_it_has_a_user()
    {
        $reply = factory(Reply::class)->create();

        $this->assertInstanceOf(User::class, $reply->user);
    }
}
