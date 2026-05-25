<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_management_dashboard(): void
    {
        $this->get('/management')
            ->assertRedirect('/login');
    }

    public function test_non_admin_user_gets_403_on_management_pages(): void
    {
        $user = User::factory()->create(['is_admin' => false]);

        $this->actingAs($user)
            ->get('/management')
            ->assertForbidden();
    }

    public function test_admin_user_can_access_management_pages_and_update_order_status(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $order = Order::create([
            'user_id' => $admin->id,
            'first_name' => 'Admin',
            'last_name' => 'User',
            'email' => 'admin@example.com',
            'phone' => '080-1234-5678',
            'address' => '1 Admin Way',
            'city' => 'Ikeja',
            'state' => 'LA',
            'zip' => '100001',
            'total' => 250.00,
            'status' => 'pending',
        ]);

        $this->actingAs($admin)
            ->get('/management')
            ->assertOk();

        $this->actingAs($admin)
            ->get('/management/orders')
            ->assertOk();

        $this->actingAs($admin)
            ->patch('/management/orders/'.$order->id, ['status' => 'completed'])
            ->assertRedirect();

        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'status' => 'completed',
        ]);
    }
}
