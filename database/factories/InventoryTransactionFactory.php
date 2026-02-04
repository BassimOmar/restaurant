<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\InventoryItem;
use App\Models\User;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\InventoryTransaction>
 */
class InventoryTransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $quantityBefore = $this->faker->randomFloat(2, 10, 100);
        $quantity = $this->faker->randomFloat(2, 1, 20);
        $type = $this->faker->randomElement(['in', 'out', 'adjustment', 'waste']);
        
        $quantityAfter = match($type) {
            'in', 'adjustment' => $quantityBefore + $quantity,
            'out', 'waste' => $quantityBefore - $quantity,
        };

        return [
            'inventory_item_id' => InventoryItem::factory(),
            'type' => $type,
            'quantity' => $quantity,
            'quantity_before' => $quantityBefore,
            'quantity_after' => max(0, $quantityAfter),
            'reason' => $this->faker->optional(0.7)->sentence(),
            'user_id' => User::factory()->state(['role' => 'supervisor']),
        ];
    }

    public function restock(): static
    {
        return $this->state(function (array $attributes) {
            $quantityBefore = $this->faker->randomFloat(2, 5, 50);
            $quantity = $this->faker->randomFloat(2, 20, 100);
            
            return [
                'type' => 'in',
                'quantity' => $quantity,
                'quantity_before' => $quantityBefore,
                'quantity_after' => $quantityBefore + $quantity,
                'reason' => 'Delivery received from supplier',
            ];
        });
    }
}
