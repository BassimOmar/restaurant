<?php

namespace Database\Factories;

use App\Models\Table;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $subtotal = $this->faker->randomFloat(2, 20, 200);
        $discountAmount = $this->faker->optional(0.3)->randomFloat(2, 0, $subtotal * 0.3) ?? 0;
        $taxAmount = ($subtotal - $discountAmount) * 0.10;
        $total = $subtotal - $discountAmount + $taxAmount;

        return [
            'order_number' => 'ORD-' . date('Ymd') . '-' . str_pad($this->faker->unique()->numberBetween(1, 9999), 4, '0', STR_PAD_LEFT),
            'table_id' => Table::factory(),
            'waiter_id' => User::factory()->state(['role' => 'waiter']),
            'status' => $this->faker->randomElement(['pending', 'in_progress', 'completed', 'cancelled']),
            'subtotal' => $subtotal,
            'discount_amount' => $discountAmount,
            'tax_amount' => $taxAmount,
            'total' => $total,
            'notes' => $this->faker->optional(0.2)->sentence(),
            'completed_at' => $this->faker->optional(0.5)->dateTimeBetween('-7 days', 'now'),
        ];
    }

    public function completed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'completed',
            'completed_at' => now(),
        ]);
    }
}
