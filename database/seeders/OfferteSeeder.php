<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Offerte;
use App\Models\Product;
use Illuminate\Database\Seeder;

class OfferteSeeder extends Seeder
{
    /**
     * Run the database seeds with realistic quote distribution.
     */
    public function run(): void
    {
        $customers = Customer::all();
        $products = Product::all();

        foreach ($customers as $customer) {
            $companyName = strtolower($customer->name_company);

            // Large corporations get more quotes (trying different machines/services)
            if (str_contains($companyName, 'bank') ||
                str_contains($companyName, 'philips') ||
                str_contains($companyName, 'asml') ||
                str_contains($companyName, 'hotel') ||
                str_contains($companyName, 'umc')) {
                $quoteCount = rand(3, 6);
            }
            // Medium businesses
            elseif (str_contains($companyName, 'kpmg') ||
                    str_contains($companyName, 'deloitte') ||
                    str_contains($companyName, 'wework') ||
                    str_contains($companyName, 'universiteit')) {
                $quoteCount = rand(2, 4);
            }
            // Small businesses
            else {
                $quoteCount = rand(1, 2);
            }

            for ($i = 0; $i < $quoteCount; $i++) {
                $offerte = Offerte::factory()->create([
                    'name_company_id' => $customer->id
                ]);

                // Koppel 1-3 random producten met quantities
                $randomProducts = $products->random(rand(1, 3));
                foreach ($randomProducts as $product) {
                    $offerte->products()->attach($product->id, [
                        'quantity' => rand(1, 5),
                        'status' => 'ordered'
                    ]);
                }
            }
        }
    }
}
