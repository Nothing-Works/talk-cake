<?php

namespace Tests\Unit;

use App\Reply;
use App\Thread;
use App\User;
use Tests\TestCase;

class ThreadTest extends TestCase
{
    /**
     * @var Thread
     */
    protected $thread;

    protected function setUp()
    {
        parent::setUp();

        $this->thread = factory(Thread::class)->create();

        factory(Reply::class, 2)->create(['thread_id' => $this->thread->id]);
    }

    public function test_it_has_a_path()
    {
        $this->assertEquals('/threads/'.$this->thread->id, $this->thread->path());
    }

    public function test_it_has_a_user()
    {
        $this->assertInstanceOf(User::class, $this->thread->user);
    }

    public function test_it_has_many_replies()
    {
        $this->assertContainsOnlyInstancesOf(Reply::class, $this->thread->replies);
    }

    public function test_it_can_add_a_reply()
    {
        $attributes = [
            'body' => $this->faker->paragraph,
            'user_id' => 1,
            ];
        $this->thread->addReply($attributes);

        $this->assertDatabaseHas('replies', $attributes);
    }
}
