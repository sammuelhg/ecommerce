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
        Schema::table('newsletter_campaigns', function (Blueprint $table) {
            if (!Schema::hasColumn('newsletter_campaigns', 'name')) {
                $table->string('name')->nullable()->after('id');
            }
        });

        // Initialize name with subject if null
        DB::table('newsletter_campaigns')->whereNull('name')->update([
            'name' => DB::raw('subject')
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('newsletter_campaigns', function (Blueprint $table) {
            if (Schema::hasColumn('newsletter_campaigns', 'name')) {
                $table->dropColumn('name');
            }
        });
    }
};
