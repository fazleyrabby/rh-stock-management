<?php

use App\Models\Product;
use App\Models\Purchase;
use App\Models\Supplier;
use App\Models\PurchaseProduct;
use App\Models\User;
use Illuminate\Support\Facades\DB;

use function Pest\Laravel\post;

// beforeEach(function () {
//     DB::statement('SET FOREIGN_KEY_CHECKS=0;');
//     DB::table('products')->truncate();  
//     DB::table('suppliers')->truncate(); 
//     DB::table('purchases')->truncate(); 
//     DB::table('purchase_product')->truncate(); 
//     DB::statement('SET FOREIGN_KEY_CHECKS=1;');

//     $this->categories = Purchase::factory()->has(PurchaseProduct::factory()->count(5))->count(10)->create();
//     $this->suppliers = Supplier::factory()->count(10)->create();
//     $this->product = Product::factory()->create();
//     $this->user = User::find(1);
// });

// test('it can create a purchase with specified products', function () {
//     $this->actingAs($this->user);

//     $purchaseNumber = fake()->unique()->uuid;
//     $supplierId = $this->suppliers->first()->id;

//     $purchaseProducts = [
//         [
//             'product_id' => $this->products->random()->id,
//             'quantity' => 3,
//             'price' => 20.00,
//         ],
//         [
//             'product_id' => $this->products->random()->id,
//             'quantity' => 2,
//             'price' => 15.00,
//         ],
//     ];

//     $response = post('admin/purchases/', [
//         'purchase_number' => $purchaseNumber,
//         'supplier_id' => $supplierId,
//         'total_amount' => 55, 
//         'status' => 'pending',
//         'products' => $purchaseProducts,
//     ]);
    

//     $response->assertRedirect('/admin/purchases');

//     // Assert the product was created in the database
//     $this->assertDatabaseHas('purchases', [
//         'purchase_number' => $purchaseNumber,
//         'total_amount' => 55,
//     ]);

//     foreach ($purchaseProducts as $product) {
//         $this->assertDatabaseHas('purchase_products', [
//             'product_id' => $product['product_id'],
//             'quantity' => $product['quantity'],
//             'cost_price' => $product['price'],
//         ]);
//     }
// });
