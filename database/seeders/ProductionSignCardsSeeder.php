<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Domains\Content\Models\SignCard;

class ProductionSignCardsSeeder extends Seeder
{
    public function run(): void
    {
        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Truncate
        SignCard::truncate();

        // Data
        $data = [
            [
                'id' => 3,
                'user_id' => 7,
                'name' => 'Dra. Jacqueline Maria Bergsten',
                'avatar_url' => 'uploads/email-cards/693a20c09ebe1_1765417152.jpg',
                'signature_text' => 'Saúde • Foco • Resultado
Insta: losfit1000 | www.losfit.com.br',
                'role' => 'CEO - Loja losfit.com.br',
                'slogan' => 'Saúde, foco e Resultado',
                'whatsapp' => '31994161000',
                'instagram' => 'losfit1000',
                'website' => 'losfit.com.br',
                'created_at' => '2025-12-13 21:39:48',
                'updated_at' => '2025-12-14 09:59:18',
                'deleted_at' => null,
            ],
            [
                'id' => 4,
                'user_id' => 7,
                'name' => 'Loja Losfit ',
                'avatar_url' => null,
                'signature_text' => 'A Elegância veste o conforto e a saúde!
Insta: losfit1000 | losfit.com.br',
                'role' => 'Moda Fit, Moda Praia, Moda Crochê, Acessórios e Suplementos',
                'slogan' => null,
                'whatsapp' => null,
                'instagram' => null,
                'website' => null,
                'created_at' => '2025-12-13 21:39:48',
                'updated_at' => '2025-12-13 21:39:48',
                'deleted_at' => null,
            ],
            [
                'id' => 5,
                'user_id' => 7,
                'name' => 'João Marcos',
                'avatar_url' => 'uploads/email-cards/693a20ad6968c_1765417133.jpg',
                'signature_text' => '',
                'role' => 'Estrategista Digital',
                'slogan' => null,
                'whatsapp' => null,
                'instagram' => null,
                'website' => null,
                'created_at' => '2025-12-13 21:39:48',
                'updated_at' => '2025-12-13 21:39:48',
                'deleted_at' => null,
            ],
            [
                'id' => 6,
                'user_id' => 7,
                'name' => 'testecard',
                'avatar_url' => null,
                'signature_text' => 'vamos deploy!
WhatsApp: 31994161000 | Insta: testecardinsta | sammuel.com.br',
                'role' => 'testecardcargo',
                'slogan' => null,
                'whatsapp' => null,
                'instagram' => null,
                'website' => null,
                'created_at' => '2025-12-13 21:39:48',
                'updated_at' => '2025-12-13 21:39:48',
                'deleted_at' => null,
            ],
            [
                'id' => 7,
                'user_id' => 7,
                'name' => 'Sammuel Gomes',
                'avatar_url' => 'uploads/email-cards/693a20901b384_1765417104.jpg',
                'signature_text' => null,
                'role' => 'Tecnologia e Web Marketing',
                'slogan' => 'Fazendo a mágica acontecer!',
                'whatsapp' => '31994161000',
                'instagram' => 'onlinesammuel',
                'website' => 'sammuel.com.br',
                'created_at' => '2025-12-14 09:53:16',
                'updated_at' => '2025-12-14 09:53:16',
                'deleted_at' => null,
            ],
        ];

        foreach ($data as $item) {
            SignCard::create($item);
        }

        // Enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
