<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // $timeStamp = ['created_at' => now(), 'updated_at' => now()];
        // Category::insert([
        //     ['title' => 'Electronics', ...$timeStamp],
        //     ['title' => 'Furniture', ...$timeStamp],
        //     ['title' => 'Clothing', ...$timeStamp],
        //     ['title' => 'Groceries', ...$timeStamp],
        //     ['title' => 'Books', ...$timeStamp],
        // ]);

        $this->call([
            CategorySeeder::class,
            SupplierSeeder::class,
            ProductSeeder::class,
            CustomerSeeder::class,
        ]);

        User::create([
            'name' => 'Test user',
            'password' => bcrypt('123456'),
            'email' => 'test@gmail.com',
            'role' => 'admin'
        ]);
    }
}
