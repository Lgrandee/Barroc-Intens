<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds with realistic coffee company products.
     */
    public function run(): void
    {
        // Coffee Machines (Premium espresso machines for businesses)
        $machines = [
            ['product_name' => 'Barroc Espresso Pro X1', 'stock' => 12, 'price' => 2499.00, 'type' => 'machines'],
            ['product_name' => 'Barroc Café Master 3000', 'stock' => 8, 'price' => 1899.00, 'type' => 'machines'],
            ['product_name' => 'Barroc Bean-to-Cup Elite', 'stock' => 15, 'price' => 3299.00, 'type' => 'machines'],
            ['product_name' => 'Barroc Professional Barista XL', 'stock' => 5, 'price' => 4599.00, 'type' => 'machines'],
            ['product_name' => 'Barroc Compact Office 500', 'stock' => 25, 'price' => 899.00, 'type' => 'machines'],
            ['product_name' => 'Barroc Super Automatic Dual', 'stock' => 10, 'price' => 2199.00, 'type' => 'machines'],
            ['product_name' => 'Barroc Home Espresso Classic', 'stock' => 30, 'price' => 599.00, 'type' => 'machines'],
            ['product_name' => 'Barroc Industrial Brew System', 'stock' => 3, 'price' => 7999.00, 'type' => 'machines'],
        ];

        // Coffee Beans (Various blends and origins)
        $beans = [
            ['product_name' => 'Barroc Arabica - Colombian Supreme (1kg)', 'stock' => 150, 'price' => 24.95, 'type' => 'beans'],
            ['product_name' => 'Barroc Arabica - Ethiopian Yirgacheffe (1kg)', 'stock' => 80, 'price' => 29.95, 'type' => 'beans'],
            ['product_name' => 'Barroc Robusta Blend - Extra Strong (1kg)', 'stock' => 200, 'price' => 18.95, 'type' => 'beans'],
            ['product_name' => 'Barroc Espresso Blend - Dark Roast (1kg)', 'stock' => 175, 'price' => 22.95, 'type' => 'beans'],
            ['product_name' => 'Barroc Italian Roast Premium (1kg)', 'stock' => 120, 'price' => 26.95, 'type' => 'beans'],
            ['product_name' => 'Barroc Brazil Santos - Medium (1kg)', 'stock' => 140, 'price' => 21.95, 'type' => 'beans'],
            ['product_name' => 'Barroc Decaf Arabica Blend (1kg)', 'stock' => 60, 'price' => 27.95, 'type' => 'beans'],
            ['product_name' => 'Barroc Organic Fair Trade (1kg)', 'stock' => 90, 'price' => 32.95, 'type' => 'beans'],
            ['product_name' => 'Barroc House Blend - Office Pack (5kg)', 'stock' => 50, 'price' => 89.95, 'type' => 'beans'],
            ['product_name' => 'Barroc Specialty Single Origin Box (4x250g)', 'stock' => 40, 'price' => 49.95, 'type' => 'beans'],
        ];

        // Spare Parts and Accessories
        $parts = [
            ['product_name' => 'Portafilter Handle - Stainless Steel', 'stock' => 45, 'price' => 49.00, 'type' => 'parts'],
            ['product_name' => 'Steam Wand Replacement Kit', 'stock' => 30, 'price' => 75.00, 'type' => 'parts'],
            ['product_name' => 'Brew Group Assembly - Universal', 'stock' => 15, 'price' => 189.00, 'type' => 'parts'],
            ['product_name' => 'Water Tank 2.5L - Clear', 'stock' => 50, 'price' => 35.00, 'type' => 'parts'],
            ['product_name' => 'Drip Tray with Indicator', 'stock' => 60, 'price' => 29.00, 'type' => 'parts'],
            ['product_name' => 'Milk Frother Pro Attachment', 'stock' => 35, 'price' => 95.00, 'type' => 'parts'],
            ['product_name' => 'Ceramic Grinder Burr Set', 'stock' => 25, 'price' => 125.00, 'type' => 'parts'],
            ['product_name' => 'Descaling Solution (6-pack)', 'stock' => 200, 'price' => 24.95, 'type' => 'parts'],
            ['product_name' => 'Water Filter Cartridge (3-pack)', 'stock' => 150, 'price' => 34.95, 'type' => 'parts'],
            ['product_name' => 'Cleaning Tablets (100 stuks)', 'stock' => 180, 'price' => 19.95, 'type' => 'parts'],
            ['product_name' => 'Group Head Gasket Set', 'stock' => 40, 'price' => 15.00, 'type' => 'parts'],
            ['product_name' => 'Display Controller Board', 'stock' => 10, 'price' => 245.00, 'type' => 'parts'],
        ];

        // Insert all products
        foreach (array_merge($machines, $beans, $parts) as $product) {
            Product::create($product);
        }
    }
}
