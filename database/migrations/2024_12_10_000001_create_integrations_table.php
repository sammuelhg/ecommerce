<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('integrations', function (Blueprint $table) {
            $table->id();
            $table->string('provider')->index(); // ex: 'meta_ads', 'google_ads'
            $table->string('name'); // ex: 'Conta Principal'
            $table->json('credentials'); // O payload criptografado
            $table->boolean('is_active')->default(false);
            $table->timestamp('last_synced_at')->nullable();
            $table->timestamps();
            
            // Garante uma integração única por provedor (se for regra de negócio)
            $table->unique('provider');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('integrations');
    }
};
