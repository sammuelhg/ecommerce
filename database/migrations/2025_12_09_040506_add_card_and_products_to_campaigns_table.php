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
        Schema::table('newsletter_campaigns', function (Blueprint $table) {
            $table->foreignId('email_card_id')->nullable()->constrained('email_cards')->nullOnDelete();
        });

        Schema::create('newsletter_campaign_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('newsletter_campaign_id')->constrained('newsletter_campaigns')->cascadeOnDelete();
            $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('newsletter_campaign_products');

        Schema::table('newsletter_campaigns', function (Blueprint $table) {
            $table->dropForeign(['email_card_id']);
            $table->dropColumn('email_card_id');
        });
    }
};
