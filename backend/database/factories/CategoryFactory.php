<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
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
            'has_age_restriction' => fake()->boolean,
        ];
    }

    public function restricted(): static
    {
        return $this->state(fn (array $attributes) => [
            'has_age_restriction' => true,
        ]);
    }

    public function unrestricted(): static
    {
        return $this->state(fn (array $attributes) => [
            'has_age_restriction' => false,
        ]);
    }
}
