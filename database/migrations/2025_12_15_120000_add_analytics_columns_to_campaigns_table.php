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
        Schema::table('campaigns', function (Blueprint $table) {
            if (!Schema::hasColumn('campaigns', 'generated_revenue')) {
                $table->decimal('generated_revenue', 10, 2)->default(0.00)->comment('Total revenue attributed to this campaign');
            }
            if (!Schema::hasColumn('campaigns', 'conversion_count')) {
                $table->integer('conversion_count')->default(0)->comment('Number of conversions attributed');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('campaigns', function (Blueprint $table) {
            if (Schema::hasColumn('campaigns', 'generated_revenue')) {
                $table->dropColumn('generated_revenue');
            }
            if (Schema::hasColumn('campaigns', 'conversion_count')) {
                $table->dropColumn('conversion_count');
            }
        });
    }
};
