<?php

use App\Models\Category;
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
    
    $this->category = Category::factory()->create();
    $this->user = User::find(1);
});

test('it can display the categories index', function () {
    $this->actingAs($this->user);
    $this->assertDatabaseHas('categories', [
        'id' => $this->category->id,
    ]);
    $response = get('admin/categories');
    $response->assertViewIs('admin.categories.index');
    $response->assertViewHas('categories', function ($categories) {
        return $categories->contains('id', $this->category->id);
    });
    $response->assertSee($this->category->title);
});

test('it can create a category', function () {
    $this->actingAs($this->user);

    $response = post('admin/categories', [
        'title' => 'Test category 2',
    ]);

    $response->assertRedirect('/admin/categories/create');

    $this->assertDatabaseHas('categories', [
        'title' => 'Test category 2',
    ]);
});


test('it can update a category', function () {
    $this->actingAs($this->user); // Act as the created user

    $response = put('admin/categories/' . $this->category->id, [
        'title' => 'Test category 002',
    ]);

    $response->assertRedirect('/admin/categories'); // Assuming a successful update returns a 200 status

    // Assert that the category was updated in the database
    $this->assertDatabaseHas('categories', [
        'title' => 'Test category 002',
    ]);
});


test('it can delete a category', function () {
    $this->actingAs($this->user); // Act as the created user

    $this->assertDatabaseHas('categories', [
        'id' => $this->category->id,
    ]);

    $response = delete('admin/categories/' . $this->category->id);
    $response->assertRedirect('/admin/categories');
    $this->assertDatabaseMissing('categories', [
        'id' => $this->category->id,
    ]);
});