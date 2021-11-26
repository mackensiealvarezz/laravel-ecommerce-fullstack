<?php

namespace Tests\Feature\Http\Controllers\Auth;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

class AuthenticatedSessionControllerTest extends TestCase
{

    use RefreshDatabase;


    public function test_user_sees_login_form()
    {
        $response = $this->get(route('login'));

        $response->assertInertia(function($page){
            $page->component('Auth/Login');
        });

    }

    public function test_user_cant_see_login_form_if_authicated()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $response = $this->get(route('login'));
        $response->assertRedirect(route('dashboard'));

    }


    public function test_successful_login()
    {

        $user = User::factory()->create([
            'email' => 'testing@test.com',
            'password' => Hash::make('password')
        ]);

        $response = $this->post(route('login.store'), [
            'email' => $user->email,
            'password' => 'password'
        ]);

        $response->assertRedirect(route('dashboard'));
        $this->assertAuthenticatedAs($user);
    }

    public function test_incorrect_login()
    {
        $user = User::factory()->create([
            'email' => 'testing@test.com',
            'password' => Hash::make('password')
        ]);

        $response = $this->post(route('login.store'), [
            'email' => $user->email,
            'password' => 'wrongpassword'
        ]);

        $response->assertSessionHasErrors('email');

    }

    public function test_validation_errors_for_email_login()
    {
        $response = $this->post(route('login.store'), [
            'email' => '',
            'password' => 'wrongpassword'
        ]);

        $response->assertSessionHasErrors('email');
    }

    public function test_validation_errors_for_password_login()
    {
        $response = $this->post(route('login.store'), [
            'email' => 'test@test.com',
            'password' => ''
        ]);

        $response->assertSessionHasErrors('password');
    }

}
