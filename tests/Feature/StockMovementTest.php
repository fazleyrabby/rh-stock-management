<?php

use App\Models\Product;
use App\Models\StockMovement;
use App\Models\User;
use Illuminate\Support\Facades\DB;

use function Pest\Laravel\get;
use function Pest\Laravel\post;
use function Pest\Laravel\put;
use function Pest\Laravel\delete;

beforeEach(function () {
    DB::statement('SET FOREIGN_KEY_CHECKS=0;');
    DB::table('products')->truncate();  
    DB::table('stock_movements')->truncate(); 
    DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    
    $this->product = Product::factory(40)->create();
    $this->stockMovement = StockMovement::factory()->create();
    $this->user = User::find(1);
});

test('it can display the stock movements index', function () {
    $this->actingAs($this->user);
    $this->assertDatabaseHas('stock_movements', [
        'id' => $this->stockMovement->id,
    ]);
    $response = get('admin/stocks/movement');
    $response->assertViewIs('admin.stocks.movements.index');
    $response->assertViewHas('stockMovements', function ($stockMovements) {
        return $stockMovements->contains('id', $this->stockMovement->id);
    });
    $response->assertSee($this->stockMovement->product->title);
});

test('it can create a stock movement', function () {
    $this->actingAs($this->user);

    $response = post('admin/stocks/movement', [
        'product_id' => 1,
        'user_id' => $this->user->id,
        'type' => 'in',
        'quantity' => 20,
    ]);

    $response->assertRedirect('/admin/stocks/movement');

    $this->assertDatabaseHas('stock_movements', [
        'product_id' => 1,
        'type' => 'in',
        'quantity' => 20,
    ]);
});


test('it can update a stock movement', function () {
    $this->actingAs($this->user); // Act as the created user

    $response = put('admin/stocks/movement/' . $this->stockMovement->id, [
        'product_id' => 2,
        'user_id' => $this->user->id,
        'type' => 'in',
        'quantity' => 22,
    ]);

    $response->assertRedirect('/admin/stocks/movement/'); // Assuming a successful update returns a 200 status

    $this->assertDatabaseHas('stock_movements', [
        'product_id' => 2,
        'quantity' => 22,
    ]);
});


test('it can delete a stock movement', function () {
    $this->actingAs($this->user); // Act as the created user

    $this->assertDatabaseHas('stock_movements', [
        'id' => $this->stockMovement->id,
    ]);

    $response = delete('admin/stocks/movement/' . $this->stockMovement->id);
    $response->assertRedirect('/admin/stocks/movement/');
    $this->assertDatabaseMissing('stock_movements', [
        'id' => $this->stockMovement->id,
    ]);
});