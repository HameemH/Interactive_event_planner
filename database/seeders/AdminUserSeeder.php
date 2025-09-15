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
        // Create default organizer user if it doesn't exist
        if (!User::where('email', 'admin@momento.com')->exists()) {
            User::create([
                'name' => 'Event Organizer',
                'email' => 'admin@momento.com',
                'password' => Hash::make('admin123'),
                'role' => User::ROLE_ORGANIZER,
                'email_verified_at' => now(),
            ]);
        }
    }
}