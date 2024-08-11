<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(4)->create(
            ['is_admin' => false]
        );

        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'test@example.com',
            'is_admin' => true,
            'password' => Hash::make('12345678'),
        ]);

        $this->call([
            ProductSeeder::class,
            ProductReviewSeeder::class,
        ]);
    }
}
