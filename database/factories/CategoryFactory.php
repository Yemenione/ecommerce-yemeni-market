<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => ['en' => $this->faker->word, 'fr' => $this->faker->word, 'ar' => $this->faker->word],
            'slug' => $this->faker->slug,
            'image' => null,
        ];
    }
}
