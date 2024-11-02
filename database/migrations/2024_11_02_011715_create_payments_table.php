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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaction_id'); // Foreign key to (sales/purchases)
            $table->enum('transaction_type', ['sale', 'purchase']);
            $table->string('invoice_number')->unique();
            $table->decimal('amount_paid', 10, 2);
            $table->decimal('due_amount', 10, 2);
            $table->date('payment_date');
            $table->enum('payment_method', ['cash', 'credit card'])->default('cash');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
