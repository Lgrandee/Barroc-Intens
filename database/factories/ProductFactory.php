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
        $machines = [
            'Barroc Espresso Deluxe Pro',
            'Barroc Café Master 3000',
            'Barroc Bean-to-Cup Premium',
            'Barroc Automatic Espresso Maker',
            'Barroc Cappuccino Express',
            'Barroc Professional Barista Edition',
            'Barroc Home Espresso System',
        ];

        $beans = [
            'Barroc Arabica Beans - Dark Roast',
            'Barroc Robusta Blend - Medium',
            'Barroc Ethiopian Single Origin',
            'Barroc Colombian Supreme',
            'Barroc Espresso Blend Premium',
            'Barroc Brazil Santos',
            'Barroc Italian Roast',
        ];

        $parts = [
            'Barroc Portafilter Handle',
            'Barroc Steam Wand Replacement',
            'Barroc Brew Group Assembly',
            'Barroc Water Tank',
            'Barroc Drip Tray',
            'Barroc Milk Frother Attachment',
            'Barroc Grinder Burr Set',
        ];

        $types = ['beans', 'parts', 'machines'];
        $type = $this->faker->randomElement($types);

        $productName = match($type) {
            'machines' => $this->faker->randomElement($machines),
            'beans' => $this->faker->randomElement($beans),
            'parts' => $this->faker->randomElement($parts),
        };

        return [
            'product_name' => $productName,
            'stock' => $this->faker->numberBetween(0, 30),
            'price' => match($type) {
                'machines' => $this->faker->randomFloat(2, 299, 1999),
                'beans' => $this->faker->randomFloat(2, 4, 55),
                'parts' => $this->faker->randomFloat(2, 15, 220),
            },
            'type' => $type,
        ];
    }
}
