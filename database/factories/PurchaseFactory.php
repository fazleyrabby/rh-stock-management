<?php

namespace Database\Factories;

use App\Models\PurchaseProduct;
use App\Models\Supplier;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Purchase>
 */
class PurchaseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'purchase_number' => $this->faker->unique()->uuid,
            'supplier_id' => Supplier::factory(),
            'total_amount' => $this->faker->randomFloat(2, 5, 100), 
            'status' => $this->faker->randomElement(['pending', 'received', 'cancelled']),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
