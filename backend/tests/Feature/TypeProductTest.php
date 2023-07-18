<?php

namespace Tests\Feature;

use App\Models\TypeProduct;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TypeProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_all_type_products_by_user_id(): void
    {
        $response = $this->getJson('api/auth/type-products/get');
        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'user_id',
                    'product_list_id',
                ]
            ]
        ]);
        $response->assertStatus(200);
    }

    public function test_create_new_type_product(): void
    {
        $data = [
            'name' => 'test',
            'user_id' => 1,
            'product_list_id' => 1,
            'created_at' => now(),
        ];
        $response = $this->postJson('api/auth/type-product/create', $data);
        $response->assertStatus(201);
    }

    public function test_update_type_product(): void
    {
        $typeProduct = TypeProduct::findOrFail(1);

        $data = [
            'name' => 'new test',
            'user_id' => 2,
            'product_list_id' => 1,
        ];
        $response = $this->patchJson('api/auth/type-product/update/' . $typeProduct->id, $data);
        $response->assertStatus(200);
    }

    public function test_delete_type_product(): void
    {
        $typeProduct = TypeProduct::findOrFail(1);
        $response = $this->deleteJson('api/auth/type-product/delete/' . $typeProduct->id);
        $response->assertStatus(204);
    }
}
