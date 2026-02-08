<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\{
    User, Table, MenuCategory, MenuItem, Customer, Booking,
    Order, OrderItem, Payment, InventoryCategory, InventoryItem,
    InventoryTransaction, Discount, ActivityLog};

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
         // ═══════════════════════════════════════════════════════
        // 1. USERS (Staff)
        // ═══════════════════════════════════════════════════════
        
        $owner = User::create([
            'name' => 'Pierre Dubois',
            'email' => 'owner@lamaison.com',
            'password' => bcrypt('password'),
            'role' => User::ROLE_OWNER,
            'is_active' => true,
        ]);

        $supervisor = User::create([
            'name' => 'Marie Laurent',
            'email' => 'supervisor@lamaison.com',
            'password' => bcrypt('password'),
            'role' => User::ROLE_SUPERVISOR,
            'is_active' => true,
        ]);

        $waiter1 = User::create([
            'name' => 'Jean Martin',
            'email' => 'waiter@lamaison.com',
            'password' => bcrypt('password'),
            'role' => User::ROLE_WAITER,
            'is_active' => true,
        ]);

        $waiter2 = User::create([
            'name' => 'Sophie Bernard',
            'email' => 'sophie@lamaison.com',
            'password' => bcrypt('password'),
            'role' => User::ROLE_WAITER,
            'is_active' => true,
        ]);

        $waiter3 = User::create([
            'name' => 'Lucas Petit',
            'email' => 'lucas@lamaison.com',
            'password' => bcrypt('password'),
            'role' => User::ROLE_WAITER,
            'is_active' => true,
        ]);

        // ═══════════════════════════════════════════════════════
        // 2. TABLES
        // ═══════════════════════════════════════════════════════
        $tables = [];
        
        // Regular tables (Main Dining)
        for ($i = 1; $i <= 8; $i++) {
            $tables[] = Table::create([
                'table_number' => 'T' . str_pad($i, 2, '0', STR_PAD_LEFT),
                'capacity' => $i <= 4 ? 2 : 4,
                'type' => 'regular',
                'status' => 'available',
                'location' => 'Main Dining',
            ]);
        }

        // Patio tables
        for ($i = 9; $i <= 12; $i++) {
            $tables[] = Table::create([
                'table_number' => 'T' . str_pad($i, 2, '0', STR_PAD_LEFT),
                'capacity' => 4,
                'type' => 'regular',
                'status' => 'available',
                'location' => 'Patio',
            ]);
        }

        // Private dining rooms
        $tables[] = Table::create([
            'table_number' => 'PD01',
            'capacity' => 8,
            'type' => 'private_dining',
            'status' => 'available',
            'location' => 'Private Room 1',
        ]);

        $tables[] = Table::create([
            'table_number' => 'PD02',
            'capacity' => 12,
            'type' => 'private_dining',
            'status' => 'available',
            'location' => 'Private Room 2',
        ]);

        // ═══════════════════════════════════════════════════════
        // 3. MENU
        // ═══════════════════════════════════════════════════════

        // Categories
        $appetizers = MenuCategory::create([
            'name' => 'Appetizers',
            'description' => 'Start your culinary journey',
            'is_active' => true,
            'sort_order' => 1,
        ]);

        $salads = MenuCategory::create([
            'name' => 'Salads',
            'description' => 'Fresh and crisp',
            'is_active' => true,
            'sort_order' => 2,
        ]);

        $soups = MenuCategory::create([
            'name' => 'Soups',
            'description' => 'Warm comfort',
            'is_active' => true,
            'sort_order' => 3,
        ]);

        $mains = MenuCategory::create([
            'name' => 'Main Courses',
            'description' => 'Our signature dishes',
            'is_active' => true,
            'sort_order' => 4,
        ]);

        $desserts = MenuCategory::create([
            'name' => 'Desserts',
            'description' => 'Sweet indulgence',
            'is_active' => true,
            'sort_order' => 5,
        ]);

        $beverages = MenuCategory::create([
            'name' => 'Beverages',
            'description' => 'Fine wines and drinks',
            'is_active' => true,
            'sort_order' => 6,
        ]);

        // Menu Items
        $menuItems = [
            // Appetizers
            ['category' => $appetizers, 'name' => 'Bruschetta al Pomodoro', 'description' => 'Grilled bread, heirloom tomatoes, basil, balsamic', 'price' => 12.99, 'featured' => true],
            ['category' => $appetizers, 'name' => 'Escargots de Bourgogne', 'description' => 'Burgundy snails, garlic-herb butter', 'price' => 16.99, 'featured' => false],
            ['category' => $appetizers, 'name' => 'Calamari Fritti', 'description' => 'Crispy fried squid, marinara sauce', 'price' => 14.99, 'featured' => false, 'allergens' => ['shellfish']],
            
            // Salads
            ['category' => $salads, 'name' => 'Caesar Salad', 'description' => 'Romaine, parmesan, croutons, house dressing', 'price' => 11.99, 'featured' => true],
            ['category' => $salads, 'name' => 'Caprese', 'description' => 'Fresh mozzarella, tomatoes, basil, olive oil', 'price' => 13.99, 'featured' => false],
            
            // Soups
            ['category' => $soups, 'name' => 'French Onion Soup', 'description' => 'Caramelized onions, gruyere, croutons', 'price' => 9.99, 'featured' => false, 'allergens' => ['gluten', 'dairy']],
            ['category' => $soups, 'name' => 'Lobster Bisque', 'description' => 'Rich cream soup, cognac', 'price' => 15.99, 'featured' => true, 'allergens' => ['shellfish', 'dairy']],
            
            // Mains
            ['category' => $mains, 'name' => 'Ribeye Steak', 'description' => '16oz prime cut, truffle butter, seasonal vegetables', 'price' => 48.99, 'featured' => true],
            ['category' => $mains, 'name' => 'Grilled Atlantic Salmon', 'description' => 'Herb-crusted, lemon butter, asparagus', 'price' => 32.99, 'featured' => true],
            ['category' => $mains, 'name' => 'Duck Confit', 'description' => 'Crispy duck leg, cherry reduction, root vegetables', 'price' => 36.99, 'featured' => true],
            ['category' => $mains, 'name' => 'Lobster Linguine', 'description' => 'Fresh pasta, lobster tail, white wine sauce', 'price' => 42.99, 'featured' => false, 'allergens' => ['shellfish', 'gluten']],
            ['category' => $mains, 'name' => 'Chicken Piccata', 'description' => 'Pan-seared breast, lemon-caper sauce', 'price' => 28.99, 'featured' => false],
            ['category' => $mains, 'name' => 'Osso Buco', 'description' => 'Braised veal shank, gremolata, risotto', 'price' => 44.99, 'featured' => false],
            
            // Desserts
            ['category' => $desserts, 'name' => 'Crème Brûlée', 'description' => 'Vanilla bean custard, caramelized sugar', 'price' => 9.99, 'featured' => true, 'allergens' => ['dairy', 'eggs']],
            ['category' => $desserts, 'name' => 'Chocolate Lava Cake', 'description' => 'Molten center, vanilla ice cream', 'price' => 11.99, 'featured' => true, 'allergens' => ['dairy', 'eggs', 'gluten']],
            ['category' => $desserts, 'name' => 'Tiramisu', 'description' => 'Classic Italian, espresso-soaked ladyfingers', 'price' => 10.99, 'featured' => false, 'allergens' => ['dairy', 'eggs', 'gluten']],
            ['category' => $desserts, 'name' => 'Tarte Tatin', 'description' => 'Upside-down apple tart, crème fraîche', 'price' => 10.99, 'featured' => false, 'allergens' => ['gluten', 'dairy']],
            
            // Beverages
            ['category' => $beverages, 'name' => 'House Red Wine', 'description' => 'Glass or bottle', 'price' => 12.00, 'featured' => false],
            ['category' => $beverages, 'name' => 'House White Wine', 'description' => 'Glass or bottle', 'price' => 12.00, 'featured' => false],
            ['category' => $beverages, 'name' => 'Champagne', 'description' => 'Premium selection', 'price' => 18.00, 'featured' => false],
        ];

        foreach ($menuItems as $item) {
            MenuItem::create([
                'category_id' => $item['category']->id,
                'name' => $item['name'],
                'description' => $item['description'],
                'price' => $item['price'],
                'is_available' => true,
                'is_featured' => $item['featured'],
                'allergens' => $item['allergens'] ?? null,
            ]);
        }

        // ═══════════════════════════════════════════════════════
        // 4. INVENTORY
        // ═══════════════════════════════════════════════════════

        $vegetables = InventoryCategory::create(['name' => 'Vegetables', 'description' => 'Fresh produce']);
        $meats = InventoryCategory::create(['name' => 'Meats', 'description' => 'Premium cuts']);
        $seafood = InventoryCategory::create(['name' => 'Seafood', 'description' => 'Fresh catch']);
        $dairy = InventoryCategory::create(['name' => 'Dairy', 'description' => 'Dairy products']);
        $dry = InventoryCategory::create(['name' => 'Dry Goods', 'description' => 'Shelf-stable items']);

        $inventoryItems = [
            // Vegetables
            ['category' => $vegetables, 'name' => 'Tomatoes', 'sku' => 'VEG-001', 'unit' => 'kg', 'current' => 45, 'min' => 10, 'cost' => 3.50],
            ['category' => $vegetables, 'name' => 'Lettuce', 'sku' => 'VEG-002', 'unit' => 'kg', 'current' => 20, 'min' => 8, 'cost' => 2.80],
            ['category' => $vegetables, 'name' => 'Onions', 'sku' => 'VEG-003', 'unit' => 'kg', 'current' => 35, 'min' => 10, 'cost' => 1.50],
            ['category' => $vegetables, 'name' => 'Garlic', 'sku' => 'VEG-004', 'unit' => 'kg', 'current' => 8, 'min' => 3, 'cost' => 8.00],
            ['category' => $vegetables, 'name' => 'Asparagus', 'sku' => 'VEG-005', 'unit' => 'kg', 'current' => 12, 'min' => 5, 'cost' => 12.00],
            
            // Meats
            ['category' => $meats, 'name' => 'Beef Ribeye', 'sku' => 'MEAT-001', 'unit' => 'kg', 'current' => 25, 'min' => 10, 'cost' => 45.00],
            ['category' => $meats, 'name' => 'Chicken Breast', 'sku' => 'MEAT-002', 'unit' => 'kg', 'current' => 30, 'min' => 12, 'cost' => 15.00],
            ['category' => $meats, 'name' => 'Duck', 'sku' => 'MEAT-003', 'unit' => 'kg', 'current' => 8, 'min' => 5, 'cost' => 22.00],
            ['category' => $meats, 'name' => 'Veal', 'sku' => 'MEAT-004', 'unit' => 'kg', 'current' => 6, 'min' => 4, 'cost' => 38.00],
            
            // Seafood
            ['category' => $seafood, 'name' => 'Salmon', 'sku' => 'FISH-001', 'unit' => 'kg', 'current' => 15, 'min' => 8, 'cost' => 28.00],
            ['category' => $seafood, 'name' => 'Lobster', 'sku' => 'FISH-002', 'unit' => 'pieces', 'current' => 10, 'min' => 6, 'cost' => 35.00],
            ['category' => $seafood, 'name' => 'Calamari', 'sku' => 'FISH-003', 'unit' => 'kg', 'current' => 5, 'min' => 3, 'cost' => 18.00],
            
            // Dairy
            ['category' => $dairy, 'name' => 'Butter', 'sku' => 'DAIRY-001', 'unit' => 'kg', 'current' => 20, 'min' => 8, 'cost' => 8.50],
            ['category' => $dairy, 'name' => 'Heavy Cream', 'sku' => 'DAIRY-002', 'unit' => 'liters', 'current' => 15, 'min' => 6, 'cost' => 6.00],
            ['category' => $dairy, 'name' => 'Parmesan', 'sku' => 'DAIRY-003', 'unit' => 'kg', 'current' => 8, 'min' => 3, 'cost' => 32.00],
            ['category' => $dairy, 'name' => 'Mozzarella', 'sku' => 'DAIRY-004', 'unit' => 'kg', 'current' => 6, 'min' => 4, 'cost' => 12.00],
            
            // Dry Goods
            ['category' => $dry, 'name' => 'Olive Oil', 'sku' => 'DRY-001', 'unit' => 'liters', 'current' => 25, 'min' => 10, 'cost' => 18.00],
            ['category' => $dry, 'name' => 'Flour', 'sku' => 'DRY-002', 'unit' => 'kg', 'current' => 40, 'min' => 15, 'cost' => 2.50],
            ['category' => $dry, 'name' => 'Pasta', 'sku' => 'DRY-003', 'unit' => 'kg', 'current' => 30, 'min' => 12, 'cost' => 4.00],
            ['category' => $dry, 'name' => 'Rice', 'sku' => 'DRY-004', 'unit' => 'kg', 'current' => 35, 'min' => 15, 'cost' => 3.20],
        ];

        foreach ($inventoryItems as $item) {
            InventoryItem::create([
                'name' => $item['name'],
                'sku' => $item['sku'],
                'unit' => $item['unit'],
                'current_quantity' => $item['current'],
                'minimum_quantity' => $item['min'],
                'unit_cost' => $item['cost'],
                'category_id' => $item['category']->id,
            ]);
        }

        // Create some low-stock items for testing
        InventoryItem::create([
            'name' => 'Truffles',
            'sku' => 'SPEC-001',
            'unit' => 'grams',
            'current_quantity' => 50,
            'minimum_quantity' => 100,
            'unit_cost' => 120.00,
            'category_id' => $dry->id,
        ]);

        // ═══════════════════════════════════════════════════════
        // 5. DISCOUNTS
        // ═══════════════════════════════════════════════════════

        Discount::create([
            'code' => 'WELCOME20',
            'name' => 'Welcome Discount',
            'description' => 'First-time customer discount',
            'type' => 'percentage',
            'value' => 20,
            'minimum_order_amount' => 50.00,
            'usage_limit' => null,
            'used_count' => 0,
            'is_active' => true,
            'valid_from' => now()->subDays(30),
            'valid_until' => now()->addDays(60),
        ]);

        Discount::create([
            'code' => 'VIP10',
            'name' => 'VIP Members',
            'description' => 'Exclusive VIP discount',
            'type' => 'fixed_amount',
            'value' => 10.00,
            'minimum_order_amount' => 30.00,
            'usage_limit' => null,
            'used_count' => 0,
            'is_active' => true,
            'valid_from' => now()->subDays(60),
            'valid_until' => null,
        ]);

        Discount::create([
            'code' => 'EARLYBIRD',
            'name' => 'Early Bird Special',
            'description' => '15% off before 6 PM',
            'type' => 'percentage',
            'value' => 15,
            'minimum_order_amount' => 40.00,
            'usage_limit' => 100,
            'used_count' => 23,
            'is_active' => true,
            'valid_from' => now()->subDays(10),
            'valid_until' => now()->addDays(20),
        ]);

        // ═══════════════════════════════════════════════════════
        // 6. CUSTOMERS (CRM)
        // ═══════════════════════════════════════════════════════

        $customers = [];
        for ($i = 0; $i < 20; $i++) {
            $customers[] = Customer::factory()->create();
        }

        // Create VIP customers
        for ($i = 0; $i < 5; $i++) {
            $customers[] = Customer::factory()->vip()->create();
        }

        // ═══════════════════════════════════════════════════════
        // 7. BOOKINGS
        // ═══════════════════════════════════════════════════════

        // Confirmed upcoming bookings
        for ($i = 0; $i < 10; $i++) {
            Booking::factory()
                ->for($tables[array_rand($tables)])
                ->for($waiter1, 'createdBy')
                ->confirmed()
                ->create();
        }

        // Private dining bookings
        for ($i = 0; $i < 3; $i++) {
            Booking::factory()
                ->privateDining()
                ->for($waiter2, 'createdBy')
                ->confirmed()
                ->create();
        }

        // ═══════════════════════════════════════════════════════
        // 8. ORDERS & PAYMENTS
        // ═══════════════════════════════════════════════════════

        $menuItemsAll = MenuItem::all();
        $waiters = [$waiter1, $waiter2, $waiter3];

        // Completed orders from past week
        for ($i = 0; $i < 30; $i++) {
            $order = Order::factory()
                ->for($tables[array_rand($tables)])
                ->for($waiters[array_rand($waiters)], 'waiter')
                ->completed()
                ->create();

            // Add 2-5 items per order
            $itemCount = rand(2, 5);
            for ($j = 0; $j < $itemCount; $j++) {
                $menuItem = $menuItemsAll->random();
                $quantity = rand(1, 3);
                
                OrderItem::create([
                    'order_id' => $order->id,
                    'menu_item_id' => $menuItem->id,
                    'quantity' => $quantity,
                    'price' => $menuItem->price,
                    'subtotal' => $menuItem->price * $quantity,
                    'status' => 'served',
                ]);
            }

            // Recalculate order totals
            $subtotal = $order->items->sum('subtotal');
            $tax = $subtotal * 0.10;
            $order->update([
                'subtotal' => $subtotal,
                'tax_amount' => $tax,
                'total' => $subtotal + $tax,
            ]);

            // Create payment
            Payment::factory()
                ->for($order)
                ->for($order->waiter, 'processedBy')
                ->completed()
                ->create([
                    'amount' => $order->total,
                ]);
        }

        // Active orders (in progress)
        for ($i = 0; $i < 5; $i++) {
            $order = Order::factory()
                ->for($tables[array_rand($tables)])
                ->for($waiters[array_rand($waiters)], 'waiter')
                ->inProgress()
                ->create();

            // Add items
            $itemCount = rand(2, 4);
            for ($j = 0; $j < $itemCount; $j++) {
                $menuItem = $menuItemsAll->random();
                $quantity = rand(1, 2);
                
                OrderItem::create([
                    'order_id' => $order->id,
                    'menu_item_id' => $menuItem->id,
                    'quantity' => $quantity,
                    'price' => $menuItem->price,
                    'subtotal' => $menuItem->price * $quantity,
                    'status' => 'preparing',
                ]);
            }

            // Recalculate totals
            $subtotal = $order->items->sum('subtotal');
            $tax = $subtotal * 0.10;
            $order->update([
                'subtotal' => $subtotal,
                'tax_amount' => $tax,
                'total' => $subtotal + $tax,
            ]);

            // Update table status
            $order->table->update(['status' => 'occupied']);
        }

        // ═══════════════════════════════════════════════════════
        // 9. INVENTORY TRANSACTIONS
        // ═══════════════════════════════════════════════════════

        $inventoryItemsAll = InventoryItem::all();
        
        foreach ($inventoryItemsAll->take(10) as $item) {
            // Recent restock
            InventoryTransaction::factory()
                ->for($item)
                ->for($supervisor, 'user')
                ->restock()
                ->create();
        }

        // ═══════════════════════════════════════════════════════
        // 10. ACTIVITY LOGS
        // ═══════════════════════════════════════════════════════

        ActivityLog::factory()
            ->count(50)
            ->create();

        // ═══════════════════════════════════════════════════════
        // DONE!
        // ═══════════════════════════════════════════════════════
    }
}
