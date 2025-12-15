<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
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
        $names = [
            'Kenji SX Premium',
            'Kenji MK-II',
            'Kenji-X1000',
            'KKKenji Deluxe',
            'Xtreme Kenji Pro',
        ];
        $types = [
            'beans',
            'parts',
            'machines',
        ];

        return [
            'product_name' => $this->faker->randomElement($names),
            'stock' => $this->faker->numberBetween(1, 100),
            'price' => $this->faker->randomFloat(2, 10, 1000),
            'type' => $this->faker->randomElement($types),
        ];
    }
}
