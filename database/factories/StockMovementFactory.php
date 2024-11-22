<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\StockMovement>
 */
class StockMovementFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'product_id' => Product::inRandomOrder()->first()->id,
            'user_id' => 1,
            'quantity' => $this->faker->randomDigitNotNull(), 
            'type' => $this->faker->randomElement(['in', 'out', 'damage']),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
