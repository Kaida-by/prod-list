<?php

namespace Tests\Feature;

use App\Models\ProductList;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\HelperForTests;
use Tests\TestCase;

class ProductListTest extends TestCase
{
    use RefreshDatabase;
    use HelperForTests;

    protected string $token;

    public function setUp(): void
    {
        parent::setUp();

        $this->token = $this->getAuthUser()['token'];
    }

    public function testGetAllProductListsByUserId(): void
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $this->token,
        ])->getJson('api/product-lists/get');
        $response->assertStatus(200)
            ->assertJsonStructure([
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

    public function testCreateNewProductList(): void
    {
        $data = [
            'name' => 'test',
            'user_id' => 1,
        ];
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $this->token,
        ])->postJson('api/product-list/create', $data);
        $response->assertStatus(201);
    }

    public function testUpdateProductList(): void
    {
        $productList = ProductList::findOrFail(1);

        $data = [
            'name' => 'new test',
            'user_id' => 1,
        ];
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $this->token,
        ])->patchJson('api/product-list/update/' . $productList->id, $data);
        $response->assertStatus(200);
    }

    public function testDeleteProduct_List(): void
    {
        $productList = ProductList::findOrFail(1);
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $this->token,
        ])->deleteJson('api/product-list/delete/' . $productList->id);
        $response->assertStatus(204);
    }
}
