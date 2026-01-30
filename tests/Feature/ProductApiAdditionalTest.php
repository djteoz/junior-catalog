<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ProductApiAdditionalTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_product_validation_errors()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['*']);

        $category = Category::factory()->create();

        $payload = [
            'name' => '', // required
            'price' => -5, // must be > 0
            'category_id' => 9999, // does not exist
        ];

        $res = $this->postJson('/api/products', $payload);

        $res->assertStatus(422);
        $res->assertJsonValidationErrors(['name', 'price', 'category_id']);
    }

    public function test_soft_delete_product()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['*']);

        $category = Category::factory()->create();
        $product = Product::factory()->create(['category_id' => $category->id]);

        $res = $this->deleteJson('/api/products/'.$product->id);
        $res->assertStatus(204);

        $this->assertSoftDeleted('products', ['id' => $product->id]);
    }
}
