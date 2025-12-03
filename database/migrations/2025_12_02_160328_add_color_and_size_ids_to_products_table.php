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
        Schema::table('products', function (Blueprint $table) {
            // Add foreign key columns for color and size
            $table->foreignId('product_color_id')->nullable()->after('product_material_id')->constrained('product_colors')->onDelete('set null');
            $table->foreignId('product_size_id')->nullable()->after('product_color_id')->constrained('product_sizes')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['product_color_id']);
            $table->dropForeign(['product_size_id']);
            $table->dropColumn(['product_color_id', 'product_size_id']);
        });
    }
};
