<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            ProductSeeder::class,
            CustomerSeeder::class,
            OfferteSeeder::class,
            FactuurSeeder::class,
            ContractSeeder::class,
            CustomerUpdateSeeder::class,
            OfferteProductSeeder::class,
            FactuurProductSeeder::class,
            OrderLogisticsSeeder::class,
            FeedbackSeeder::class,
            PlanningTicketSeeder::class,
            RoleSeeder::class,
        ]);
    }
}
