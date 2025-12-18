<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\NewsletterCampaign;

class ProductionCampaignsSeeder extends Seeder
{
    public function run(): void
    {
        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Truncate
        NewsletterCampaign::truncate();

        // Data
        $data = [
            [
                'id' => 2,
                'name' => 'teste1',
                'subject' => 'teste1',
                'slug' => 'teste1',
                'sent_at' => '2025-12-08 10:45:59',
                'status' => 'sent',
                'created_at' => '2025-12-08 10:45:38',
                'updated_at' => '2025-12-13 11:16:36',
                'email_card_id' => null,
                'promo_image_url' => '/storage/newsletter-promos/Xa7UAO40HvwRauDJog1XCQEkP0UASaeonXbSXwPW.png',
                'show_promo_image_in_email' => 1,
                'is_active' => 1,
            ],
            [
                'id' => 3,
                'name' => 'teste2',
                'subject' => 'teste2',
                'slug' => 'teste2',
                'sent_at' => null,
                'status' => 'draft',
                'created_at' => '2025-12-09 02:41:22',
                'updated_at' => '2025-12-13 11:16:37',
                'email_card_id' => null,
                'promo_image_url' => '/storage/newsletter-promos/ihL7ahR1AZxfVm9vnJJtuWAfrPjEE4HKBit9zB1u.png',
                'show_promo_image_in_email' => 1,
                'is_active' => 1,
            ],
            [
                'id' => 5,
                'name' => 'Bem Vindo',
                'subject' => 'Bem Vindo',
                'slug' => null,
                'sent_at' => null,
                'status' => 'sent',
                'created_at' => '2025-12-10 23:36:39',
                'updated_at' => '2025-12-13 11:16:42',
                'email_card_id' => 1,
                'promo_image_url' => null,
                'show_promo_image_in_email' => 0,
                'is_active' => 1,
            ],
            [
                'id' => 6,
                'name' => 'Natal',
                'subject' => 'Natal',
                'slug' => null,
                'sent_at' => null,
                'status' => 'sent',
                'created_at' => '2025-12-11 09:49:46',
                'updated_at' => '2025-12-11 11:05:46',
                'email_card_id' => null,
                'promo_image_url' => null,
                'show_promo_image_in_email' => 0,
                'is_active' => 1,
            ],
            [
                'id' => 7,
                'name' => 'Pós Natal',
                'subject' => 'Pós Natal',
                'slug' => null,
                'sent_at' => null,
                'status' => 'draft',
                'created_at' => '2025-12-13 11:29:14',
                'updated_at' => '2025-12-13 16:13:42',
                'email_card_id' => null,
                'promo_image_url' => null,
                'show_promo_image_in_email' => 0,
                'is_active' => 1,
            ],
            [
                'id' => 8,
                'name' => 'natal3',
                'subject' => 'natal3',
                'slug' => null,
                'sent_at' => null,
                'status' => 'draft',
                'created_at' => '2025-12-13 20:40:01',
                'updated_at' => '2025-12-13 20:44:11',
                'email_card_id' => null,
                'promo_image_url' => null,
                'show_promo_image_in_email' => 0,
                'is_active' => 1,
            ],
        ];

        foreach ($data as $item) {
            NewsletterCampaign::create($item);
        }

        // Enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
