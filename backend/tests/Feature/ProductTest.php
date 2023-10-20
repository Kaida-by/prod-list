<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\HelperForTests;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;
    use HelperForTests;

    protected string $token;

    public function setUp(): void
    {
        parent::setUp();

        $this->token = $this->getAuthUser()['token'];
    }

    public function testGetOneProduct(): void
    {
        $data = [
            'name' => 'test',
            'count' => 1,
            'type_count_id' => 1,
            'comment_id' => 1,
            'type_product_id' => 1,
            'user_id' => auth()->id(),
            'created_at' => now(),
        ];

        $this->withHeaders([
            'Authorization' => 'Bearer '. $this->token,
        ])->postJson('api/product/create', $data);

        $product = Product::where('user_id', auth()->id())->first();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $this->token,
        ])->getJson('api/product/' . $product->id);
        $response->assertStatus(200);
    }

    public function testGetAllProductsByUserId(): void
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $this->token,
        ])->getJson('api/products/get');
        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
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
                ]
        ]);
        $response->assertStatus(200);
    }

    public function testCreateNewProduct(): void
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
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $this->token,
        ])->postJson('api/product/create', $data);
        $response->assertStatus(201);
    }

    public function testUpdateProduct(): void
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
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $this->token,
        ])->patchJson('api/product/update/' . $product->id, $data);
        $response->assertStatus(200);
    }

    public function testDeleteProduct(): void
    {
        $product = Product::findOrFail(1);
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $this->token,
        ])->deleteJson('api/product/delete/' . $product->id);
        $response->assertStatus(204);
    }
}
