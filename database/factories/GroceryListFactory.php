<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\GroceryList>
 */
class GroceryListFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->words(asText: true),
        ];
    }

    public function deleted(): self
    {
        return $this->state([
            'created_at' => now()->subHours(3),
            'updated_at' => now()->subMinutes(45),
            'deleted_at' => now()->subMinute(),
        ]);
    }
}
