<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->foreignId('product_type_id')->nullable()->after('category_id')->constrained('product_types')->nullOnDelete();
            $table->foreignId('product_model_id')->nullable()->after('product_type_id')->constrained('product_models')->nullOnDelete();
            $table->foreignId('product_material_id')->nullable()->after('product_model_id')->constrained('product_materials')->nullOnDelete();
            $table->string('color', 50)->nullable()->after('product_material_id');
            $table->string('size', 20)->nullable()->after('color');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['product_type_id']);
            $table->dropForeign(['product_model_id']);
            $table->dropForeign(['product_material_id']);
            $table->dropColumn(['product_type_id', 'product_model_id', 'product_material_id', 'color', 'size']);
        });
    }
};
