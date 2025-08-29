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
        Schema::create('inventory_items', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('Item name');
            $table->enum('type', ['gps_device', 'sim_card', 'accessory', 'cable'])->comment('Item type');
            $table->string('sku')->unique()->comment('Stock keeping unit');
            $table->string('serial_number')->nullable()->unique()->comment('Serial number');
            $table->integer('stock_level')->default(0)->comment('Current stock level');
            $table->integer('minimum_stock')->default(5)->comment('Minimum stock alert level');
            $table->decimal('purchase_cost', 10, 2)->default(0)->comment('Purchase cost per unit');
            $table->decimal('selling_price', 10, 2)->default(0)->comment('Selling price per unit');
            $table->string('vendor')->nullable()->comment('Vendor/supplier name');
            $table->text('vendor_details')->nullable()->comment('Vendor contact details');
            $table->integer('warranty_months')->nullable()->comment('Warranty period in months');
            $table->string('warehouse_location')->nullable()->comment('Location in warehouse');
            $table->text('description')->nullable()->comment('Item description');
            $table->enum('status', ['active', 'discontinued', 'out_of_stock'])->default('active')->comment('Item status');
            $table->timestamps();

            $table->index(['type', 'status']);
            $table->index('stock_level');
            $table->index(['stock_level', 'minimum_stock']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_items');
    }
};