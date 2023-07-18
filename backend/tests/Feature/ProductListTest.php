<?php

namespace Tests\Feature;

use App\Models\ProductList;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductListTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_all_product_lists_by_user_id(): void
    {
        $response = $this->getJson('api/auth/product-lists/get');
        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'user_id',
                ]
            ]
        ]);
        $response->assertStatus(200);
    }

    public function test_create_new_product_list(): void
    {
        $data = [
            'name' => 'test',
            'user_id' => 1,
        ];
        $response = $this->postJson('api/auth/product-list/create', $data);
        $response->assertStatus(201);
    }

    public function test_update_product_list(): void
    {
        $productList = ProductList::findOrFail(1);

        $data = [
            'name' => 'new test',
            'user_id' => 1,
        ];
        $response = $this->patchJson('api/auth/product-list/update/' . $productList->id, $data);
        $response->assertStatus(200);
    }

    public function test_delete_product_list(): void
    {
        $productList = ProductList::findOrFail(1);
        $response = $this->deleteJson('api/auth/product-list/delete/' . $productList->id);
        $response->assertStatus(204);
    }
}
