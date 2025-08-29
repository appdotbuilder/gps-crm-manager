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
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('Lead contact name');
            $table->string('email')->nullable()->comment('Lead email address');
            $table->string('phone')->nullable()->comment('Lead phone number');
            $table->string('company')->nullable()->comment('Lead company name');
            $table->enum('source', ['website', 'referral', 'cold_call', 'social_media', 'trade_show', 'other'])->default('website')->comment('Lead source');
            $table->enum('status', ['new', 'contacted', 'qualified', 'lost'])->default('new')->comment('Lead status');
            $table->text('notes')->nullable()->comment('Lead notes and comments');
            $table->foreignId('assigned_to')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('next_followup_at')->nullable()->comment('Next follow-up date');
            $table->decimal('potential_value', 10, 2)->nullable()->comment('Potential deal value');
            $table->timestamps();

            $table->index(['status', 'created_at']);
            $table->index(['assigned_to', 'status']);
            $table->index('source');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};