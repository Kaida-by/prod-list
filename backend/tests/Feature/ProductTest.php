<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_all_products_by_user_id(): void
    {
        $response = $this->getJson('api/auth/products/get');
        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'count',
                    'comment_id',
                    'type_count_id',
                    'type_product_id',
                    'user_id',
                ]
            ]
        ]);
        $response->assertStatus(200);
    }

    public function test_create_new_product(): void
    {
        $data = [
            'name' => 'test',
            'count' => 1,
            'type_count_id' => 1,
            'comment_id' => 1,
            'type_product_id' => 1,
            'user_id' => 1,
            'created_at' => now(),
        ];
        $response = $this->postJson('api/auth/product/create', $data);
        $response->assertStatus(201);
    }

    public function test_update_product(): void
    {
        $product = Product::findOrFail(1);

        $data = [
            'name' => 'new test',
            'count' => 2,
            'type_count_id' => 3,
            'comment_id' => 2,
            'type_product_id' => 1,
            'user_id' => 2,
        ];
        $response = $this->patchJson('api/auth/product/update/' . $product->id, $data);
        $response->assertStatus(200);
    }

    public function test_delete_product(): void
    {
        $product = Product::findOrFail(1);
        $response = $this->deleteJson('api/auth/product/delete/' . $product->id);
        $response->assertStatus(204);
    }
}
