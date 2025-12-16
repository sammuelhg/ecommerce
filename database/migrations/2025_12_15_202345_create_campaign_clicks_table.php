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
        Schema::create('campaign_clicks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('campaign_id')->constrained('campaigns')->cascadeOnDelete();
            $table->foreignId('newsletter_subscriber_id')->nullable()->constrained('newsletter_subscribers')->nullOnDelete();
            $table->foreignId('campaign_email_id')->nullable()->constrained('campaign_emails')->nullOnDelete(); // Which email in the sequence?
            $table->text('url');
            $table->string('ip_address', 45)->nullable();
            $table->string('user_agent')->nullable();
            $table->timestamps();
            
            $table->index('created_at'); // Good for analytics
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campaign_clicks');
    }
};
