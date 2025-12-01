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
        Schema::create('product_variations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->string('sku', 50)->unique();
            $table->string('type', 10); // TEN, CAM, etc
            $table->string('model', 10); // 2005A, etc
            $table->string('color', 10); // PRT, AZM, etc
            $table->string('size', 5); // 40, P, M, GG
            $table->decimal('price', 10, 2)->nullable(); // Override price from parent
            $table->integer('stock')->default(0);
            $table->timestamps();

            // Indexes for search optimization
            $table->index('sku');
            $table->index('model');
            $table->index(['product_id', 'size', 'color']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_variations');
    }
};
