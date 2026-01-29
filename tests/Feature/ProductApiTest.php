<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ProductApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_can_list_products()
    {
        $category = Category::factory()->create();
        Product::factory()->count(3)->create(['category_id' => $category->id]);

        $response = $this->getJson('/api/products');
        $response->assertStatus(200)
            ->assertJsonStructure(['data', 'links', 'meta']);
    }

    public function test_create_product_requires_auth()
    {
        $category = Category::factory()->create();
        $payload = [
            'name' => 'Test Product',
            'description' => 'Desc',
            'price' => 10,
            'category_id' => $category->id,
        ];

        $this->postJson('/api/products', $payload)->assertStatus(401);
    }

    public function test_authenticated_can_create_product()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['*']);

        $category = Category::factory()->create();
        $payload = [
            'name' => 'New Product',
            'description' => 'Desc',
            'price' => 99.99,
            'category_id' => $category->id,
        ];

        $res = $this->postJson('/api/products', $payload);
        $res->assertStatus(201)
            ->assertJsonPath('data.name', 'New Product');

        $this->assertDatabaseHas('products', ['name' => 'New Product']);
    }
}
