<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use App\Models\{
    User,
    Role
};

class UserControllerTest extends TestCase
{
    public function test_get_all_users_authorized()
    {
        $role = Role::factory()->create(['name' => 'admin']);

        $admin = User::factory()->create(['role_id' => $role->id]);
        $ability = $admin->role->name;
        $token = Sanctum::actingAs($admin, [$ability]);

        User::factory()->count(5)->create(['role_id' => $role->id]);

        $response = $this->getJson('/api/v1/users');

        $response->assertStatus(200);
        $response->assertJsonCount(6, 'data');
    }

    public function test_get_all_users_unauthorized()
    {
        $role = Role::factory()->create(['name' => 'guest']);

        $guest = User::factory()->create(['role_id' => $role->id]);

        User::factory()->count(5)->create(['role_id' => $role->id]);

        $response = $this->getJson('/api/v1/users');

        $response->assertStatus(401);
    }
}
