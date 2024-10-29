<?php

use App\Models\Supplier;
use App\Models\User;
use Illuminate\Support\Facades\DB;

use function Pest\Laravel\delete;
use function Pest\Laravel\get;
use function Pest\Laravel\post;
use function Pest\Laravel\put;

beforeEach(function () {
    DB::statement('SET FOREIGN_KEY_CHECKS=0;');
    DB::table('products')->truncate();  
    DB::table('suppliers')->truncate(); 
    DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    
    $this->supplier = Supplier::factory()->create();
    $this->user = User::find(1);
});

test('it can display the suppliers index', function () {
    $this->actingAs($this->user);
    $this->assertDatabaseHas('suppliers', [
        'id' => $this->supplier->id,
    ]);
    $response = get('admin/suppliers');
    $response->assertViewIs('admin.suppliers.index');
    $response->assertViewHas('suppliers', function ($suppliers) {
        return $suppliers->contains('id', $this->supplier->id);
    });
    $response->assertSee($this->supplier->name);
});

test('it can create a supplier', function () {
    $this->actingAs($this->user);

    $response = post('admin/suppliers', [
        'name' => 'Test supplier',
        'phone' => '019287362346',
        'email' => 'email@test.com',
        'address' => 'Test address',
    ]);

    $response->assertRedirect('/admin/suppliers/create');

    $this->assertDatabaseHas('suppliers', [
        'name' => 'Test supplier',
    ]);
});


test('it can update a supplier', function () {
    $this->actingAs($this->user); // Act as the created user

    $response = put('admin/suppliers/' . $this->supplier->id, [
        'name' => 'Test supplier 22',
        'phone' => '0192873623462',
        'email' => 'email@test.com',
        'address' => 'Test address',
    ]);

    $response->assertRedirect('/admin/suppliers'); // Assuming a successful update returns a 200 status

    // Assert that the supplier was updated in the database
    $this->assertDatabaseHas('suppliers', [
        'name' => 'Test supplier 22',
        'phone' => '0192873623462',
    ]);
});


test('it can delete a supplier', function () {
    $this->actingAs($this->user); // Act as the created user

    $this->assertDatabaseHas('suppliers', [
        'id' => $this->supplier->id,
    ]);

    $response = delete('admin/suppliers/' . $this->supplier->id);
    $response->assertRedirect('/admin/suppliers');
    $this->assertDatabaseMissing('suppliers', [
        'id' => $this->supplier->id,
    ]);
});