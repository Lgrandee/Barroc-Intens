<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\Product;
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

        $offerteDate = $this->faker->dateTimeBetween('-3 years', 'now');
        
        return [
            'name_company_id' => Customer::inRandomOrder()->first()?->id,
            'product_id' => Product::inRandomOrder()->first()?->id,
            'status' => $this->faker->randomElement($statuses),
            'created_at' => $offerteDate,
            'updated_at' => $offerteDate,
        ];
    }
}
