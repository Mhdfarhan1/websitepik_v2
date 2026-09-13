<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Super Admin
        User::create([
            'name' => 'Super Admin PIK-R',
            'email' => 'admin@pikr.com',
            'password' => Hash::make('password123'),
            'role' => 'super_admin',
        ]);

        // Optional: Create an example Pembina and Ketua if needed for testing
        User::create([
            'name' => 'Pembina PIK-R',
            'email' => 'pembina@pikr.com',
            'password' => Hash::make('password123'),
            'role' => 'pembina',
        ]);

        User::create([
            'name' => 'Ketua PIK-R',
            'email' => 'ketua@pikr.com',
            'password' => Hash::make('password123'),
            'role' => 'ketua',
        ]);
    }
}
