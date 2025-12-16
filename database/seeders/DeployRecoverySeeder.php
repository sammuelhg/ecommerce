<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SignCard;
use App\Models\StoreSetting;
use App\Models\GridRule;
use Illuminate\Support\Facades\DB;

class DeployRecoverySeeder extends Seeder
{
    public function run()
    {
        // 1. Restore Sign Cards
        DB::table('sign_cards')->truncate();
        $cards = array (
  0 => 
  array (
    'id' => 3,
    'user_id' => 7,
    'name' => 'Dra. Jacqueline Maria Bergsten',
    'avatar_url' => '/deploy_assets/forced_migration/card_693a20c09ebe1_1765417152.jpg',
    'signature_text' => 'Saúde • Foco • Resultado
Insta: losfit1000 | www.losfit.com.br',
    'role' => 'CEO - Loja losfit.com.br',
    'slogan' => 'Saúde, foco e Resultado',
    'whatsapp' => '31994161000',
    'instagram' => 'losfit1000',
    'website' => 'losfit.com.br',
    'created_at' => '2025-12-13T21:39:48.000000Z',
    'updated_at' => '2025-12-14T09:59:18.000000Z',
    'deleted_at' => NULL,
  ),
  1 => 
  array (
    'id' => 4,
    'user_id' => 7,
    'name' => 'Loja Losfit ',
    'avatar_url' => NULL,
    'signature_text' => 'A Elegância veste o conforto e a saúde!
Insta: losfit1000 | losfit.com.br',
    'role' => 'Moda Fit, Moda Praia, Moda Crochê, Acessórios e Suplementos',
    'slogan' => NULL,
    'whatsapp' => NULL,
    'instagram' => NULL,
    'website' => NULL,
    'created_at' => '2025-12-13T21:39:48.000000Z',
    'updated_at' => '2025-12-13T21:39:48.000000Z',
    'deleted_at' => NULL,
  ),
  2 => 
  array (
    'id' => 5,
    'user_id' => 7,
    'name' => 'João Marcos',
    'avatar_url' => '/deploy_assets/forced_migration/card_693a20ad6968c_1765417133.jpg',
    'signature_text' => '',
    'role' => 'Estrategista Digital',
    'slogan' => NULL,
    'whatsapp' => NULL,
    'instagram' => NULL,
    'website' => NULL,
    'created_at' => '2025-12-13T21:39:48.000000Z',
    'updated_at' => '2025-12-13T21:39:48.000000Z',
    'deleted_at' => NULL,
  ),
  3 => 
  array (
    'id' => 6,
    'user_id' => 7,
    'name' => 'testecard',
    'avatar_url' => NULL,
    'signature_text' => 'vamos deploy!
WhatsApp: 31994161000 | Insta: testecardinsta | sammuel.com.br',
    'role' => 'testecardcargo',
    'slogan' => NULL,
    'whatsapp' => NULL,
    'instagram' => NULL,
    'website' => NULL,
    'created_at' => '2025-12-13T21:39:48.000000Z',
    'updated_at' => '2025-12-13T21:39:48.000000Z',
    'deleted_at' => NULL,
  ),
  4 => 
  array (
    'id' => 7,
    'user_id' => 7,
    'name' => 'Sammuel Gomes',
    'avatar_url' => '/deploy_assets/forced_migration/card_693a20901b384_1765417104.jpg',
    'signature_text' => NULL,
    'role' => 'Tecnologia e Web Marketing',
    'slogan' => 'Fazendo a mágica acontecer!',
    'whatsapp' => '31994161000',
    'instagram' => 'onlinesammuel',
    'website' => 'sammuel.com.br',
    'created_at' => '2025-12-14T09:53:16.000000Z',
    'updated_at' => '2025-12-14T09:53:16.000000Z',
    'deleted_at' => NULL,
  ),
);
        foreach ($cards as $card) {
            SignCard::create($card);
        }

        // 2. Restore Settings
        $settings = array (
  0 => 
  array (
    'id' => 24,
    'key' => 'store_logo',
    'value' => '/deploy_assets/forced_migration/setting_logo.png',
    'type' => 'image',
    'created_at' => '2025-12-07T21:33:54.000000Z',
    'updated_at' => '2025-12-10T09:03:00.000000Z',
  ),
  1 => 
  array (
    'id' => 25,
    'key' => 'footer_logo',
    'value' => '/deploy_assets/forced_migration/setting_sol.png',
    'type' => 'image',
    'created_at' => '2025-12-07T22:04:13.000000Z',
    'updated_at' => '2025-12-07T22:04:13.000000Z',
  ),
  2 => 
  array (
    'id' => 26,
    'key' => 'email_logo',
    'value' => '/deploy_assets/forced_migration/setting_logo-email.png',
    'type' => 'image',
    'created_at' => '2025-12-08T22:39:00.000000Z',
    'updated_at' => '2025-12-13T01:20:04.000000Z',
  ),
  3 => 
  array (
    'id' => 27,
    'key' => 'profile_logo',
    'value' => '/deploy_assets/forced_migration/setting_logo-redonda-trans.png',
    'type' => 'image',
    'created_at' => '2025-12-08T22:39:00.000000Z',
    'updated_at' => '2025-12-08T22:39:00.000000Z',
  ),
  4 => 
  array (
    'id' => 28,
    'key' => 'favicon',
    'value' => '/deploy_assets/forced_migration/setting_favicon.ico',
    'type' => 'image',
    'created_at' => '2025-12-08T22:41:27.000000Z',
    'updated_at' => '2025-12-08T22:41:27.000000Z',
  ),
);
        foreach ($settings as $setting) {
            StoreSetting::updateOrCreate(
                ['key' => $setting['key']],
                [
                    'value' => $setting['value'],
                    'type' => $setting['type']
                ]
            );
        }

        // 3. Restore Grid Rules
        DB::table('grid_rules')->truncate();
        $rules = array (
  0 => 
  array (
    'id' => 27,
    'position' => 1,
    'type' => 'card.newsletter_form',
    'col_span' => 1,
    'configuration' => 
    array (
      'text_color' => 'text-white',
      'bg_color' => 'bg-warning',
      'image' => '/deploy_assets/forced_migration/grid_glyuSpv7LTIXIatjefjzmzLS4Vg6pDio60oYNcNj.jpg',
      'image_style' => 'top',
    ),
    'is_active' => true,
    'created_at' => '2025-12-15T16:40:43.000000Z',
    'updated_at' => '2025-12-16T12:59:24.000000Z',
    'form_id' => 2,
  ),
  1 => 
  array (
    'id' => 30,
    'position' => 0,
    'type' => 'card.product_highlight',
    'col_span' => 1,
    'configuration' => 
    array (
      'product_id' => 83,
    ),
    'is_active' => true,
    'created_at' => '2025-12-15T18:07:50.000000Z',
    'updated_at' => '2025-12-15T18:07:50.000000Z',
    'form_id' => NULL,
  ),
  2 => 
  array (
    'id' => 31,
    'position' => 2,
    'type' => 'card.product_special',
    'col_span' => 1,
    'configuration' => 
    array (
      'product_id' => 86,
      'badge_type' => 'best_buy',
    ),
    'is_active' => true,
    'created_at' => '2025-12-16T03:52:44.000000Z',
    'updated_at' => '2025-12-16T09:58:57.000000Z',
    'form_id' => NULL,
  ),
);
        foreach ($rules as $rule) {
            // Encode configuration if necessary, usually Model handles casting
            GridRule::create($rule);
        }
    }
}