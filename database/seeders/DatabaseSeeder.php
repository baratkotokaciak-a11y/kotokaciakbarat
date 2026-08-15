<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create a default admin user
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => 'password', // will be hashed automatically
            'role' => 'admin',
        ]);

        // Create a news editor user
        User::factory()->create([
            'name' => 'News Editor',
            'email' => 'news@example.com',
            'password' => 'password', // will be hashed automatically
            'role' => 'news_editor',
        ]);

        // Optional: create a regular test user
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}
