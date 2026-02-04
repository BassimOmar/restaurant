<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Discount>
 */
class DiscountFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $type = $this->faker->randomElement(['percentage', 'fixed_amount']);
        $value = $type === 'percentage' 
            ? $this->faker->numberBetween(5, 30)
            : $this->faker->randomFloat(2, 5, 20);
        return [
            'code' => strtoupper($this->faker->unique()->bothify('????##')),
            'name' => $this->faker->words(2, true) . ' Discount',
            'description' => $this->faker->optional(0.6)->sentence(),
            'type' => $type,
            'value' => $value,
            'minimum_order_amount' => $this->faker->randomFloat(2, 0, 50),
            'usage_limit' => $this->faker->optional(0.5)->numberBetween(10, 100),
            'used_count' => 0,
            'is_active' => $this->faker->boolean(80), // 80% active
            'valid_from' => $this->faker->optional(0.5)->dateTimeBetween('-30 days', 'now'),
            'valid_until' => $this->faker->optional(0.7)->dateTimeBetween('now', '+60 days'),
        ];
    }

    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => true,
            'valid_from' => now()->subDays(10),
            'valid_until' => now()->addDays(30),
        ]);
    }
}
