<?php

namespace Database\Seeders;

use App\Models\AppUser;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AppUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        AppUser::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password123'),
            'phone_number' => '+923313220256',
            'email_verified_at' => now(),
        ]);

        // Create supervisor user
        AppUser::create([
            'name' => 'Supervisor User',
            'email' => 'supervisor@example.com',
            'password' => Hash::make('password123'),
            'phone_number' => '+923001234567',
            'email_verified_at' => now(),
        ]);

        // Create regular users
        AppUser::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => Hash::make('password123'),
            'phone_number' => '+923007654321',
            'email_verified_at' => now(),
        ]);

        AppUser::create([
            'name' => 'Jane Smith',
            'email' => 'jane@example.com',
            'password' => Hash::make('password123'),
            'phone_number' => '+923009876543',
            'email_verified_at' => now(),
        ]);

        AppUser::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('password123'),
            'phone_number' => '+923112345678',
            'email_verified_at' => now(),
        ]);

        // Create users without phone numbers for testing
        AppUser::create([
            'name' => 'No Phone User',
            'email' => 'nophone@example.com',
            'password' => Hash::make('password123'),
            'phone_number' => null,
            'email_verified_at' => now(),
        ]);

        // You can also use factories to create more users
        // AppUser::factory(10)->create();
    }
}