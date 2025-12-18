<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Domains\Catalog\Models\GridRule;

class ProductionGridRulesSeeder extends Seeder
{
    public function run(): void
    {
        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Truncate
        GridRule::truncate();

        // Data
        $data = [
            [
                'id' => 30,
                'position' => 0,
                'type' => 'card.product_highlight',
                'col_span' => 1,
                'configuration' => ['product_id' => 83],
                'is_active' => 1,
                'created_at' => '2025-12-15 18:07:50',
                'updated_at' => '2025-12-15 18:07:50',
                'form_id' => null,
            ],
            [
                'id' => 27,
                'position' => 1,
                'type' => 'card.newsletter_form',
                'col_span' => 1,
                'configuration' => [
                    'text_color' => 'text-white',
                    'bg_color' => 'bg-warning',
                    'image' => 'newsletter-assets/glyuSpv7LTIXIatjefjzmzLS4Vg6pDio60oYNcNj.jpg',
                    'image_style' => 'top'
                ],
                'is_active' => 1,
                'created_at' => '2025-12-15 16:40:43',
                'updated_at' => '2025-12-16 12:59:24',
                'form_id' => 2,
            ],
            [
                'id' => 31,
                'position' => 2,
                'type' => 'card.product_special',
                'col_span' => 1,
                'configuration' => ['product_id' => 86, 'badge_type' => 'best_buy'],
                'is_active' => 1,
                'created_at' => '2025-12-16 03:52:44',
                'updated_at' => '2025-12-16 09:58:57',
                'form_id' => null,
            ],
            [
                'id' => 32,
                'position' => 5,
                'type' => 'card.newsletter_form',
                'col_span' => 1,
                'configuration' => [
                    'text_color' => 'text-dark',
                    'bg_color' => 'bg-light',
                    'image' => 'newsletter-assets/30e0ZXj4XvFZB3b860a38rpJzwEHIWHnJ51VIABO.jpg',
                    'image_style' => 'top'
                ],
                'is_active' => 1,
                'created_at' => '2025-12-16 22:27:00',
                'updated_at' => '2025-12-16 22:28:28',
                'form_id' => 5,
            ],
        ];

        foreach ($data as $item) {
            GridRule::create($item);
        }

        // Enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
