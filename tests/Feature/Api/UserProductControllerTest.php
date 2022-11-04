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

class UserProductControllerTest extends TestCase
{
    public function test_add_product()
    {
        $role = Role::factory()->create(['name' => 'admin']);
        $user = User::factory()->create(['role_id' => $role->id]);
        $ability = $user->role->name;
        $token = Sanctum::actingAs($user, [$ability]);

        $category = Category::factory()->create();
        $product = Product::factory()->create(["category_id" => $category->id]);

        $response = $this->postJson('/api/v1/chart/add', [
            'product_id' => $product->id,
            'user_id' => $user->id,
            'amount' => 10
        ]);

        $response->assertStatus(201);
        $response->assertCreated();
    }

    // Fix 
    public function test_remove_product()
    {
        $role = Role::factory()->create(['name' => 'admin']);
        $user = User::factory()->create(['role_id' => $role->id]);

        $category = Category::factory()->create();
        $product = Product::factory()->create(["category_id" => $category->id]);

        $user_product = $user->products()->attach($product->id, ['amount' => 10]);

        $response = $this->deleteJson('/api/v1/chart/user/'.$user->uuid.'/product//'.$product->uuid);

        $response->assertStatus(204);

    }
}
