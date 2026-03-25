<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->words(3, true),
            'category' => $this->faker->randomElement(['Electronics', 'Fashion', 'Home', 'Beauty','Kids','Womens','Mens']),
            'description' => $this->faker->paragraph(),
            'image' => $this->faker->imageUrl(640, 480, 'products', true),
            'price' => $this->faker->randomFloat(2, 10, 1000), // Min 10, Max 1000
            'rating_rate' => $this->faker->randomFloat(1, 0, 5),
            'rating_count' => $this->faker->numberBetween(1, 500),
        ];
    }
}
