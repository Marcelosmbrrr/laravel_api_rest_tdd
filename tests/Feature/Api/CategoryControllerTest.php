<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\{
    User,
    Category,
    Role
};
use Laravel\Sanctum\Sanctum;

class CategoryControllerTest extends TestCase
{

    public function test_get_all_categories_authorized()
    {   
        $role = Role::factory()->create(['name' => 'admin']);

        $admin = User::factory()->create(['role_id' => $role->id]);
        $ability = $admin->role->name;
        $token = Sanctum::actingAs($admin, [$ability]);

        Category::factory()->count(5)->create();

        $response = $this->getJson('api/v1/categories');

        $response->assertStatus(200);
        $response->assertJsonCount(5, 'data');
    }

    public function test_get_all_categories_unauthorized()
    {
        $role = Role::factory()->create(['name' => 'guest']);

        $guest = User::factory()->create(['role_id' => $role->id]);

        Category::factory()->count(5)->create();
        
        $response = $this->getJson('api/v1/categories');

        // Unauthorized
        $response->assertStatus(401);
    }
}
