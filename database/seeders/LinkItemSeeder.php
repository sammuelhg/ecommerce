<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LinkItem;

class LinkItemSeeder extends Seeder
{
    public function run(): void
    {
        LinkItem::insert([
            [
                'title' => 'Visite nosso Site Oficial',
                'url' => 'https://losfit.com.br',
                'color' => 'black',
                'order' => 1,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'WhatsApp (31) 99416-1000',
                'url' => 'https://wa.me/5531994161000',
                'color' => 'green',
                'order' => 2,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Instagram',
                'url' => 'https://www.instagram.com/losfit1000',
                'color' => 'white',
                'order' => 3,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Ver Catálogo Completo',
                'url' => 'https://losfit.com.br/loja',
                'color' => 'gold',
                'order' => 4,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
