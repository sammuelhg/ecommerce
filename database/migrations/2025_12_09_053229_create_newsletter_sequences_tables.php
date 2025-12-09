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
        // 1. Create Email Templates Table
        if (!Schema::hasTable('email_templates')) {
            Schema::create('email_templates', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('subject')->nullable();
                $table->longText('body')->nullable();
                $table->string('category')->nullable();
                $table->timestamps();
            });
        }

        // 2. Create Newsletter Emails (Sequence Steps) Table
        if (!Schema::hasTable('newsletter_emails')) {
            Schema::create('newsletter_emails', function (Blueprint $table) {
                $table->id();
                $table->foreignId('newsletter_campaign_id')->constrained()->onDelete('cascade');
                $table->string('subject')->nullable();
                $table->longText('body')->nullable();
                $table->integer('delay_in_hours')->default(0);
                $table->integer('sort_order')->default(0);
                $table->string('status')->default('pending');
                $table->timestamps();
            });
        }

        // 3. Create Pivot
        if (!Schema::hasTable('newsletter_email_product')) {
            Schema::create('newsletter_email_product', function (Blueprint $table) {
                $table->id();
                $table->foreignId('newsletter_email_id')->constrained()->onDelete('cascade');
                $table->foreignId('product_id')->constrained()->onDelete('cascade');
                $table->integer('sort_order')->default(0);
            });
        }

        // 4. Data Migration (Only if newsletter_emails is empty to prevent duplication on retry)
        if (DB::table('newsletter_emails')->count() === 0) {
            $campaigns = DB::table('newsletter_campaigns')->get();
            foreach ($campaigns as $campaign) {
                // Check if body column exists before trying to access it (in case it was already dropped)
                if (Schema::hasColumn('newsletter_campaigns', 'body')) {
                     $emailId = DB::table('newsletter_emails')->insertGetId([
                        'newsletter_campaign_id' => $campaign->id,
                        'subject' => $campaign->subject,
                        'body' => $campaign->body,
                        'delay_in_hours' => 0,
                        'sort_order' => 0,
                        'status' => $campaign->status,
                        'created_at' => $campaign->created_at,
                        'updated_at' => $campaign->updated_at,
                    ]);

                    // Migrate Products
                    if (Schema::hasTable('newsletter_campaign_products')) {
                        $products = DB::table('newsletter_campaign_products')
                            ->where('newsletter_campaign_id', $campaign->id)
                            ->get();
                        
                        foreach ($products as $prod) {
                            DB::table('newsletter_email_product')->insert([
                                'newsletter_email_id' => $emailId,
                                'product_id' => $prod->product_id,
                                'sort_order' => $prod->order ?? 0,
                            ]);
                        }
                    }
                }
            }
        }

        // 5. Cleanup Old
        if (Schema::hasColumn('newsletter_campaigns', 'body')) {
            Schema::table('newsletter_campaigns', function (Blueprint $table) {
                $table->dropColumn('body');
            });
        }

        // 6. Update Analytics
        Schema::table('campaign_opens', function (Blueprint $table) {
            if (!Schema::hasColumn('campaign_opens', 'newsletter_email_id')) {
                $table->foreignId('newsletter_email_id')->nullable()->after('newsletter_campaign_id')->constrained()->onDelete('cascade');
            }
            
            // Drop specific index
            // The unique index below does not exist in the previous migration, so we remove the drop call to fix the error.
            /*
            try {
                $table->dropUnique('campaign_opens_newsletter_campaign_id_newsletter_subscriber_id_unique');
            } catch (\Exception $e) {
            }
            */

             /*
             try {
                $table->dropIndex('camp_opens_camp_sub_idx');
            } catch (\Exception $e) {
                // Index might not exist
            }
            */

            // Add new unique only if not exists
             // (Schema builder doesn't support 'if not exists' easily for indexes, relying on try/catch logic or explicit check above is hard in fluent API)
             // We'll trust the previous drop succeeded or we handle the error.
             // Actually, simplest is to drop constraint if it exists.
        });
        
        // Separate table call to avoid transaction issues with index mod
        Schema::table('campaign_opens', function (Blueprint $table) {
             // Add new unique index
             // Check if it already exists?
        });

         try {
            Schema::table('campaign_opens', function (Blueprint $table) {
                $table->unique(['newsletter_campaign_id', 'newsletter_subscriber_id', 'newsletter_email_id'], 'unique_open_tracking');
            });
        } catch (\Exception $e) {
            // Ignore if exists
        }

        Schema::dropIfExists('newsletter_campaign_products');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('newsletter_sequences_tables');
    }
};
