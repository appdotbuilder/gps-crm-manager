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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('ticket_number')->unique()->comment('Ticket number');
            $table->foreignId('customer_id')->constrained()->onDelete('cascade');
            $table->string('subject')->comment('Ticket subject');
            $table->text('description')->comment('Issue description');
            $table->enum('priority', ['low', 'medium', 'high', 'urgent'])->default('medium')->comment('Ticket priority');
            $table->enum('status', ['open', 'pending', 'resolved', 'closed'])->default('open')->comment('Ticket status');
            $table->enum('issue_type', ['technical', 'billing', 'general', 'hardware', 'software'])->default('general')->comment('Issue type');
            $table->foreignId('assigned_to')->nullable()->constrained('users')->onDelete('set null');
            $table->text('resolution_notes')->nullable()->comment('Resolution notes');
            $table->timestamp('resolved_at')->nullable()->comment('Resolution timestamp');
            $table->timestamps();

            $table->index(['customer_id', 'status']);
            $table->index(['assigned_to', 'status']);
            $table->index('priority');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};