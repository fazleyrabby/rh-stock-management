<?php

use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;

use function Pest\Laravel\delete;
use function Pest\Laravel\get;
use function Pest\Laravel\post;
use function Pest\Laravel\put;

beforeEach(function () {
    DB::table('customers')->truncate(); 

    $this->customer = Customer::factory()->create();
    $this->user = User::find(1);
});


test('it can display the customers index', function () {
    $this->actingAs($this->user);
    $this->assertDatabaseHas('customers', [
        'id' => $this->customer->id,
    ]);
    $response = get('admin/customers');
    $response->assertViewIs('admin.customers.index');
    $response->assertViewHas('customers', function ($customers) {
        return $customers->contains('id', $this->customer->id);
    });
    $response->assertSee($this->customer->title);
});


test('it can create a customer', function () {
    $this->actingAs($this->user);

    $response = post('admin/customers', [
        'name' => 'Test customer 2',
        'email' => 'test2@email.com',
        'address' => 'test address',
        'phone' => '998283737464',
    ]);

    $response->assertRedirect('/admin/customers/create');

    $this->assertDatabaseHas('customers', [
        'name' => 'Test customer 2',
    ]);
});


test('it can update a customer', function () {
    $this->actingAs($this->user); // Act as the created user

    $response = put('admin/customers/' . $this->customer->id, [
        'name' => 'Test customer 2 updated',
        'email' => 'test2@email.com',
        'address' => 'test updated address',
        'phone' => '998283737464',
    ]);

    $response->assertRedirect('/admin/customers'); // Assuming a successful update returns a 200 status

    // Assert that the customer was updated in the database
    $this->assertDatabaseHas('customers', [
        'name' => 'Test customer 2 updated',
    ]);
});


test('it can delete a customer', function () {
    $this->actingAs($this->user); // Act as the created user

    $this->assertDatabaseHas('customers', [
        'id' => $this->customer->id,
    ]);

    $response = delete('admin/customers/' . $this->customer->id);
    $response->assertRedirect('/admin/customers');
    $this->assertDatabaseMissing('customers', [
        'id' => $this->customer->id,
    ]);
});
