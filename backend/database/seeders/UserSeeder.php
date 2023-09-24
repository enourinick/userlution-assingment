<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Author', 
            'email' => 'user@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('123456'),
            'date_of_birth' => '1991/07/28'
        ]);

        User::create([
            'name' => 'GrandUser', 
            'email' => 'granduser@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('123456'),
            'date_of_birth' => now()->subYears(80)
        ]);

        User::create([
            'name' => 'Freebird', 
            'email' => 'freebird@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('123456'),
            'date_of_birth' => now()->subYears(20),
        ]);

        User::create([
            'name' => 'Kiddo', 
            'email' => 'kiddo@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('123456'),
            'date_of_birth' => now()->subYears(5)
        ]);

        User::create([
            'name' => '11', 
            'email' => '11@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('123456'),
            'date_of_birth' => now()->subYears(11)
        ]);
    }
}
