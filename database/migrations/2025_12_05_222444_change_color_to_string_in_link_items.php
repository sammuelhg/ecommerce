<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Change ENUM to VARCHAR
        DB::statement("ALTER TABLE link_items MODIFY color VARCHAR(50) DEFAULT 'white'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE link_items MODIFY color ENUM('white','black','green','gold') DEFAULT 'white'");
    }
};
