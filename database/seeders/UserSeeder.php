<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'linda@byekpublishing.com'],
            [
                'name' => 'Linda Ettehag Kviby',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
            ]
        );

        User::firstOrCreate(
            ['email' => 'admin@byekpublishing.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('VIAGANCI2023!!'),
            ]
        );
    }
}
