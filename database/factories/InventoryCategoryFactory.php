<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\InventoryCategory>
 */
class InventoryCategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->randomElement([
                'Vegetables', 'Fruits', 'Meats', 'Seafood', 'Dairy', 
                'Grains', 'Spices', 'Beverages', 'Condiments'
            ]),
            'description' => $this->faker->optional(0.6)->sentence(),
        ];
    }
}
