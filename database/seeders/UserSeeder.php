<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        $admin = User::firstOrCreate(
            ['email' => 'admin@inventsel.com'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('Admin123'),
            ]
        );

        $admin->assignRole('Admin');

        // Staff
        $staff = User::firstOrCreate(
            ['email' => 'staff@inventsel.com'],
            [
                'name' => 'Staff',
                'password' => Hash::make('Staff123'),
            ]
        );

        $staff->assignRole('Staff');

        // Manager
        $manager = User::firstOrCreate(
            ['email' => 'manager@inventsel.com'],
            [
                'name' => 'Manager',
                'password' => Hash::make('Manager123'),
            ]
        );

        $manager->assignRole('Manager');
    }
}