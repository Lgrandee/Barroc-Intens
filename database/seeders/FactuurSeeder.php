<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Factuur;
use Illuminate\Database\Seeder;

class FactuurSeeder extends Seeder
{
    /**
     * Run the database seeds with realistic invoice distribution.
     */
    public function run(): void
    {
        $customers = Customer::all();
        
        foreach ($customers as $customer) {
            // Different customer types get different invoice volumes
            $companyName = strtolower($customer->name_company);
            
            // Large corporations (banks, hospitals, universities) - high volume
            if (str_contains($companyName, 'bank') || 
                str_contains($companyName, 'philips') || 
                str_contains($companyName, 'asml') ||
                str_contains($companyName, 'umc') ||
                str_contains($companyName, 'mc') ||
                str_contains($companyName, 'universiteit') ||
                str_contains($companyName, 'tu ')) {
                $invoiceCount = rand(15, 30);
            }
            // Medium businesses (hotels, co-working, large cafes) - medium volume
            elseif (str_contains($companyName, 'hotel') || 
                    str_contains($companyName, 'fletcher') ||
                    str_contains($companyName, 'valk') ||
                    str_contains($companyName, 'wework') ||
                    str_contains($companyName, 'spaces') ||
                    str_contains($companyName, 'bagels') ||
                    str_contains($companyName, 'kpmg') ||
                    str_contains($companyName, 'deloitte')) {
                $invoiceCount = rand(10, 20);
            }
            // Small businesses (cafés, bakeries, lunchrooms) - lower volume
            else {
                $invoiceCount = rand(3, 10);
            }
            
            // Create invoices for this customer
            Factuur::factory()->count($invoiceCount)->create([
                'name_company_id' => $customer->id
            ]);
        }
    }
}
