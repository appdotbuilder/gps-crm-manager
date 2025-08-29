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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title')->comment('Task title');
            $table->text('description')->nullable()->comment('Task description');
            $table->enum('priority', ['low', 'medium', 'high'])->default('medium')->comment('Task priority');
            $table->enum('status', ['open', 'in_progress', 'done'])->default('open')->comment('Task status');
            $table->date('due_date')->nullable()->comment('Task due date');
            $table->foreignId('assignee_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->morphs('taskable');
            $table->timestamps();

            $table->index(['assignee_id', 'status']);
            $table->index('due_date');
            $table->index(['status', 'priority']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};