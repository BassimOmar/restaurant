<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Table;
use App\Models\User;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Booking>
 */
class BookingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $bookingDate = $this->faker->dateTimeBetween('now', '+30 days');
        return [
            'booking_number' => 'BK-' . date('Ymd', $bookingDate->getTimestamp()) . '-' . $this->faker->unique()->numberBetween(1, 999),
            'table_id' => Table::factory(),
            'customer_name' => $this->faker->name(),
            'customer_phone' => $this->faker->phoneNumber(),
            'customer_email' => $this->faker->optional(0.7)->safeEmail(),
            'guest_count' => $this->faker->numberBetween(2, 8),
            'booking_date' => $bookingDate,
            'duration_minutes' => $this->faker->randomElement([60, 90, 120, 180]),
            'status' => $this->faker->randomElement(['pending', 'confirmed', 'arrived', 'completed', 'cancelled']),
            'special_requests' => $this->faker->optional(0.3)->sentence(),
            'created_by' => User::factory(),
        ];
    }

    public function confirmed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'confirmed',
        ]);
    }

    public function privateDining(): static
    {
        return $this->state(fn (array $attributes) => [
            'table_id' => Table::factory()->privateDining(),
            'guest_count' => $this->faker->numberBetween(6, 16),
            'duration_minutes' => $this->faker->randomElement([120, 180, 240]),
        ]);
    }
}
