<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

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
            'name' => fake()->name(),
            'category_id' => fake()->numberBetween(1, 8),
            'price' => fake()->numberBetween(200000, 1000000),
            'quantity' => fake()->numberBetween(50, 100),
            'description' => fake()->text(255),
            'sold' => fake()->numberBetween(100, 500),
            'discount' => fake()->numberBetween(1, 25),
        ];
    }
}
