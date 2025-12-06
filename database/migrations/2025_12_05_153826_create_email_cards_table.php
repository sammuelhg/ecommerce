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
        Schema::create('email_cards', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Internal name (CEO, Suporte, etc)
            $table->string('sender_name'); // Display name
            $table->string('sender_role')->nullable(); // Role/title
            $table->string('instagram')->nullable();
            $table->string('website')->nullable();
            $table->string('slogan')->nullable();
            $table->boolean('is_default')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('email_cards');
    }
};
