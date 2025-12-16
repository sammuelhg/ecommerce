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
        Schema::table('forms', function (Blueprint $table) {
            $table->json('config')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('forms', function (Blueprint $table) {
            // Reverting to not null might fail if there are nulls, so we generally accept nullable or set a default.
            // For strict reversal we would try to revert, but given data integrity risks, just leaving it nullable is often duplicate-migration-safe.
            // However, to follow strict pattern:
            // $table->json('config')->nullable(false)->change(); 
            // We will leave it alone or try to revert if sure. Let's try to revert.
             $table->json('config')->nullable(false)->change();
        });
    }
};
