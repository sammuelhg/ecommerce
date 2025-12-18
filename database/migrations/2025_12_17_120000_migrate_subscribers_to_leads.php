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
        // 1. Migrate Data
        $subscribers = DB::table('newsletter_subscribers')->get();

        foreach ($subscribers as $subscriber) {
            // Check if lead with email already exists
            $existingLead = DB::table('leads')->where('email', $subscriber->email)->first();

            if (!$existingLead) {
                // Determine status based on is_active
                $status = $subscriber->is_active ? 'active' : 'unsubscribed';

                $leadId = DB::table('leads')->insertGetId([
                    'email' => $subscriber->email,
                    'name' => $subscriber->name,
                    'source' => $subscriber->source ?? 'newsletter',
                    'status' => $status,
                    'utm_source' => $subscriber->utm_source,
                    'utm_medium' => $subscriber->utm_medium,
                    'utm_campaign' => $subscriber->utm_campaign,
                    'utm_content' => $subscriber->utm_content,
                    'created_at' => $subscriber->created_at,
                    'updated_at' => $subscriber->updated_at,
                ]);
            } else {
                $leadId = $existingLead->id;
                // Optional: Update source if generic? keeping existing data is safer.
            }

            // Store mapping for foreign key updates if needed, 
            // but we can join by email or just rely strictly on the logic below 
            // if we are doing this in one go. 
            // Ideally we need to map old ID to new ID for the pivot tables.
        }

        // 2. Add lead_id columns to tracking tables
        Schema::table('newsletter_campaign_subscriber', function (Blueprint $table) {
            $table->unsignedBigInteger('lead_id')->nullable()->after('newsletter_subscriber_id');
        });

        Schema::table('campaign_opens', function (Blueprint $table) {
            $table->unsignedBigInteger('lead_id')->nullable()->after('newsletter_subscriber_id');
        });

        Schema::table('campaign_clicks', function (Blueprint $table) {
            $table->unsignedBigInteger('lead_id')->nullable()->after('newsletter_subscriber_id');
        });

        // 3. Populate lead_id based on newsletter_subscriber_id
        // We need to map `newsletter_subscriber_id` -> `email` -> `lead_id`
        
        $this->updateTrackingTable('newsletter_campaign_subscriber');
        $this->updateTrackingTable('campaign_opens');
        $this->updateTrackingTable('campaign_clicks');

        // 4. Update Foreign Key constraints? (Skipping strict FK for now to avoid locking issues, can add later)
    }

    protected function updateTrackingTable($tableName)
    {
        // Raw SQL for performance/clarity
        // UPDATE target_table t
        // JOIN newsletter_subscribers ns ON t.newsletter_subscriber_id = ns.id
        // JOIN leads l ON ns.email = l.email
        // SET t.lead_id = l.id
        
        DB::statement("
            UPDATE {$tableName} as t
            JOIN newsletter_subscribers as ns ON t.newsletter_subscriber_id = ns.id
            JOIN leads as l ON ns.email = l.email
            SET t.lead_id = l.id
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('newsletter_campaign_subscriber', function (Blueprint $table) {
            $table->dropColumn('lead_id');
        });

        Schema::table('campaign_opens', function (Blueprint $table) {
            $table->dropColumn('lead_id');
        });

        Schema::table('campaign_clicks', function (Blueprint $table) {
            $table->dropColumn('lead_id');
        });
    }
};
