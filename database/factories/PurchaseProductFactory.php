<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Purchase;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PurchaseProduct>
 */
class PurchaseProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'purchase_id' => Purchase::factory(), // Assumes PurchaseFactory is defined
            'product_id' => Product::factory(),  // Assumes you have a ProductFactory
            'quantity' => $this->faker->numberBetween(1, 20),
            'price' => $this->faker->randomFloat(2, 5, 100), // Cost between 10 and 500
        ];
    }
}
