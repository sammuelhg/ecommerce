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
        Schema::create('cms_components', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type')->default('blog_grid');
            $table->json('data')->nullable();
            $table->string('image_preview')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cms_components');
    }
};
