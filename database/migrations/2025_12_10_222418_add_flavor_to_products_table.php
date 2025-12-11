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
            $table->foreignId('product_flavor_id')->nullable()->constrained('flavors')->nullOnDelete();
            $table->string('variant_type')->default('color')->comment('color, flavor');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['product_flavor_id']);
            $table->dropColumn(['product_flavor_id', 'variant_type']);
        });
    }
};
