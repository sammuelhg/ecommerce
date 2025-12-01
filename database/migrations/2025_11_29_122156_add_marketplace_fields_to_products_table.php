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
            // Identificação do Produto
            $table->string('sku')->nullable()->unique()->after('slug');
            $table->string('ean')->nullable()->after('sku'); // EAN/GTIN/código de barras
            $table->string('brand')->nullable()->after('category_id'); // Marca
            
            // Características Físicas (para frete)
            $table->decimal('weight', 8, 3)->nullable()->after('stock'); // Peso em kg
            $table->decimal('height', 8, 2)->nullable()->after('weight'); // Altura em cm
            $table->decimal('width', 8, 2)->nullable()->after('height'); // Largura em cm
            $table->decimal('length', 8, 2)->nullable()->after('width'); // Comprimento em cm
            
            // Informações Comerciais
            $table->enum('condition', ['new', 'used', 'refurbished'])->default('new')->after('is_active');
            $table->string('warranty')->nullable()->after('condition'); // Ex: "90 dias"
            $table->string('origin')->nullable()->after('warranty'); // nacional/importado
            
            // Fiscal (Brasil)
            $table->string('ncm')->nullable()->after('origin'); // Nomenclatura Comum do Mercosul
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'sku',
                'ean',
                'brand',
                'weight',
                'height',
                'width',
                'length',
                'condition',
                'warranty',
                'origin',
                'ncm'
            ]);
        });
    }
};
