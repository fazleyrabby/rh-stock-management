<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('sku')->unique();
            $table->text('description')->nullable();
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade'); // Foreign key to categories
            // $table->foreignId('supplier_id')->nullable()->constrained('suppliers')->onDelete('set null'); // Foreign key to suppliers
            $table->decimal('price', 10, 2);
            $table->integer('quantity');
            // $table->integer('min_stock_level')->default(0); // Minimum stock level before alert
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
