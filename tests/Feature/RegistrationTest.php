<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Mail\PleaseConfirmYourEmail;
use Mail;
use App\User;

class RegistrationTest extends TestCase
{
	use DatabaseMigrations;

    /**
     * A basic test example.
     *
     * @return void
     */
    function test_a_confirmation_email_is_sent_upon_registration()
    {
    	Mail::fake();

    	$this->post(route('register'), [
    		'name' => 'john',
    		'email' => 'john@example.com',
    		'password' => 'foobar',
    		'password_confirmation' => 'foobar'
    	]);

        Mail::assertSent(PleaseConfirmYourEmail::class);
    }

    function test_user_can_fully_confirm_their_email_address()
    {
        Mail::fake();

        $this->post(route('register'), [
            'name' => 'John',
            'email' => 'john@example.com',
            'password' => 'foobar',
            'password_confirmation' => 'foobar'
        ]);

        $user = User::whereName('John')->first();

        $this->assertFalse($user->confirmed);
        $this->assertNotNull($user->confirmation_token);

        $this->get(route('register.confirm', ['token' => $user->confirmation_token]))
            ->assertRedirect(route('threads'));

        $this->assertTrue($user->fresh()->confirmed);
    }

    function test_confirming_an_invalid_token()
    {
        $this->get(route('register.confirm', ['token' => 'invalid']))
            ->assertRedirect(route('threads'))
            ->assertSessionHas('flash', 'Unknown token.');
    }
}
