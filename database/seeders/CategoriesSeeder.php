<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoriesSeeder extends Seeder
{
    public function run(): void
    {
        // Clear existing categories (use delete to avoid FK constraints)
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Category::truncate();
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $categories = [
            [
                'name' => 'ModaFit',
                'slug' => 'fit',
                'description' => 'Moda fitness, roupas e acessórios para treino e atividades físicas',
                'is_active' => true,
            ],
            [
                'name' => 'ModaPraia',
                'slug' => 'praia',
                'description' => 'Biquínis, maiôs, sungas, saídas de praia e acessórios para a praia',
                'is_active' => true,
            ],
            [
                'name' => 'ModaCrochê',
                'slug' => 'croche',
                'description' => 'Peças artesanais em crochê: roupas, bolsas, chapéus e acessórios para casa',
                'is_active' => true,
            ],
            [
                'name' => 'LosfitNutri',
                'slug' => 'suplementos',
                'description' => 'Suplementos alimentares, vitaminas e produtos nutricionais',
                'is_active' => true,
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        $this->command->info('✅ Categories Seeder completed!');
        $this->command->info('   - ' . count($categories) . ' Categories created');
    }
}
