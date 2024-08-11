<?php

namespace Database\Factories;

use App\Enum\ProductStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->sentence,
            'description' => fake()->text,
            'price' => fake()->randomFloat(),
            'count' => fake()->randomNumber(),
            'status' => fake()->randomElement([ProductStatus::PUBLISHED, ProductStatus::DRAFT]),
            'user_id' => fake()->numberBetween(1, 5),
        ];
    }
}
