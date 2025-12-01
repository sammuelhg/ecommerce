<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Criar tabela de relacionamento para Kits
        Schema::create('product_bundles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kit_id')->constrained('products')->onDelete('cascade');
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->integer('quantity')->default(1);
            $table->timestamps();

            // Evitar duplicatas do mesmo produto no mesmo kit
            $table->unique(['kit_id', 'product_id']);
        });

        // Adicionar o tipo 'Kit' se não existir
        if (DB::table('product_types')->where('code', 'KIT')->doesntExist()) {
            DB::table('product_types')->insert([
                'name' => 'Kit',
                'code' => 'KIT',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('product_bundles');
        
        // Opcional: Remover o tipo Kit (geralmente não removemos dados em down de estrutura, mas para limpeza completa pode ser útil)
        // DB::table('product_types')->where('code', 'KIT')->delete();
    }
};
