<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use App\Models\{
    User,
    Role,
    Product,
    Category
};

class ProductControllerTest extends TestCase
{
    public function test_get_all_products_authorized()
    {
        $role = Role::factory()->create(['name' => 'admin']);

        $admin = User::factory()->create(['role_id' => $role->id]);
        $ability = $admin->role->name;
        $token = Sanctum::actingAs($admin, [$ability]);

        $category = Category::factory()->create();
        Product::factory()->count(5)->create(["category_id" => $category->id]);

        $response = $this->getJson('/api/v1/products');

        $response->assertStatus(200);
        $response->assertJsonCount(5, 'data');
    }

    public function test_get_all_products_unauthorized()
    {
        $role = Role::factory()->create(['name' => 'guest']);

        $guest = User::factory()->create(['role_id' => $role->id]);
        
        $category = Category::factory()->create();
        Product::factory()->count(5)->create(["category_id" => $category->id]);

        $response = $this->getJson('/api/v1/products');

        // Unauthorized
        $response->assertStatus(401);
    }
}
