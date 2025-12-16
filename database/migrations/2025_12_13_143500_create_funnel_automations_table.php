<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('funnel_automations', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g. "Move Paid to Customer"
            
            // Trigger Condition
            $table->string('trigger_event'); // e.g. 'order_paid', 'email_opened'
            $table->string('trigger_operator')->default('=='); // '==', '>', '<', 'contains'
            $table->string('trigger_value')->nullable(); // '100', 'product-x'
            
            // Action to Perform
            $table->string('action_type'); // 'move_lead_stage'
            $table->json('action_payload')->nullable(); // { "target_status": "customer" }
            
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('funnel_automations');
    }
};
