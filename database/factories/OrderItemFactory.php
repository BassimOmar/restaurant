<?php

namespace Database\Factories;
use App\Models\MenuItem;
use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderItem>
 */
class OrderItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $price = $this->faker->randomFloat(2, 8, 50);
        $quantity = $this->faker->numberBetween(1, 4);
        $subtotal = $price * $quantity;
        return [
            'order_id' => Order::factory(),
            'menu_item_id' => MenuItem::factory(),
            'quantity' => $quantity,
            'price' => $price,
            'subtotal' => $subtotal,
            'special_instructions' => $this->faker->optional(0.2)->sentence(5),
            'status' => $this->faker->randomElement(['pending', 'preparing', 'ready', 'served']),
        ];
    }

    public function served(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'served',
        ]);
    }
}
