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
        Schema::table('sign_cards', function (Blueprint $table) {
            $table->string('slogan')->nullable()->after('role');
            $table->string('whatsapp')->nullable()->after('slogan');
            $table->string('instagram')->nullable()->after('whatsapp');
            $table->string('website')->nullable()->after('instagram');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sign_cards', function (Blueprint $table) {
            $table->dropColumn(['slogan', 'whatsapp', 'instagram', 'website']);
        });
    }
};
