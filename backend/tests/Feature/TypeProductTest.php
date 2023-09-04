<?php

namespace Tests\Feature;

use App\Models\TypeProduct;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\HelperForTests;
use Tests\TestCase;

class TypeProductTest extends TestCase
{
    use RefreshDatabase;
    use HelperForTests;

    protected string $token;

    public function setUp(): void
    {
        parent::setUp();

        $this->token = $this->getAuthUser()['token'];
    }

    public function testGetAllTypeProductsByUserId(): void
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $this->token,
        ])->getJson('api/type-products/get');
        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'data' => [
                        '*' => [
                            'id',
                            'name',
                            'user_id',
                            'product_list_id',
                        ]
                    ]
                ]
        ]);
        $response->assertStatus(200);
    }

    public function testGetOneProduct(): void
    {
        $data = [
            'name' => 'new test',
            'user_id' => 2,
            'product_list_id' => 1,
        ];

        $this->withHeaders([
            'Authorization' => 'Bearer '. $this->token,
        ])->postJson('api/type-product/create', $data);

        $typeProduct = TypeProduct::where('user_id', auth()->id())->first();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $this->token,
        ])->getJson('api/type-product/' . $typeProduct->id);
        $response->assertStatus(200);
    }

    public function testCreateNewTypeProduct(): void
    {
        $data = [
            'name' => 'test',
            'user_id' => 1,
            'product_list_id' => 1,
            'created_at' => now(),
        ];
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $this->token,
        ])->postJson('api/type-product/create', $data);
        $response->assertStatus(201);
    }

    public function testUpdateTypePoduct(): void
    {
        $typeProduct = TypeProduct::findOrFail(1);

        $data = [
            'name' => 'new test',
            'user_id' => 2,
            'product_list_id' => 1,
        ];
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $this->token,
        ])->patchJson('api/type-product/update/' . $typeProduct->id, $data);
        $response->assertStatus(200);
    }

    public function testDeleteTypeProduct(): void
    {
        $typeProduct = TypeProduct::findOrFail(1);
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $this->token,
        ])->deleteJson('api/type-product/delete/' . $typeProduct->id);
        $response->assertStatus(204);
    }
}
