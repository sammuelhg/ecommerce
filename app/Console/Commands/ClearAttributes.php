<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class ClearAttributes extends Command
{
    protected $signature = 'db:clear-attributes';
    protected $description = 'Clear all product attribute tables';

    public function handle()
    {
        Schema::disableForeignKeyConstraints();
        
        DB::table('product_colors')->delete();
        DB::table('product_sizes')->delete();
        DB::table('product_types')->delete();
        DB::table('product_models')->delete();
        DB::table('product_materials')->delete();
        
        Schema::enableForeignKeyConstraints();
        
        $this->info('✅ All attribute tables cleared!');
        
        return 0;
    }
}
