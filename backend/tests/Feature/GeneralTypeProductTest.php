<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\HelperForTests;
use Tests\TestCase;
use App\Models\GeneralTypeProduct;

class GeneralTypeProductTest extends TestCase
{
    use RefreshDatabase;
    use HelperForTests;

    protected string $token;

    public function setUp(): void
    {
        parent::setUp();

        $this->token = $this->getAuthUser()['token'];
    }

    public function testGetGeneralTypeProducts(): void
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $this->token,
        ])->getJson('api/general-type-products/get');
        $response->assertStatus(200);
    }

    public function testGetOneGeneralTypeProduct(): void
    {
        $data = [
            'name' => 'test',
            'user_id' => auth()->id(),
        ];

        $this->withHeaders([
            'Authorization' => 'Bearer '. $this->token,
        ])->postJson('api/general-type-product/create', $data);

        $generalTypeProduct = GeneralTypeProduct::where('user_id', auth()->id())->first();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $this->token,
        ])->getJson('api/general-type-product/' . $generalTypeProduct->id);
        $response->assertStatus(200);
    }

    public function testCreateNewGeneralTypeProduct(): void
    {
        $data = [
            'name' => 'test',
            'user_id' => 1,
        ];
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $this->token,
        ])->postJson('api/general-type-product/create', $data);
        $response->assertStatus(201);
    }

    public function testUpdateGeneralTypeProduct(): void
    {
        $generalTypeProduct = GeneralTypeProduct::findOrFail(1);

        $data = [
            'name' => 'new test',
            'user_id' => 1,
        ];
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $this->token,
        ])->patchJson('api/general-type-product/update/' . $generalTypeProduct->id, $data);
        $response->assertStatus(200);
    }

    public function testDeleteGeneralTypeProduct(): void
    {
        $generalTypeProduct = GeneralTypeProduct::findOrFail(1);
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $this->token,
        ])->deleteJson('api/general-type-product/delete/' . $generalTypeProduct->id);
        $response->assertStatus(204);
    }
}
