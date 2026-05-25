<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CheckoutOrderFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_checkout_requires_authentication(): void
    {
        $this->get('/checkout')
            ->assertRedirect('/login');
    }

    public function test_authenticated_user_can_place_order_and_stock_decrements(): void
    {
        $user = User::factory()->create();

        $product = Product::create([
            'name' => 'Order Product',
            'description' => 'Order test',
            'price' => 100000.00,
            'stock' => 10,
            'image' => null,
            'is_active' => true,
        ]);

        $this->withSession([
            'cart' => [
                $product->id => [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => 100000.00,
                    'image' => null,
                    'quantity' => 2,
                ],
            ],
        ]);

        $response = $this->actingAs($user)->post('/orders', [
            'first_name' => 'Ada',
            'last_name' => 'Lovelace',
            'email' => 'ada@example.com',
            'phone' => '080-1234-5678',
            'address' => '123 Main Street',
            'city' => 'Lagos',
            'state' => 'LA',
            'zip' => '100001',
        ]);

        $order = Order::first();

        $response->assertRedirect('/orders/'.$order->id.'/confirmation');
        $this->assertDatabaseCount('orders', 1);
        $this->assertDatabaseCount('order_items', 1);

        $orderItem = OrderItem::first();
        $this->assertSame('Order Product', $orderItem->product_name);
        $this->assertSame(2, $orderItem->quantity);

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'stock' => 8,
        ]);
    }
}
