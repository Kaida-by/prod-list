<?php

namespace Database\Factories;

use App\Models\ProductList;
use Exception;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ProductList>
 */
class ProductListFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     * @throws Exception
     */
    public function definition(): array
    {
        return [
            'name' => fake()->colorName,
            'user_id' => random_int(1, 3),
        ];
    }
}
