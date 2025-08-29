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
            $table->foreignId('invoice_id')->constrained()->onDelete('cascade');
            $table->foreignId('customer_id')->constrained()->onDelete('cascade');
            $table->decimal('amount', 10, 2)->comment('Payment amount');
            $table->enum('payment_method', ['credit_card', 'bank_transfer', 'paypal', 'mobile_money', 'cash'])->comment('Payment method');
            $table->string('transaction_id')->nullable()->comment('Transaction ID from payment processor');
            $table->date('payment_date')->comment('Payment date');
            $table->enum('status', ['pending', 'completed', 'failed', 'refunded'])->default('pending')->comment('Payment status');
            $table->text('notes')->nullable()->comment('Payment notes');
            $table->timestamps();

            $table->index(['customer_id', 'status']);
            $table->index('payment_date');
            $table->index('invoice_id');
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