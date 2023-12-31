<?php

namespace Database\Factories;

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
            'name' => fake()->unique()->word,
            'image_url' => fake()->imageUrl(600, 600),
            'description' => implode('<br>', fake()->paragraphs(3)),
            'price' => fake()->numberBetween($min = 1000, $max = 600000)
        ];
    }
}
