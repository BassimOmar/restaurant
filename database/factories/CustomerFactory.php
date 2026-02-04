<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
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
            'phone' => $this->faker->unique()->phoneNumber(),
            'email' => $this->faker->unique()->safeEmail(),
            'birthday' => $this->faker->optional(0.6)->date(),
            'notes' => $this->faker->optional(0.3)->sentence(),
            'total_visits' => $this->faker->numberBetween(0, 50),
            'total_spent' => $this->faker->randomFloat(2, 0, 5000),
            'last_visit' => $this->faker->optional(0.8)->dateTimeBetween('-6 months', 'now'),
            'is_vip' => $this->faker->boolean(10), // 10% are VIP
        ];
    }

    public function vip(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_vip' => true,
            'total_visits' => $this->faker->numberBetween(20, 100),
            'total_spent' => $this->faker->randomFloat(2, 2000, 10000),
        ]);
    }
}
