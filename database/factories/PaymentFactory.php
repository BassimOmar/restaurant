<?php

namespace Database\Factories;
use App\Models\User;
use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'order_id' => Order::factory(),
            'payment_number' => 'PAY-' . date('Ymd') . '-' . str_pad($this->faker->unique()->numberBetween(1, 9999), 4, '0', STR_PAD_LEFT),
            'payment_method' => $this->faker->randomElement(['cash', 'card', 'mobile', 'other']),
            'amount' => $this->faker->randomFloat(2, 20, 300),
            'status' => $this->faker->randomElement(['pending', 'completed', 'failed']),
            'reference' => $this->faker->optional(0.5)->bothify('TXN-########'),
            'processed_by' => User::factory()->state(['role' => 'waiter']),
            'paid_at' => $this->faker->optional(0.8)->dateTimeBetween('-7 days', 'now'),
        ];
    }

    public function completed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'completed',
            'paid_at' => now(),
        ]);
    }
}
