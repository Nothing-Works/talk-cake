<?php

namespace Tests\Feature;

use App\Mail\PleaseConfirmYourEmail;
use App\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    public function test_a_confirmation_email_is_sent_upon_registration()
    {
        Mail::fake();

        $this->post(route('register'), [
            'name' => 'andy',
            'email' => 'test@test.com',
            'password' => 'foobar',
            'password_confirmation' => 'foobar',
        ]);

//        event(new Registered(factory(User::class)->create()));
        Mail::assertQueued(PleaseConfirmYourEmail::class);
    }

    public function test_uer_can_fully_confirm_their_email_addresses()
    {
        Mail::fake();

        $this->post(route('register'), [
           'name' => 'andy',
           'email' => 'test@test.com',
           'password' => 'foobar',
           'password_confirmation' => 'foobar',
        ]);

        $user = User::whereName('andy')->first();

        $this->assertFalse($user->confirmed);
        $this->assertNotNull($user->confirmation_token);
        $this->get(route('register.confirm', ['token' => $user->confirmation_token]))
        ->assertRedirect(route('threads'));

        $this->assertTrue($user->fresh()->confirmed);
        $this->assertNull($user->fresh()->confirmation_token);
    }

    public function test_confirming_an_invalid_token()
    {
        $this->get(route('register.confirm', ['token' => 'invalid']))
            ->assertRedirect(route('threads'))
            ->assertSessionHas('flash', 'Unknown token');
    }
}
