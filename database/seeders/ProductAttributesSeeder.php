<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProductType;
use App\Models\ProductModel;
use App\Models\ProductMaterial;
use App\Models\ProductColor;
use App\Models\ProductSize;
use Illuminate\Support\Str;

class ProductAttributesSeeder extends Seeder
{
    public function run()
    {
        $this->seedTypes();
        $this->seedModels();
        $this->seedMaterials();
        $this->seedColors();
        $this->seedSizes();
    }

    private function seedTypes()
    {
        $types = [
            // Moda Fit
            'Camiseta', 'Legging', 'Top', 'Short', 'Jaqueta',
            // Moda Praia
            'Biquíni', 'Sunga', 'Maiô', 'Short Praia', 'Canga',
            // Moda Crochê
            'Blusa', 'Saia', 'Vestido',
            // Suplementos
            'Whey Protein', 'Creatina', 'Pré-Treino', 'BCAA', 'Multivitamínico',
            // Others
            'Kit'
        ];

        foreach (array_unique($types) as $name) {
            $code = strtoupper(substr(Str::slug($name), 0, 3));
            // Ensure unique code logic if needed, but for now simple substr
            if ($name === 'Short Praia') $code = 'SHP';
            if ($name === 'Pré-Treino') $code = 'PRE';
            
            ProductType::firstOrCreate(
                ['name' => $name],
                ['code' => $code, 'is_active' => true]
            );
        }
    }

    private function seedModels()
    {
        $models = [
            // Moda Fit
            ['name' => 'DryFit', 'code' => 'DRY'],
            ['name' => 'High Waist', 'code' => 'HWA'],
            ['name' => 'Racerback', 'code' => 'RAC'],
            ['name' => 'Running', 'code' => 'RUN'],
            ['name' => 'Corta-Vento', 'code' => 'CVT'],
            // Moda Praia
            ['name' => 'Cortininha', 'code' => 'CTN'],
            ['name' => 'Slip', 'code' => 'SLP'],
            ['name' => 'Frente Única', 'code' => 'FUN'],
            ['name' => 'Surf', 'code' => 'SRF'],
            ['name' => 'Retangular', 'code' => 'RET'],
            // Moda Crochê
            ['name' => 'Boho', 'code' => 'BOH'],
            ['name' => 'Halter', 'code' => 'HAL'],
            ['name' => 'Midi', 'code' => 'MID'],
            ['name' => 'Tradicional', 'code' => 'TRD'],
            ['name' => 'Longo', 'code' => 'LNG'],
            // Suplementos
            ['name' => 'Concentrado', 'code' => 'CON'],
            ['name' => 'Monohidratada', 'code' => 'MNH'],
            ['name' => 'Booster', 'code' => 'BST'],
            ['name' => '2:1:1', 'code' => '211'],
            ['name' => 'Complexo', 'code' => 'CPX']
        ];

        foreach ($models as $model) {
            ProductModel::firstOrCreate(
                ['name' => $model['name']],
                ['code' => $model['code'], 'is_active' => true]
            );
        }
    }

    private function seedMaterials()
    {
        $materials = [
            // Moda Fit
            'Poliéster', 'Poliamida', 'Elastano', 'Microfibra', 'Nylon',
            // Moda Praia
            'Lycra', 'Lycra Premium', 'Viscose',
            // Moda Crochê
            'Linha Premium', 'Algodão', 'Barbante', 'Linha Soft', 'Algodão Natural',
            // Suplementos
            'Soro de Leite', 'Creatina Pura', 'Cafeína', 'Aminoácidos', 'Vitaminas e Minerais'
        ];

        foreach (array_unique($materials) as $name) {
            ProductMaterial::firstOrCreate(
                ['name' => $name],
                ['is_active' => true]
            );
        }
    }

    private function seedColors()
    {
        $colors = [
            ['name' => 'Preto', 'code' => 'PRT', 'hex' => '#000000'],
            ['name' => 'Azul', 'code' => 'AZL', 'hex' => '#0000FF'],
            ['name' => 'Rosa', 'code' => 'ROS', 'hex' => '#FFC0CB'],
            ['name' => 'Verde', 'code' => 'VRD', 'hex' => '#008000'],
            ['name' => 'Cinza', 'code' => 'CIN', 'hex' => '#808080'],
            ['name' => 'Vermelho', 'code' => 'VER', 'hex' => '#FF0000'],
            ['name' => 'Amarelo', 'code' => 'AMA', 'hex' => '#FFFF00'],
            ['name' => 'Colorido', 'code' => 'COL', 'hex' => '#FFFFFF'],
            ['name' => 'Bege', 'code' => 'BEG', 'hex' => '#F5F5DC'],
            ['name' => 'Branco', 'code' => 'BRA', 'hex' => '#FFFFFF'],
            ['name' => 'Marrom', 'code' => 'MAR', 'hex' => '#A52A2A'],
            // Flavors as Colors/Variants
            ['name' => 'Baunilha', 'code' => 'BAU', 'hex' => '#F3E5AB'],
            ['name' => 'Sem Sabor', 'code' => 'SSB', 'hex' => '#FFFFFF'],
            ['name' => 'Frutas Vermelhas', 'code' => 'FRV', 'hex' => '#DC143C'],
            ['name' => 'Limão', 'code' => 'LIM', 'hex' => '#00FF00'],
            ['name' => 'Natural', 'code' => 'NAT', 'hex' => '#F0E68C'],
        ];

        foreach ($colors as $color) {
            ProductColor::firstOrCreate(
                ['name' => $color['name']],
                [
                    'code' => $color['code'],
                    'hex_code' => $color['hex'],
                    'is_active' => true
                ]
            );
        }
    }

    private function seedSizes()
    {
        $sizes = [
            'P', 'M', 'G', 'GG', 'Único',
            '1kg', '300g', '250g', '120 cápsulas', '60 cápsulas'
        ];

        foreach (array_unique($sizes) as $name) {
            $code = strtoupper(Str::slug($name));
            if ($name === 'Único') $code = 'UNI';
            if ($name === '120 cápsulas') $code = '120C';
            if ($name === '60 cápsulas') $code = '60C';
            
            ProductSize::firstOrCreate(
                ['name' => $name],
                ['code' => $code, 'is_active' => true]
            );
        }
    }
}
