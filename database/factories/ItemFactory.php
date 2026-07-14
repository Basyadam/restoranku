<?php

namespace Database\Factories;

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
            'stok' => $this->faker->numberBetween(1, 100),
            'description' => $this->faker->text(),
               'img' => fake()->randomElement([
                'https://images.unsplash.com/photo-1591325418441-ff678baf78ef',
                'https://images.unsplash.com/photo-1564489563601-c53cfc451e93',
                'https://images.unsplash.com/photo-1683315446874-e6a629087ef8'
            ]),
            'is_active' => $this->faker->boolean(),
        ];
    }
}
