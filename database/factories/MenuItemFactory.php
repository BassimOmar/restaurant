<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\MenuCategory;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MenuItem>
 */
class MenuItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $dishes = [
            'Caesar Salad', 'French Onion Soup', 'Bruschetta', 'Caprese Salad',
            'Grilled Salmon', 'Ribeye Steak', 'Chicken Parmesan', 'Lobster Tail',
            'Fettuccine Alfredo', 'Spaghetti Carbonara', 'Risotto', 'Lamb Chops',
            'Crème Brûlée', 'Tiramisu', 'Chocolate Lava Cake', 'Cheesecake'
        ];

        return [
            'category_id' => MenuCategory::factory(),
            'name' => $this->faker->unique()->randomElement($dishes),
            'description' => $this->faker->sentence(8),
            'price' => $this->faker->randomFloat(2, 8, 50),
            'image' => null,
            'is_available' => $this->faker->boolean(90), // 90% available
            'is_featured' => $this->faker->boolean(20), // 20% featured
            'allergens' => $this->faker->randomElement([
                ['nuts', 'dairy'],
                ['gluten', 'eggs'],
                ['shellfish'],
                ['dairy'],
                null,
            ]),
        ];
    }

    public function featured(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_featured' => true,
            'is_available' => true,
        ]);
    }

    public function unavailable(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_available' => false,
        ]);
    }
}
