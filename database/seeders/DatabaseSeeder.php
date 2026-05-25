<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdminUserSeeder::class,
        ]);

        $primaryCustomer = User::factory()->create([
            'name' => 'Test Customer',
            'email' => 'customer@example.com',
            'password' => Hash::make('password'),
        ]);

        $extraCustomers = User::factory(3)->create();

        $catalog = [
            ['Premium Laptop', 'High-performance laptop for professionals with 16GB RAM and 512GB SSD.', 899.99, 50, 'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=400&h=300&fit=crop'],
            ['Wireless Headphones', 'Noise-cancelling wireless headphones with 30-hour battery life.', 199.99, 100, 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=400&h=300&fit=crop'],
            ['Smart Watch', 'Feature-rich smartwatch with health tracking and GPS.', 299.99, 75, 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=400&h=300&fit=crop'],
            ['Leather Backpack', 'Handcrafted leather backpack perfect for daily commute.', 149.99, 30, 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=400&h=300&fit=crop'],
            ['Mechanical Keyboard', 'RGB mechanical keyboard with tactile switches for productivity and gaming.', 129.99, 60, 'https://images.unsplash.com/photo-1587829741301-dc798b83add3?w=400&h=300&fit=crop'],
            ['Coffee Maker', 'Programmable coffee maker with thermal carafe and auto-shutoff.', 79.99, 40, 'https://images.unsplash.com/photo-1517668808822-9ebb02f2a0e6?w=400&h=300&fit=crop'],
            ['4K Monitor', '27-inch ultra HD monitor for creative professionals.', 349.99, 28, 'https://images.unsplash.com/photo-1527443224154-c4a3942d3acf?w=400&h=300&fit=crop'],
            ['Ergonomic Office Chair', 'Lumbar-support chair designed for long work sessions.', 229.00, 20, 'https://images.unsplash.com/photo-1580480055273-228ff5388ef8?w=400&h=300&fit=crop'],
            ['Portable SSD', '1TB high-speed external SSD with USB-C support.', 139.00, 95, 'https://images.unsplash.com/photo-1597848212624-e6f1d6f18b52?w=400&h=300&fit=crop'],
            ['Bluetooth Speaker', 'Compact waterproof speaker with rich bass.', 89.00, 70, 'https://images.unsplash.com/photo-1545454675-3531b543be5d?w=400&h=300&fit=crop'],
            ['Gaming Mouse', 'Precision gaming mouse with programmable buttons.', 59.99, 120, 'https://images.unsplash.com/photo-1615663245857-ac93bb7c39e7?w=400&h=300&fit=crop'],
            ['Desk Lamp', 'Minimal LED desk lamp with adjustable brightness.', 39.95, 80, 'https://images.unsplash.com/photo-1507473885765-e6ed057f782c?w=400&h=300&fit=crop'],
            ['Tablet Stand', 'Aluminum stand for tablets and e-readers.', 24.50, 110, 'https://images.unsplash.com/photo-1611186871348-b1ce696e52c9?w=400&h=300&fit=crop'],
            ['Noise-Isolating Earbuds', 'In-ear earbuds with balanced audio profile.', 69.90, 90, 'https://images.unsplash.com/photo-1484704849700-f032a568e944?w=400&h=300&fit=crop'],
            ['Smart Home Hub', 'Central controller for lights, sensors, and routines.', 189.00, 35, 'https://images.unsplash.com/photo-1518444065439-e933c06ce9cd?w=400&h=300&fit=crop'],
            ['Travel Power Bank', '20,000mAh fast-charging battery pack.', 54.90, 65, 'https://images.unsplash.com/photo-1609091839311-d5365f9ff1c5?w=400&h=300&fit=crop'],
            ['Wireless Charger', 'Qi-compatible charging pad with anti-slip finish.', 34.00, 85, 'https://images.unsplash.com/photo-1586816001966-79b736744398?w=400&h=300&fit=crop'],
            ['USB-C Docking Station', 'Multi-port dock with HDMI, Ethernet, and USB.', 159.99, 45, 'https://images.unsplash.com/photo-1625948515291-69613efd103f?w=400&h=300&fit=crop'],
            ['Laptop Sleeve', 'Water-resistant sleeve with soft inner lining.', 27.80, 130, 'https://images.unsplash.com/photo-1516382799247-87df95d790b7?w=400&h=300&fit=crop'],
        ];

        $products = collect($catalog)->map(function (array $item) {
            return Product::create([
                'name' => $item[0],
                'description' => $item[1],
                'price' => $item[2],
                'stock' => $item[3],
                'image' => $item[4],
                'is_active' => true,
            ]);
        });

        $allCustomers = collect([$primaryCustomer])->merge($extraCustomers);
        $statuses = ['pending', 'processing', 'shipped', 'completed', 'cancelled'];

        foreach (range(1, 8) as $index) {
            $customer = $allCustomers->random();
            $lineItems = $products->random(rand(1, 3));

            $order = Order::create([
                'user_id' => $customer->id,
                'first_name' => fake()->firstName(),
                'last_name' => fake()->lastName(),
                'email' => $customer->email,
                'phone' => fake()->phoneNumber(),
                'address' => fake()->streetAddress(),
                'city' => fake()->city(),
                'state' => fake()->stateAbbr(),
                'zip' => fake()->postcode(),
                'status' => $statuses[$index % count($statuses)],
                'total' => 0,
            ]);

            $total = 0;
            foreach ($lineItems as $product) {
                $qty = rand(1, 2);
                $price = (float) $product->price;
                $total += $qty * $price;

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'quantity' => $qty,
                    'price' => $price,
                ]);
            }

            $order->update(['total' => $total]);
        }
    }
}
