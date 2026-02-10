<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Customer',
            'email' => 'customer@test.com',
            'password' => Hash::make('123456'),
            'role' => 'customer'
        ]);

        User::create([
            'name' => 'Provider One',
            'email' => 'provider1@test.com',
            'password' => Hash::make('123456'),
            'role' => 'provider',
            'provider_badge' => 'registered'
        ]);

        User::create([
            'name' => 'Provider Two',
            'email' => 'provider2@test.com',
            'password' => Hash::make('123456'),
            'role' => 'provider',
            'provider_badge' => 'unregistered'
        ]);
    }
}
