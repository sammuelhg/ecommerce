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
        Schema::create('campaign_opens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('newsletter_campaign_id')->constrained('newsletter_campaigns')->cascadeOnDelete();
            $table->foreignId('newsletter_subscriber_id')->constrained('newsletter_subscribers')->cascadeOnDelete();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamps();
            
            // Index for faster queries/deduplication checks
            $table->index(['newsletter_campaign_id', 'newsletter_subscriber_id'], 'camp_opens_camp_sub_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campaign_opens');
    }
};
