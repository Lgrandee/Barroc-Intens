<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Factuur;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FactuurSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create many invoices spanning the years for a rich dataset
        Customer::all()->each(function ($customer) {
            // Create 5-15 invoices per customer across different years
            $count = rand(5, 15);
            Factuur::factory()->count($count)->create([
                'name_company_id' => $customer->id
            ]);
        });
    }
}
