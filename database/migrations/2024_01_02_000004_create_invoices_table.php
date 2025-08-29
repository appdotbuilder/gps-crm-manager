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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number')->unique()->comment('Invoice number');
            $table->foreignId('customer_id')->constrained()->onDelete('cascade');
            $table->date('invoice_date')->comment('Invoice date');
            $table->date('due_date')->comment('Payment due date');
            $table->decimal('subtotal', 10, 2)->default(0)->comment('Subtotal amount');
            $table->decimal('tax_amount', 10, 2)->default(0)->comment('Tax amount');
            $table->decimal('discount_amount', 10, 2)->default(0)->comment('Discount amount');
            $table->decimal('total_amount', 10, 2)->default(0)->comment('Total amount');
            $table->enum('status', ['draft', 'sent', 'paid', 'overdue', 'cancelled'])->default('draft')->comment('Invoice status');
            $table->enum('payment_terms', ['net_15', 'net_30', 'due_on_receipt'])->default('net_30')->comment('Payment terms');
            $table->text('notes')->nullable()->comment('Invoice notes');
            $table->boolean('is_recurring')->default(false)->comment('Is recurring invoice');
            $table->enum('recurring_frequency', ['monthly', 'quarterly', 'yearly'])->nullable()->comment('Recurring frequency');
            $table->date('recurring_start_date')->nullable()->comment('Recurring start date');
            $table->date('recurring_end_date')->nullable()->comment('Recurring end date');
            $table->timestamps();

            $table->index(['customer_id', 'status']);
            $table->index('due_date');
            $table->index(['status', 'due_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};