<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Table>
 */
class TableFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'table_number' => 'T' . $this->faker->unique()->numberBetween(1, 25),
            'capacity' => $this->faker->randomElement([2, 4, 6, 8]),
            'type' => $this->faker->randomElement(['regular', 'private_dining']),
            'status' => 'available',
            'location' => $this->faker->randomElement([
                'Main Dining', 'Patio', 'Window Side', 'Bar Area', 'Private Room'
            ]),
        ];
    }

    public function privateDining(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'private_dining',
            'capacity' => $this->faker->numberBetween(6, 12),
            'location' => 'Private Room',
        ]);
    }

    public function occupied(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'occupied',
        ]);
    }
}
