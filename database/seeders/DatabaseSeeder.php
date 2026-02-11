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
        // Create a test user
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'), // simple password
        ]);

        // Create categories
        $categories = \App\Models\Category::factory(5)->create();

        // Create products for each category
        foreach ($categories as $category) {
            \App\Models\Product::factory(4)->create([
                'category_id' => $category->id,
            ]);
        }
    }
}
