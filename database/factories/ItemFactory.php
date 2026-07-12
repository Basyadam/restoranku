<?php

namespace Database\Factories;

use App\Models\Item;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Item>
 */
class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'categories_id' => $this->faker->numberBetween(1, 2),
            'price' => $this->faker->randomFloat(2, 1000, 100000),
            'stock' => $this->faker->numberBetween(1, 100),
            'description' => $this->faker->text(),
            'img' => $this->faker->imageUrl(),
            'is_active' => $this->faker->boolean(),
        ];
    }
}
