<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class NewsletterCampaignSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('newsletter_campaigns')->insert([
            [
                'name' => 'Campanha de Verão 2025',
                'slug' => 'verao-2025',
                'subject' => 'Novidades de Verão Chegaram! ☀️',
                'content' => '<h1>Confira nossa nova coleção de verão!</h1><p>Descontos imperdíveis em biquínis e moda praia.</p>',
                'status' => 'draft',
                'type' => 'broadcast',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Desconto de Boas-vindas',
                'slug' => 'boas-vindas',
                'subject' => 'Um presente para você! 🎁',
                'content' => '<h1>Bem-vindo à LosFit!</h1><p>Use o cupom BEMVINDO10 para 10% de desconto na primeira compra.</p>',
                'status' => 'sent',
                'type' => 'broadcast',
                'is_active' => true,
                'created_at' => now()->subDays(5),
                'updated_at' => now()->subDays(5),
            ],
            [
                'name' => 'Black Friday Antecipada',
                'slug' => 'black-friday-vip',
                'subject' => 'Acesso VIP Black Friday 🚀',
                'content' => '<h1>Ofertas exclusivas para VIPs</h1><p>Aproveite antes de todo mundo.</p>',
                'status' => 'scheduled',
                'type' => 'broadcast',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
