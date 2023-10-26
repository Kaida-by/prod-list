<?php

namespace Database\Factories;

use App\Http\Controllers\HelpController;
use App\Models\TypeProduct;
use Exception;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<TypeProduct>
 */
class TypeProductFactory extends Factory
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
            'name' => fake()->title,
            'color' => HelpController::generateRandomColor(),
            'user_id' => random_int(1, 3),
            'product_list_id' => random_int(1, 3),
        ];
    }
}
