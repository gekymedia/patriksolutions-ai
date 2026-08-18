<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@patriksolutions.com'],
            [
                'name' => 'Patrik Admin',
                'password' => Hash::make('change-me-in-production'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        $this->call(CourseSeeder::class);
    }
}
