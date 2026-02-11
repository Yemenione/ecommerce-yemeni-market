<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Category;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        return [
            'category_id' => Category::factory(),
            'name' => ['en' => $this->faker->word, 'fr' => $this->faker->word, 'ar' => $this->faker->word],
            'description' => ['en' => $this->faker->sentence, 'fr' => $this->faker->sentence],
            'price_eur' => $this->faker->randomFloat(2, 10, 100),
            'sku' => $this->faker->unique()->ean8,
            'stock' => 10,
            'images' => [],
            'is_featured' => $this->faker->boolean,
        ];
    }
}
