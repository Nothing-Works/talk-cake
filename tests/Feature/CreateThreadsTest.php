<?php

namespace Tests\Feature;

use App\Activity;
use App\Channel;
use App\Reply;
use App\Rules\Recaptcha;
use App\Thread;
use App\User;
use Mockery;
use Mockery\MockInterface;
use Tests\TestCase;

class CreateThreadsTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        app()->singleton(Recaptcha::class, function () {
            return Mockery::mock(Recaptcha::class, function (MockInterface $m) {
                $m->shouldReceive('passes')->andReturn(true);
            });
        });
    }

    public function test_a_thread_with_a_title_that_ends_in_a_number_should_generate_the_proper_slug()
    {
        factory(Thread::class)->create(['title' => 'Foo Title 24']);

        $this->publishThread(['title' => 'Foo Title 24', 'g-recaptcha-response' => 'token']);

        $this->assertTrue(Thread::whereSlug('foo-title-24-2')->exists());
    }

    public function test_new_users_must_first_confirm_their_email_address_before_creating_threads()
    {
        $this->actingAs(factory(User::class)->state('unconfirmed')->create());
        $this->post(route('threads.store'), factory(Thread::class)->raw())
            ->assertRedirect(route('threads'))
            ->assertSessionHas('flash', 'You must first confirm your email address');
    }

    public function test_user_can_create_new_thread()
    {
        $this->assertEquals(0, Thread::all()->fresh()->count());

        $this->publishThread(['g-recaptcha-response' => 'token']);

        $this->assertEquals(1, Thread::all()->fresh()->count());
    }

    public function test_unauthenticated_user_can_not_create_new_thread()
    {
        $this->post(route('threads.store'), [])
            ->assertRedirect(route('login'));
    }

    public function test_a_thread_requires_a_unique_slug()
    {
        $this->actingAs(factory(User::class)->create());

        $data = factory(Thread::class)->create(['title' => 'Foo Title']);

        $this->assertEquals($data->fresh()->slug, 'foo-title');

        $thread = factory(Thread::class)->raw(['title' => 'Foo Title',
            'g-recaptcha-response' => 'token', ]);

        $this->post(route('threads.store'), $thread);
        $this->assertTrue(Thread::whereSlug('foo-title-2')->exists());
    }

    public function test_unauthenticated_user_can_not_visit_create_page()
    {
        $this->get(route('threads.create'))
            ->assertRedirect(route('login'));
    }

    public function test_it_requires_title()
    {
        $this->publishThread(['title' => null])
            ->assertSessionHasErrors('title');
    }

    public function test_it_requires_channel()
    {
        factory(Channel::class, 2)->create();
        $this->publishThread(['channel_id' => null])
            ->assertSessionHasErrors('channel_id');

        $this->publishThread(['channel_id' => 999])
            ->assertSessionHasErrors('channel_id');
    }

    public function test_it_requires_body()
    {
        $this->publishThread(['body' => null])
            ->assertSessionHasErrors('body');
    }

    public function test_unauthorized_can_not_delete_threads()
    {
        $thread = factory(Thread::class)->create();

        $this->delete($thread->path())
            ->assertRedirect(route('login'));

        $user = factory(User::class)->create();

        $this->actingAs($user);

        $this->delete($thread->path())
            ->assertStatus(403);
    }

    public function test_authorized_thread_can_be_deleted()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);

        $thread = factory(Thread::class)->create(['user_id' => $user->id]);

        $reply = factory(Reply::class)->create(['thread_id' => $thread->id]);

        $this->json('DELETE', $thread->path());

        $this->assertDatabaseMissing('threads', ['id' => $thread->id]);
        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);

        $this->assertEquals(0, Activity::count());
    }

    public function test_a_thread_requires_recaptcha_verification()
    {
        unset(app()[Recaptcha::class]);

        $this->publishThread(['g-recaptcha-response' => 'test'])
            ->assertSessionHasErrors('g-recaptcha-response');
    }

    protected function publishThread($overrides = [])
    {
        $this->actingAs(factory(User::class)->create());

        $thread = factory(Thread::class)->raw($overrides);

        return $this->post(route('threads.store'), $thread);
    }
}
