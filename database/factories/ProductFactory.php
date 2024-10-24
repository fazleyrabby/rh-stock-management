<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        return [
            'title' => $this->faker->word(),  // Random word for product name
            'description' => $this->faker->sentence(),  // Random sentence for description
            'sku' => $this->faker->word() . '_' . uniqid() . '_' . time(),  // Random sentence for description
            'category_id' => $this->faker->numberBetween(1, 3),  // Random sentence for description
            'price' => $this->faker->randomFloat(2, 10, 200),  // Random price between 10 and 500
            'quantity' => $this->faker->numberBetween(1, 20),  // Random quantity between 1 and 100
        ];
    }
}
