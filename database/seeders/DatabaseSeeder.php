<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'email' => "test1@test.com",
            'password' => Hash::make('password')
        ]);
        User::create([
            'email' => "test2@test.com",
            'password' => Hash::make('password')
        ]);
        User::create([
            'email' => "test3@test.com",
            'password' => Hash::make('password')
        ]);
    }
}
