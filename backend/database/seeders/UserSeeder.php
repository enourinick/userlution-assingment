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
            'name' => 'Mohammad', 
            'email' => 'user@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('123456'),
            'date_of_birth' => '1991/07/28'
        ]);
    }
}
