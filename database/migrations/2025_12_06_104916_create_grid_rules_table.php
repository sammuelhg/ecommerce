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
        Schema::create('grid_rules', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('position'); // Slot index (e.g. 0, 3, 7)
            $table->string('type'); // 'marketing_banner', 'product_highlight', 'custom_html'
            $table->integer('col_span')->default(1);
            $table->json('configuration')->nullable(); // Stores title, text, link, product_id, etc.
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            // Ensure unique position for active rules? Or just unique position?
            // Let's enforce unique position to avoid conflicts.
            $table->unique('position');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grid_rules');
    }
};
