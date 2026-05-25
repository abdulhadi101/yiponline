<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StorefrontFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_products_index_and_detail_pages_load(): void
    {
        $product = Product::create([
            'name' => 'QA Product',
            'description' => 'QA Description',
            'price' => 49.99,
            'stock' => 10,
            'image' => null,
            'is_active' => true,
        ]);

        $this->get('/')
            ->assertStatus(200);

        $this->get('/products/'.$product->id)
            ->assertStatus(200);
    }

    public function test_cart_add_update_remove_and_clear_flow(): void
    {
        $product = Product::create([
            'name' => 'Cart Product',
            'description' => 'Cart test',
            'price' => 25.00,
            'stock' => 8,
            'image' => null,
            'is_active' => true,
        ]);

        $this->post('/cart/add/'.$product->id)
            ->assertRedirect();

        $this->assertSame(1, session('cart')[$product->id]['quantity']);

        $this->patch('/cart/update/'.$product->id, ['quantity' => 3])
            ->assertRedirect();

        $this->assertSame(3, session('cart')[$product->id]['quantity']);

        $this->delete('/cart/remove/'.$product->id)
            ->assertRedirect();

        $this->assertArrayNotHasKey($product->id, session('cart', []));

        $this->post('/cart/add/'.$product->id)->assertRedirect();
        $this->delete('/cart/clear')->assertRedirect();
        $this->assertNull(session('cart'));
    }
}
