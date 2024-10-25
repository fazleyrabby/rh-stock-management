<?php

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;

use function Pest\Laravel\delete;
use function Pest\Laravel\get;
use function Pest\Laravel\post;
use function Pest\Laravel\put;

// uses(RefreshDatabase::class);

beforeEach(function () {
    DB::statement('SET FOREIGN_KEY_CHECKS=0;');
    DB::table('products')->truncate();  
    DB::table('categories')->truncate(); 
    DB::statement('SET FOREIGN_KEY_CHECKS=1;');

    $this->categories = Category::factory()->count(10)->create();
    $this->product = Product::factory()->create();
    $this->user = User::find(1);
});

test('it can display the products index', function () {
    $this->actingAs($this->user);
    $this->assertDatabaseHas('products', [
        'id' => $this->product->id,
    ]);
    $response = get('admin/products');
    $response->assertViewIs('admin.products.index');
    $response->assertViewHas('products', function ($products) {
        return $products->contains('id', $this->product->id);
    });
    $response->assertSee($this->product->title);
});

test('it can create a product', function () {
    $this->actingAs($this->user);

    $response = post('admin/products', [
        'title' => 'Test Product',
        'sku' => 'TEST-SKU-001',
        'category_id' => $this->categories->first()->id,
        'price' => "100.00",
        'quantity' => 10,
        'description' => 'test description',
    ]);

    $response->assertRedirect('/admin/products/create');

    $this->assertDatabaseHas('products', [
        'title' => 'Test Product',
        'sku' => 'TEST-SKU-001',
    ]);
});


test('it can update a product', function () {
    $this->actingAs($this->user); // Act as the created user

    $response = put('admin/products/' . $this->product->id, [
        'title' => 'Test Product 001',
        'sku' => 'TEST-SKU-001',
        'category_id' => $this->categories->first()->id,
        'price' => "9.90",
        'quantity' => 5,
        'description' => 'test description 2',
    ]);

    $response->assertRedirect('/admin/products'); // Assuming a successful update returns a 200 status

    // Assert that the product was updated in the database
    $this->assertDatabaseHas('products', [
        'title' => 'Test Product 001',
        'sku' => 'TEST-SKU-001',
        'price' => "9.90",
        'quantity' => 5,
        'description' => 'test description 2',
    ]);
});


test('it can delete a product', function () {
    $this->actingAs($this->user); // Act as the created user

    $this->assertDatabaseHas('products', [
        'id' => $this->product->id,
    ]);

    $response = delete('admin/products/' . $this->product->id);
    $response->assertRedirect('/admin/products');
    $this->assertDatabaseMissing('products', [
        'id' => $this->product->id,
    ]);
});