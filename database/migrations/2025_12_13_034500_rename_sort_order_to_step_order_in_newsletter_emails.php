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
        Schema::table('newsletter_emails', function (Blueprint $table) {
            // Rename sort_order to step_order to match code expectations
            if (Schema::hasColumn('newsletter_emails', 'sort_order') && !Schema::hasColumn('newsletter_emails', 'step_order')) {
                $table->renameColumn('sort_order', 'step_order');
            }
            // Or if it doesn't exist at all, create it
             if (!Schema::hasColumn('newsletter_emails', 'sort_order') && !Schema::hasColumn('newsletter_emails', 'step_order')) {
                $table->integer('step_order')->default(0);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('newsletter_emails', function (Blueprint $table) {
            if (Schema::hasColumn('newsletter_emails', 'step_order')) {
                $table->renameColumn('step_order', 'sort_order');
            }
        });
    }
};
