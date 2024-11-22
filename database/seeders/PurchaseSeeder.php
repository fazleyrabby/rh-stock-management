<?php

namespace Database\Seeders;

use App\Models\Purchase;
use App\Models\PurchaseProduct;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PurchaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Purchase::factory()->has(
            PurchaseProduct::factory()->count(fake()->numberBetween(1, 5))
        )->count(5)->create();
    }
}
