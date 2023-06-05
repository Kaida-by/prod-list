<?php

namespace Database\Factories;

use Exception;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Phone>
 */
class PhoneFactory extends Factory
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
            'code' => random_int(100, 999),
            'number' => random_int(1000000, 9999999)
        ];
    }
}
