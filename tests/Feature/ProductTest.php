<?php

use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use App\Traits\UploadPhotos;
use function Pest\Laravel\get;
use function Pest\Laravel\put;

use function Pest\Laravel\post;
use function Pest\Laravel\delete;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Intervention\Image\Encoders\AutoEncoder;
use Intervention\Image\Encoders\PngEncoder;

// uses(RefreshDatabase::class);
uses(UploadPhotos::class);

beforeEach(function () {
    DB::statement('SET FOREIGN_KEY_CHECKS=0;');
    DB::table('products')->truncate();  
    DB::table('categories')->truncate(); 
    DB::table('suppliers')->truncate(); 
    DB::statement('SET FOREIGN_KEY_CHECKS=1;');

    $this->categories = Category::factory()->count(10)->create();
    $this->suppliers = Supplier::factory()->count(10)->create();
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

test('it can create a product with an image upload', function () {
    $this->actingAs($this->user);

    $fakeImage = UploadedFile::fake()->image('test_product.png', 640, 480); // Create a fake image file

    $response = post('admin/products', [
        'title' => 'Test Product',
        'sku' => 'TEST-SKU-001',
        'category_id' => $this->categories->first()->id,
        'supplier_id' => $this->suppliers->first()->id,
        'price' => "100.00",
        'quantity' => 10,
        'description' => 'test description',
        'image' => $fakeImage, // Attach the fake image here
    ]);

    $response->assertRedirect('/admin/products/create');

    // Assert the product was created in the database
    $this->assertDatabaseHas('products', [
        'title' => 'Test Product',
        'sku' => 'TEST-SKU-001',
    ]);

    $product = Product::where('sku', 'TEST-SKU-001')->first();

    // Assert the image was stored in the correct disk location
    Storage::disk('public')->assertExists($product->image);

    // Cleanup: Delete the image after assertion
    if ($product->image && Storage::disk('public')->exists($product->image)) {
        Storage::disk('public')->delete($product->image);
    }
});


test('it can update a product', function () {
    $this->actingAs($this->user); // Act as the created user

    $fakeImage = UploadedFile::fake()->image('test_product_update.png', 640, 480);

    $response = put('admin/products/' . $this->product->id, [
        'title' => 'Test Product 001',
        'sku' => 'TEST-SKU-001',
        'category_id' => $this->categories->first()->id,
        'supplier_id' => $this->suppliers->first()->id,
        'price' => "9.90",
        'quantity' => 5,
        'description' => 'test description 2',
        'image' => $fakeImage,
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

    $product = Product::where('title', 'Test Product 001')->first();
    Storage::disk('public')->assertExists($product->image);

    // Cleanup: Delete the image after assertion
    if ($product->image && Storage::disk('public')->exists($product->image)) {
        Storage::disk('public')->delete($product->image);
    }
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