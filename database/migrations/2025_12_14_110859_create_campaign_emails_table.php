<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('campaign_emails', function (Blueprint $table) {
            $table->id();
            $table->foreignId('campaign_id')->constrained()->onDelete('cascade');
            $table->string('subject')->nullable();
            $table->longText('body')->nullable();
            $table->integer('delay_hours')->default(0)->comment('Delay in hours after the previous step/lead capture');
            $table->integer('order_index')->default(0)->comment('Sequence order');
            $table->timestamps();
        });

        // Data Migration: Move existing single emails to new table
        $campaigns = DB::table('campaigns')->get();
        foreach ($campaigns as $campaign) {
            $sendingRules = json_decode($campaign->sending_rules, true);
            $subject = $sendingRules['subject'] ?? 'Assunto da Campanha';
            
            DB::table('campaign_emails')->insert([
                'campaign_id' => $campaign->id,
                'subject' => $subject,
                'body' => $campaign->email_content_body,
                'delay_hours' => 0,
                'order_index' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campaign_emails');
    }
};
