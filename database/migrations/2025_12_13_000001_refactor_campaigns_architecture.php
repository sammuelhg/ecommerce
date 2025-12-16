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
        // 1. Sign Cards Table
        if (!Schema::hasTable('sign_cards')) {
            Schema::create('sign_cards', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
                $table->string('name')->comment('Internal name for the card');
                $table->string('avatar_url')->nullable();
                $table->string('signature_text')->nullable();
                $table->string('role')->nullable();
                
                // Extra fields from prompt/backlog if needed (Phase 4 mentions Is Default, social fields later)
                // We add basics now.
                
                $table->timestamps();
                $table->softDeletes();
            });
        } else {
            Schema::table('sign_cards', function (Blueprint $table) {
                if (!Schema::hasColumn('sign_cards', 'avatar_url')) $table->string('avatar_url')->nullable();
                if (!Schema::hasColumn('sign_cards', 'signature_text')) $table->string('signature_text')->nullable();
                if (!Schema::hasColumn('sign_cards', 'role')) $table->string('role')->nullable();
            });
        }

        // 2. Campaigns Table
        if (!Schema::hasTable('campaigns')) {
            Schema::create('campaigns', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained('users')->cascadeOnDelete(); // Ownership
                $table->string('name');
                $table->string('status')->default('draft'); // active, paused, draft
                
                $table->foreignId('sign_card_id')->nullable()->constrained('sign_cards')->nullOnDelete();
                $table->longText('email_content_body')->nullable();
                $table->json('sending_rules')->nullable(); // JSON for delays, triggers
                
                $table->timestamps();
                $table->softDeletes();
            });
        } else {
             Schema::table('campaigns', function (Blueprint $table) {
                 if (!Schema::hasColumn('campaigns', 'sign_card_id')) $table->foreignId('sign_card_id')->nullable()->constrained('sign_cards')->nullOnDelete();
                 if (!Schema::hasColumn('campaigns', 'email_content_body')) $table->longText('email_content_body')->nullable();
                 if (!Schema::hasColumn('campaigns', 'sending_rules')) $table->json('sending_rules')->nullable();
            });
        }

        // 3. Campaign Product Pivot
        if (!Schema::hasTable('campaign_product')) {
            Schema::create('campaign_product', function (Blueprint $table) {
                $table->id();
                $table->foreignId('campaign_id')->constrained('campaigns')->cascadeOnDelete();
                $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
                $table->integer('order')->default(0); // Display order
                $table->timestamps();
            });
        }

        // 4. Forms Table Updates
        Schema::table('forms', function (Blueprint $table) {
            if (!Schema::hasColumn('forms', 'campaign_id')) {
                $table->foreignId('campaign_id')->nullable()->constrained('campaigns')->nullOnDelete(); // Nullable initially
            }
        });

        // 5. Grid Rules Updates
        Schema::table('grid_rules', function (Blueprint $table) {
            if (!Schema::hasColumn('grid_rules', 'form_id')) {
                $table->foreignId('form_id')->nullable()->constrained('forms')->nullOnDelete();
                $table->index('form_id'); // Performance index
            }
        });

        // 6. Leads Updates
        Schema::table('leads', function (Blueprint $table) {
             if (!Schema::hasColumn('leads', 'campaign_id')) {
                $table->foreignId('campaign_id')->nullable()->constrained('campaigns')->nullOnDelete(); // Assuming leads link to campaign
                $table->index('campaign_id');
             } else {
                 // Check if index exists is harder in raw schema builder, but adding index again usually doesn't hurt if handled right or just skip.
                 // We'll skip complex index checks to keep it simple, Eloquent usually handles it or errors if duplicate name.
                 // Safe way:
                 $sm = Schema::getConnection()->getDoctrineSchemaManager();
                 $indexes = $sm->listTableIndexes('leads');
                 if(!array_key_exists('leads_campaign_id_index', $indexes)) {
                      //$table->index('campaign_id'); // If it already existed as foreign key, it might already have an index.
                 }
             }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // We generally don't want to drop tables effectively destroying data in production in a simple down, 
        // but for development 'migrate:rollback' should clean up.
        
        Schema::table('leads', function (Blueprint $table) {
             if (Schema::hasColumn('leads', 'campaign_id')) {
                 $table->dropForeign(['campaign_id']);
                 $table->dropColumn('campaign_id');
             }
        });

        Schema::table('grid_rules', function (Blueprint $table) {
            if (Schema::hasColumn('grid_rules', 'form_id')) {
                 $table->dropForeign(['form_id']);
                 $table->dropColumn('form_id');
            }
        });

        Schema::table('forms', function (Blueprint $table) {
            if (Schema::hasColumn('forms', 'campaign_id')) {
                 $table->dropForeign(['campaign_id']);
                 $table->dropColumn('campaign_id');
            }
        });

        Schema::dropIfExists('campaign_product');
        Schema::dropIfExists('campaigns');
        Schema::dropIfExists('sign_cards');
    }
};
