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
        Schema::create('campaigns', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('Campaign name');
            $table->enum('type', ['email', 'sms'])->comment('Campaign type');
            $table->text('template')->comment('Message template with placeholders');
            $table->json('segmentation_criteria')->nullable()->comment('Segmentation criteria as JSON');
            $table->enum('status', ['draft', 'scheduled', 'sent', 'cancelled'])->default('draft')->comment('Campaign status');
            $table->timestamp('scheduled_at')->nullable()->comment('Scheduled send time');
            $table->timestamp('sent_at')->nullable()->comment('Actual send time');
            $table->integer('recipient_count')->default(0)->comment('Number of recipients');
            $table->integer('delivered_count')->default(0)->comment('Number delivered');
            $table->integer('opened_count')->default(0)->comment('Number opened (email only)');
            $table->integer('clicked_count')->default(0)->comment('Number clicked (email only)');
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();

            $table->index(['status', 'type']);
            $table->index('scheduled_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campaigns');
    }
};