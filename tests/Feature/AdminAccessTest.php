<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_admin_dashboard(): void
    {
        $this->get('/admin')
            ->assertRedirect('/login');
    }

    public function test_non_admin_user_gets_403_on_admin_pages(): void
    {
        $user = User::factory()->create(['is_admin' => false]);

        $this->actingAs($user)
            ->get('/admin')
            ->assertForbidden();
    }

    public function test_admin_user_can_access_admin_pages_and_update_order_status(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $order = Order::create([
            'user_id' => $admin->id,
            'first_name' => 'Admin',
            'last_name' => 'User',
            'email' => 'admin@example.com',
            'phone' => '08000000000',
            'address' => '1 Admin Way',
            'city' => 'Ikeja',
            'state' => 'LA',
            'zip' => '100001',
            'total' => 250.00,
            'status' => 'pending',
        ]);

        $this->actingAs($admin)
            ->get('/admin')
            ->assertOk();

        $this->actingAs($admin)
            ->get('/admin/orders')
            ->assertOk();

        $this->actingAs($admin)
            ->patch('/admin/orders/'.$order->id, ['status' => 'completed'])
            ->assertRedirect();

        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'status' => 'completed',
        ]);
    }
}
