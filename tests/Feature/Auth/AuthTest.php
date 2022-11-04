<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

class AuthTest extends TestCase
{
    /**
     * Login
     * @return void
     */
    public function test_login_as_admin()
    {
        $admin = Course::factory()->admin()->create();

        $response = $this->post('api/v1/login',[
            'email' => $user->email,
            'password' => 'admin'
        ]);

        $response->assertStatus(200);
        $response->dump();
    }

    /**
     * Login
     * @return void
     */
    public function test_login_as_guest()
    {
        $guest = Course::factory()->guest()->create();

        $response = $this->post('api/v1/login',[
            'email' => $user->email,
            'password' => 'guest'
        ]);

        $response->assertStatus(200);
        $response->dump();
    }

    /**
     * Logout
     * @return void
     */
    public function test_logout()
    {
        $user = Course::factory()->create();

        Sanctum::actingAs($user, "server:".$user->role->name);

        $response = $this->post('/login',[
            'email' => $user->email,
            'password' => 'guest'
        ]);
        $response = $this->post('/logout');

        $response->assertStatus(200);
        //$response->dump();
    }
}
