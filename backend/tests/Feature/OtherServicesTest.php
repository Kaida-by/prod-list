<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\HelperForTests;
use Tests\TestCase;

class OtherServicesTest extends TestCase
{
    use RefreshDatabase;
    use HelperForTests;

    protected string $token;

    public function setUp(): void
    {
        parent::setUp();

        $this->token = $this->getAuthUser()['token'];
    }

    public function testGetTypeProducts(): void
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $this->token,
        ])->getJson('api/type-counts/get');
        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'name',
                    ]
                ]
            ]);
        $response->assertStatus(200);
    }

    public function testGetAllGeneralProduct(): void
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $this->token,
        ])->getJson('api/general-products/get');

        $response->assertStatus(200);
    }

    public function testGetAllGeneralTypeProduct(): void
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $this->token,
        ])->getJson('api/general-type-products/get');

        $response->assertStatus(200);
    }
}
