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
        Schema::table('campaign_emails', function (Blueprint $table) {
            if (!Schema::hasColumn('campaign_emails', 'sent_count')) {
                $table->integer('sent_count')->default(0)->comment('Number of emails sent for this step');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('campaign_emails', function (Blueprint $table) {
            if (Schema::hasColumn('campaign_emails', 'sent_count')) {
                $table->dropColumn('sent_count');
            }
        });
    }
};
