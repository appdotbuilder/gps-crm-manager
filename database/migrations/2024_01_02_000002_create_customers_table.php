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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('Customer name');
            $table->string('email')->unique()->comment('Customer email');
            $table->string('phone')->nullable()->comment('Customer phone');
            $table->string('company')->nullable()->comment('Company name');
            $table->text('address')->nullable()->comment('Customer address');
            $table->integer('device_count')->default(0)->comment('Number of GPS devices');
            $table->enum('service_plan', ['basic', 'standard', 'premium', 'enterprise'])->default('basic')->comment('Service plan type');
            $table->date('contract_start_date')->nullable()->comment('Contract start date');
            $table->date('contract_end_date')->nullable()->comment('Contract end date');
            $table->text('contract_terms')->nullable()->comment('Contract terms');
            $table->foreignId('account_manager_id')->nullable()->constrained('users')->onDelete('set null');
            $table->text('billing_address')->nullable()->comment('Billing address');
            $table->string('billing_email')->nullable()->comment('Billing email');
            $table->enum('status', ['active', 'inactive', 'suspended'])->default('active')->comment('Customer status');
            $table->timestamps();

            $table->index(['status', 'created_at']);
            $table->index('account_manager_id');
            $table->index('service_plan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};