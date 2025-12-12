<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmailCardSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('email_cards')->insert([
            'title' => 'LosFit Oficial',
            'description' => 'Sua melhor versão começa aqui. Moda Fitness e Suplementação.',
            'slug' => 'losfit',
            'is_active' => true,
            'photo' => 'https://placehold.co/400x400?text=LosFit+Avatar',
            'whatsapp' => '5531994161000',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
