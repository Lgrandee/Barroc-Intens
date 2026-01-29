<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Factuur;
use App\Models\Product;

class FactuurProductSeeder extends Seeder
{
    /**
     * Attach realistic products to invoices.
     */
    public function run(): void
    {
        $facturen = Factuur::all();
        $products = Product::all();
        
        // Group products by type for realistic combinations
        $machines = $products->where('type', 'machines');
        $beans = $products->where('type', 'beans');
        $parts = $products->where('type', 'parts');

        foreach ($facturen as $factuur) {
            // Determine invoice type based on reference or random
            $ref = strtolower($factuur->reference ?? '');
            
            if (str_contains($ref, 'mo-') || str_contains($ref, 'maint-')) {
                // Machine Order - 1 machine, maybe some parts
                $machine = $machines->random();
                $factuur->products()->attach($machine->id, ['quantity' => 1]);
                
                // 50% chance to add installation parts
                if (rand(1, 100) <= 50) {
                    $part = $parts->random();
                    $factuur->products()->attach($part->id, ['quantity' => rand(1, 2)]);
                }
            }
            elseif (str_contains($ref, 'bo-')) {
                // Beans Order - multiple bean types
                $numProducts = rand(1, 3);
                $selectedBeans = $beans->random(min($numProducts, $beans->count()));
                
                foreach ($selectedBeans as $bean) {
                    // Larger quantities for businesses (5-50kg)
                    $factuur->products()->attach($bean->id, ['quantity' => rand(5, 50)]);
                }
            }
            elseif (str_contains($ref, 'svc-')) {
                // Service - parts and maybe some beans as bonus
                $numParts = rand(1, 3);
                $selectedParts = $parts->random(min($numParts, $parts->count()));
                
                foreach ($selectedParts as $part) {
                    $factuur->products()->attach($part->id, ['quantity' => rand(1, 3)]);
                }
                
                // 30% chance to include some beans
                if (rand(1, 100) <= 30) {
                    $bean = $beans->random();
                    $factuur->products()->attach($bean->id, ['quantity' => rand(2, 10)]);
                }
            }
            else {
                // Mixed order - random combination
                $orderType = rand(1, 100);
                
                if ($orderType <= 20) {
                    // 20% - Machine purchase (high value)
                    $machine = $machines->random();
                    $factuur->products()->attach($machine->id, ['quantity' => 1]);
                    
                    // Often includes installation accessories
                    if (rand(1, 100) <= 70) {
                        $part = $parts->random();
                        $factuur->products()->attach($part->id, ['quantity' => rand(1, 2)]);
                    }
                }
                elseif ($orderType <= 70) {
                    // 50% - Regular beans order (most common)
                    $numBeans = rand(1, 3);
                    $selectedBeans = $beans->random(min($numBeans, $beans->count()));
                    
                    foreach ($selectedBeans as $bean) {
                        $factuur->products()->attach($bean->id, ['quantity' => rand(3, 25)]);
                    }
                }
                else {
                    // 30% - Parts/maintenance order
                    $numParts = rand(1, 4);
                    $selectedParts = $parts->random(min($numParts, $parts->count()));
                    
                    foreach ($selectedParts as $part) {
                        $factuur->products()->attach($part->id, ['quantity' => rand(1, 5)]);
                    }
                }
            }
        }
    }
}
