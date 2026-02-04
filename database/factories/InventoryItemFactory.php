<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\InventoryCategory;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\InventoryItem>
 */
class InventoryItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
         $items = [
            'Tomatoes', 'Lettuce', 'Onions', 'Garlic', 'Potatoes',
            'Chicken Breast', 'Beef Tenderloin', 'Salmon Fillet', 'Shrimp',
            'Olive Oil', 'Butter', 'Parmesan Cheese', 'Heavy Cream',
            'Flour', 'Sugar', 'Salt', 'Black Pepper', 'Basil', 'Thyme'
        ];
        return [
             'name' => $this->faker->unique()->randomElement($items),
            'sku' => strtoupper($this->faker->bothify('??-####')),
            'description' => $this->faker->optional(0.5)->sentence(),
            'unit' => $this->faker->randomElement(['kg', 'liters', 'pieces', 'boxes', 'bottles']),
            'current_quantity' => $this->faker->randomFloat(2, 5, 100),
            'minimum_quantity' => $this->faker->randomFloat(2, 2, 10),
            'unit_cost' => $this->faker->randomFloat(2, 0.5, 50),
            'category_id' => InventoryCategory::factory(),
        ];
    }

    public function lowStock(): static
    {
        return $this->state(function (array $attributes) {
            $min = $this->faker->randomFloat(2, 5, 10);
            return [
                'minimum_quantity' => $min,
                'current_quantity' => $this->faker->randomFloat(2, 0, $min - 1), // Below minimum
            ];
        });
    }
}
