<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Category;

class ProductionCategoriesSeeder extends Seeder
{
    public function run(): void
    {
        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Truncate
        Category::truncate();

        // Data
        $data = [
            [
                'id' => 1,
                'parent_id' => null,
                'name' => 'ModaFit',
                'slug' => 'fit',
                'description' => 'Moda fitness, roupas e acessórios para treino e atividades físicas',
                'is_active' => 1,
                'created_at' => '2025-11-30 02:14:13',
                'updated_at' => '2025-11-30 02:14:13',
            ],
            [
                'id' => 2,
                'parent_id' => null,
                'name' => 'ModaPraia',
                'slug' => 'praia',
                'description' => 'Biquínis, maiôs, sungas, saídas de praia e acessórios para a praia',
                'is_active' => 1,
                'created_at' => '2025-11-30 02:14:13',
                'updated_at' => '2025-11-30 02:14:13',
            ],
            [
                'id' => 3,
                'parent_id' => null,
                'name' => 'ModaCrochê',
                'slug' => 'croche',
                'description' => 'Peças artesanais em crochê: roupas, bolsas, chapéus e acessórios para casa',
                'is_active' => 1,
                'created_at' => '2025-11-30 02:14:13',
                'updated_at' => '2025-11-30 02:14:13',
            ],
            [
                'id' => 4,
                'parent_id' => null,
                'name' => 'Suplementos',
                'slug' => 'suplementos',
                'description' => 'Encontre a maior variedade de Suplementos Alimentares, vitaminas, proteínas e produtos nutricionais das melhores marcas, incluindo a nossa linha exclusiva LosfitNutri.',
                'is_active' => 1,
                'created_at' => '2025-11-30 02:14:13',
                'updated_at' => '2025-11-30 02:14:13',
            ],
            [
                'id' => 5,
                'parent_id' => 4,
                'name' => 'LosfitNutri',
                'slug' => 'losfitnutri',
                'description' => 'Marca própria de suplementos',
                'is_active' => 1,
                'created_at' => '2025-11-30 09:13:10',
                'updated_at' => '2025-12-03 23:15:06',
            ],
            [
                'id' => 6,
                'parent_id' => null,
                'name' => 'Acessórios',
                'slug' => 'acessorios',
                'description' => '',
                'is_active' => 1,
                'created_at' => '2025-12-10 12:11:35',
                'updated_at' => '2025-12-10 12:11:35',
            ],
        ];

        foreach ($data as $item) {
            Category::create($item);
        }

        // Enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
