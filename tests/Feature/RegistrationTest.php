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
        event(new Registered(factory(User::class)->create()));
        Mail::assertSent(PleaseConfirmYourEmail::class);
    }

    public function test_uer_can_fully_confirm_their_email_addresses()
    {
        $this->post('/register', [
           'name' => 'andy',
           'email' => 'test@test.com',
           'password' => 'foobar',
           'password_confirmation' => 'foobar',
        ]);

        $user = User::whereName('andy')->first();

        $this->assertFalse($user->confirmed);
        $this->assertNotNull($user->confirmation_token);

        $response = $this->get('/register/confirm?token='.$user->confirmation_token);

        $this->assertTrue($user->fresh()->confirmed);

        $response->assertRedirect('/threads');
    }
}
