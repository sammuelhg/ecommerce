<?php

namespace Database\Seeders;

use App\Models\ProductType;
use App\Models\ProductMaterial;
use App\Models\ProductModel;
use App\Models\Category;
use Illuminate\Database\Seeder;

class ProductAttributesSeeder extends Seeder
{
    public function run(): void
    {
        // Clear existing data
        ProductModel::query()->delete();
        ProductMaterial::query()->delete();
        ProductType::query()->delete();

        // === PRODUCT TYPES ===
        $types = [
            ['name' => 'Tênis', 'code' => 'TEN', 'is_active' => true],
            ['name' => 'Camisa', 'code' => 'CAM', 'is_active' => true],
            ['name' => 'Calça', 'code' => 'CAL', 'is_active' => true],
            ['name' => 'Bermuda', 'code' => 'BER', 'is_active' => true],
            ['name' => 'Jaqueta', 'code' => 'JAQ', 'is_active' => true],
            ['name' => 'Meia', 'code' => 'MEI', 'is_active' => true],
            ['name' => 'Boné', 'code' => 'BON', 'is_active' => true],
            ['name' => 'Chinelo', 'code' => 'CHI', 'is_active' => true],
            ['name' => 'Short', 'code' => 'SHO', 'is_active' => true],
            ['name' => 'Regata', 'code' => 'REG', 'is_active' => true],
        ];

        foreach ($types as $type) {
            ProductType::create($type);
        }

        // === MATERIALS ===
        $materials = [
            ['name' => 'Algodão', 'is_active' => true],
            ['name' => 'Poliéster', 'is_active' => true],
            ['name' => 'Couro', 'is_active' => true],
            ['name' => 'Mesh Respirável', 'is_active' => true],
            ['name' => 'Nylon', 'is_active' => true],
            ['name' => 'Lã', 'is_active' => true],
            ['name' => 'Jeans', 'is_active' => true],
            ['name' => 'Microfibra', 'is_active' => true],
            ['name' => 'Tactel', 'is_active' => true],
            ['name' => 'Elastano', 'is_active' => true],
            ['name' => 'Dry-Fit', 'is_active' => true],
            ['name' => 'Flanelado', 'is_active' => true],
            ['name' => 'Malha', 'is_active' => true],
            ['name' => 'Sintético', 'is_active' => true],
        ];

        foreach ($materials as $material) {
            ProductMaterial::create($material);
        }

        // === MODELS ===
        $models = [
            // Tênis
            ['name' => 'Air Max 90', 'code' => 'AIRMAX90', 'is_active' => true],
            ['name' => 'Glide Pro 5', 'code' => 'GLIDE5', 'is_active' => true],
            ['name' => 'Ultra Boost', 'code' => 'ULTRABOOST', 'is_active' => true],
            ['name' => 'Run Fast', 'code' => 'RUNFAST', 'is_active' => true],
            ['name' => 'Speed Runner', 'code' => 'SPEEDRUN', 'is_active' => true],
            
            // Camisas
            ['name' => 'Classic Fit', 'code' => 'CLASSIC', 'is_active' => true],
            ['name' => 'Slim Fit', 'code' => 'SLIM', 'is_active' => true],
            ['name' => 'Oversized', 'code' => 'OVERSIZED', 'is_active' => true],
            ['name' => 'Athletic Fit', 'code' => 'ATHLETIC', 'is_active' => true],
            
            // Calças/Bermudas
            ['name' => 'Cargo Style', 'code' => 'CARGO', 'is_active' => true],
            ['name' => 'Skinny', 'code' => 'SKINNY', 'is_active' => true],
            ['name' => 'Regular Fit', 'code' => 'REGULAR', 'is_active' => true],
            ['name' => 'Loose Fit', 'code' => 'LOOSE', 'is_active' => true],
            
            // Jaquetas
            ['name' => 'Windbreaker', 'code' => 'WINDBREAK', 'is_active' => true],
            ['name' => 'Bomber', 'code' => 'BOMBER', 'is_active' => true],
            ['name' => 'Puffer', 'code' => 'PUFFER', 'is_active' => true],
            
            // Acessórios
            ['name' => 'Snapback', 'code' => 'SNAPBACK', 'is_active' => true],
            ['name' => 'Dad Hat', 'code' => 'DADHAT', 'is_active' => true],
            ['name' => 'Trucker', 'code' => 'TRUCKER', 'is_active' => true],
        ];

        foreach ($models as $model) {
            ProductModel::create($model);
        }

        $this->command->info('✅ Product Attributes Seeder completed!');
        $this->command->info('   - ' . count($types) . ' Types created');
        $this->command->info('   - ' . count($materials) . ' Materials created');
        $this->command->info('   - ' . count($models) . ' Models created');
    }
}
