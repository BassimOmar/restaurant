<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ActivityLog>
 */
class ActivityLogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $actions = ['created', 'updated', 'deleted', 'viewed', 'exported'];
        $models = ['Order', 'Table', 'MenuItem', 'Customer', 'Payment', 'Booking'];

        return [
            'user_id' => User::factory(),
            'action' => $this->faker->randomElement($actions),
            'model_type' => 'App\\Models\\' . $this->faker->randomElement($models),
            'model_id' => $this->faker->numberBetween(1, 100),
            'description' => $this->faker->sentence(),
            'old_values' => $this->faker->optional(0.4)->passthrough([
                'status' => 'pending',
                'total' => '45.99',
            ]),
            'new_values' => $this->faker->optional(0.4)->passthrough([
                'status' => 'completed',
                'total' => '45.99',
            ]),
            'ip_address' => $this->faker->ipv4(),
        ];
    }
}
