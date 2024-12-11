<?php

use App\Models\Product;
use App\Models\Purchase;
use App\Models\Supplier;
use App\Models\PurchaseProduct;
use App\Models\User;
use Illuminate\Support\Facades\DB;

use function Pest\Laravel\get;
use function Pest\Laravel\post;
use function Pest\Laravel\put;
use function Pest\Laravel\delete;

beforeEach(function () {
    DB::statement('SET FOREIGN_KEY_CHECKS=0;');
    DB::table('suppliers')->truncate(); 
    DB::table('purchases')->truncate(); 
    DB::table('products')->truncate(); 
    DB::table('purchase_products')->truncate(); 
    DB::statement('SET FOREIGN_KEY_CHECKS=1;');

    $this->suppliers = Supplier::factory()->count(10)->create();
    $this->user = User::find(1);
    $this->products = Product::factory()->count(40)->create();
});

test('it can display the purchases index', function () {
    $this->actingAs($this->user);
    $purchase = Purchase::factory()->has(PurchaseProduct::factory()->count(5))->create();
    $this->assertDatabaseHas('purchases', [
        'id' => $purchase->id,
    ]);
    $response = get('admin/purchases');
    $response->assertViewIs('admin.purchases.index');
    $response->assertViewHas('purchases', function ($purchases) use ($purchase) {
        return $purchases->contains('id', $purchase->id);
    });
    $response->assertSee($purchase->purchase_number);
    $purchase->delete();
    $purchase->purchaseProducts()->delete();
});

test('it can create a purchase with specified products', function () {
    $this->actingAs($this->user);
    $supplierId = $this->suppliers->first()->id;

    $purchaseProducts = [
        [
            'product_id' => $this->products->random()->id,
            'quantity' => 2,
            'price' => 20.00,
        ],
        [
            'product_id' => $this->products->random()->id,
            'quantity' => 2,
            'price' => 15.00,
        ],
    ];

    $response = post(route('admin.purchases.store'), [
        'supplier_id' => $supplierId,
        'total_amount' => 35, 
        'products' => $purchaseProducts,
    ]);
    $purchaseNumber = Purchase::first()->purchase_number;
    $response->assertRedirect('/admin/purchases/create');

    // Assert the product was created in the database
    $this->assertDatabaseHas('purchases', [
        'purchase_number' => $purchaseNumber,
        'supplier_id' => $supplierId,
        'total_amount' => 35,
    ]);

    foreach ($purchaseProducts as $product) {
        $this->assertDatabaseHas('purchase_products', [
            'product_id' => $product['product_id'],
            'quantity' => $product['quantity'],
            'price' => $product['price'],
        ]);
    }

    $response = get('/admin/purchases/');

    $response->assertStatus(200)
             ->assertViewHas('purchases', function ($purchases) use ($purchaseNumber) {
                 return $purchases->contains('purchase_number', $purchaseNumber);
             });
});


test('it can update a purchase with specified products', function () {
    $this->actingAs($this->user);
    $supplierId = $this->suppliers->first()->id;
    $purchase = Purchase::factory()->has(PurchaseProduct::factory()->count(5))->create();
    $purchaseProducts = [
        [
            'product_id' => $this->products->random()->id,
            'quantity' => 2,
            'price' => 20.00,
        ],
        [
            'product_id' => $this->products->random()->id,
            'quantity' => 3,
            'price' => 20.00,
        ],
    ];

    $response = put(route('admin.purchases.update', $purchase->id), [
        'supplier_id' => $supplierId,
        'total_amount' => 40, 
        'products' => $purchaseProducts,
    ]);
    
    $response->assertRedirect('/admin/purchases/');
    $response = get('/admin/purchases/');

    $response->assertStatus(200)
             ->assertViewHas('purchases', function ($purchases) use ($purchase) {
                 return $purchases->contains('purchase_number', $purchase->purchase_number);
             });

    // Assert the product was created in the database
    $this->assertDatabaseHas('purchases', [
        'purchase_number' => $purchase->purchase_number,
        'supplier_id' => $supplierId,
        'total_amount' => 40,
    ]);

    foreach ($purchaseProducts as $product) {
        $this->assertDatabaseHas('purchase_products', [
            'product_id' => $product['product_id'],
            'quantity' => $product['quantity'],
            'price' => $product['price'],
        ]);
    }
});


test('it can delete a purchase', function () {
    $this->actingAs($this->user); // Act as the created user
    $purchase = Purchase::factory()->has(PurchaseProduct::factory()->count(5))->create();
    $this->assertDatabaseHas('purchases', [
        'id' => $purchase->id,
    ]);
    $response = delete(route('admin.purchases.destroy', $purchase->id));
    $response->assertRedirect('/admin/purchases');
    $this->assertDatabaseMissing('purchases', [
        'id' => $purchase->id,
    ]);
});