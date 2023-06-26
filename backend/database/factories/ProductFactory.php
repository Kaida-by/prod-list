<?php

namespace Database\Factories;

use App\Models\Product;
use Exception;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
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
            'count' => random_int(1, 10),
            'comment_id' => random_int(1, 3),
            'type_count_id' => random_int(1, 5),
            'type_product_id' => random_int(1, 3),
            'user_id' => random_int(1, 3),
        ];
    }
}
