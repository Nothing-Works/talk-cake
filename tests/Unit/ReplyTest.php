<?php

namespace Tests\Unit;

use App\Reply;
use App\Thread;
use App\User;
use Carbon\Carbon;
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

    public function test_it_knows_if_it_was_just_published()
    {
        $this->assertTrue($this->reply->wasJustPublished());

        $this->reply->created_at = Carbon::now()->subMonth();

        $this->assertFalse($this->reply->wasJustPublished());
    }

    public function test_it_can_detect_all_mentioned_users_in_the_body()
    {
        $jane = factory(User::class)->create(['name' => 'jane']);

        $john = factory(User::class)->create(['name' => 'john']);

        $reply = factory(Reply::class)->create(['body' => '@jane wants to talk to @john']);

        $this->assertTrue($reply->mentionedUsers()->contains('name', $jane->name));

        $this->assertTrue($reply->mentionedUsers()->contains('name', $john->name));
    }

    public function test_it_wraps_mentioned_username_in_the_body_within_anchor_tags()
    {
        $reply = factory(Reply::class)->create(['body' => 'Hello @jane-doe.']);

        $this->assertEquals('Hello <a href="/profiles/jane-doe">@jane-doe</a>.', $reply->body);
    }
}
