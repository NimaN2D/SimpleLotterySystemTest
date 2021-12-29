<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;
    public function test_see_register_page()
    {
        $res = $this->get('/register');

        $res->assertSuccessful();
        $res->assertViewIs('auth.register');
    }

    public function test_see_login_page()
    {
        $res = $this->get('/login');

        $res->assertSuccessful();
        $res->assertViewIs('auth.login');
    }

    public function test_user_can_login()
    {
        /**@var $user User*/
        $user = User::factory()->create([
            'password' => bcrypt($password = 'Nima Nouri')
        ]);

        $res = $this->post('/login',[
            'email' => $user->email,
            'password' => $password
        ]);

        $res->assertRedirect('/');
        $this->assertAuthenticatedAs($user);
    }

    public function test_login_as_customer_and_see_index_page()
    {
        /**@var $user User*/
        $user = User::factory()->make();
        $res = $this->actingAs($user)->get('/login');
        $res->assertRedirect('/');
    }
}
