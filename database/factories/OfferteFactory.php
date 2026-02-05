<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\Product;
use App\Models\Offerte;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Offerte>
 */
class OfferteFactory extends Factory
{
    /**
     * Define the model's default state with realistic quote data.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Weight status towards accepted (business success rate ~40-60% for B2B)
        $statuses = array_merge(
            array_fill(0, 45, 'accepted'),  // 45% accepted
            array_fill(0, 30, 'pending'),   // 30% pending
            array_fill(0, 25, 'rejected')   // 25% rejected
        );

        // 70% recente offertes (0-60 dagen), 30% oudere offertes (-3 years tot -60 dagen)
        if ($this->faker->boolean(70)) {
            $offerteDate = $this->faker->dateTimeBetween('-60 days', 'now');
        } else {
            $offerteDate = $this->faker->dateTimeBetween('-3 years', '-60 days');
        }

        $validUntil = $this->faker->dateTimeBetween($offerteDate, '+60 days');

        return [
            'name_company_id' => Customer::inRandomOrder()->first()?->id,
            'product_id' => Product::inRandomOrder()->first()?->id,
            'status' => $this->faker->randomElement($statuses),
            'valid_until' => $validUntil,
            'delivery_time_weeks' => $this->faker->randomElement([2, 4, 8]),
            'payment_terms_days' => $this->faker->randomElement([14, 30, 60]),
            'custom_terms' => $this->faker->optional(0.3)->sentence(20),
            'created_at' => $offerteDate,
            'updated_at' => $offerteDate,
        ];
    }

    /**
     * Configure the model factory.
     */
    public function configure()
    {
        return $this->afterCreating(function (Offerte $offerte) {
            // Zorg ervoor dat elke offerte minstens 1 product heeft
            if ($offerte->products()->count() === 0) {
                $products = Product::inRandomOrder()->limit(rand(1, 3))->get();
                foreach ($products as $product) {
                    $offerte->products()->attach($product->id, [
                        'quantity' => rand(1, 5),
                        'status' => 'ordered'
                    ]);
                }
            }
        });
    }
}
