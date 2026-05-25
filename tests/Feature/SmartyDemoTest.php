<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SmartyDemoTest extends TestCase
{
    use RefreshDatabase;

    public function test_smarty_products_route_renders_successfully(): void
    {
        Product::create([
            'name' => 'Smarty Phone',
            'description' => 'Phone rendered by Smarty',
            'price' => 300000.00,
            'stock' => 5,
            'image' => null,
            'is_active' => true,
        ]);

        $this->get('/smarty/products')
            ->assertOk()
            ->assertSee('Smarty Product Listing')
            ->assertSee('Smarty Phone');
    }

    public function test_smarty_products_search_filters_results(): void
    {
        Product::create([
            'name' => 'Matchable Device',
            'description' => 'Matches term',
            'price' => 150000.00,
            'stock' => 7,
            'image' => null,
            'is_active' => true,
        ]);

        Product::create([
            'name' => 'Other Item',
            'description' => 'No matching term',
            'price' => 60000.00,
            'stock' => 9,
            'image' => null,
            'is_active' => true,
        ]);

        $this->get('/smarty/products?search=Matchable')
            ->assertOk()
            ->assertSee('Matchable Device')
            ->assertDontSee('Other Item');
    }
}
