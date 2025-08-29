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
        Schema::create('invoice_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invoice_id')->constrained()->onDelete('cascade');
            $table->string('description')->comment('Item description');
            $table->integer('quantity')->default(1)->comment('Quantity');
            $table->decimal('unit_price', 10, 2)->comment('Unit price');
            $table->decimal('total_price', 10, 2)->comment('Total price');
            $table->decimal('tax_rate', 5, 2)->default(0)->comment('Tax rate percentage');
            $table->timestamps();

            $table->index('invoice_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_items');
    }
};