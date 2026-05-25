<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@yiponline.com'],
            [
                'name' => 'YipOnline Admin',
                'email' => 'admin@yiponline.com',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'is_admin' => true,
            ]
        );
        
        $this->command->info('Admin user created successfully!');
        $this->command->info('Email: admin@yiponline.com');
        $this->command->info('Password: password');
    }
}
