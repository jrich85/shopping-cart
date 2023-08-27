<?php

namespace Database\Factories;

use App\Models\GroceryList;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Grocery>
 */
class GroceryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'grocery_list_id' => GroceryList::factory(),
        ];
    }
}
