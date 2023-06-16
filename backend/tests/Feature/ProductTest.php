<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_get_all_products_by_user_id(): void
    {
        $response = $this->getJson('api/products');
        $response->assertOk();

        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'count',
                    'count_type_id',
                    'comment_id',
                    'product_type_id',
                    'user_id',
                ]
            ]
        ]);

        $response->assertStatus(200);
    }
}
