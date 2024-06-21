<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductVariant>
 */
class ProductVariantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'product_id' => 40,
            'color' => fake()->colorName(),
            'image' => 'http://localhost:8000/storage/images/1716424120air-jordan-1-low-shoes-459b4T (3).png',
        ];
    }
}
