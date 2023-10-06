<?php

namespace Tests\Feature;

use App\Models\GeneralProduct;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\HelperForTests;
use Tests\TestCase;

class GeneralProductTest extends TestCase
{
    use RefreshDatabase;
    use HelperForTests;

    protected string $token;

    public function setUp(): void
    {
        parent::setUp();

        $this->token = $this->getAuthUser()['token'];
    }

    public function testGetGeneralProducts(): void
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $this->token,
        ])->getJson('api/general-products/get');
        $response->assertStatus(200);
    }

    public function testGetOneGeneralProduct(): void
    {
        $data = [
            'name' => 'test',
            'user_id' => auth()->id(),
        ];

        $this->withHeaders([
            'Authorization' => 'Bearer '. $this->token,
        ])->postJson('api/general-product/create', $data);

        $generalProduct = GeneralProduct::where('user_id', auth()->id())->first();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $this->token,
        ])->getJson('api/general-product/' . $generalProduct->id);
        $response->assertStatus(200);
    }

    public function testCreateNewGeneralProduct(): void
    {
        $data = [
            'name' => 'test',
            'user_id' => 1,
        ];
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $this->token,
        ])->postJson('api/general-product/create', $data);
        $response->assertStatus(201);
    }

    public function testUpdateGeneralProduct(): void
    {
        $generalProduct = GeneralProduct::findOrFail(1);

        $data = [
            'name' => 'new test',
            'user_id' => 1,
        ];
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $this->token,
        ])->patchJson('api/general-product/update/' . $generalProduct->id, $data);
        $response->assertStatus(200);
    }

    public function testDeleteGeneralProduct(): void
    {
        $generalProduct = GeneralProduct::findOrFail(1);
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $this->token,
        ])->deleteJson('api/general-product/delete/' . $generalProduct->id);
        $response->assertStatus(204);
    }
}
