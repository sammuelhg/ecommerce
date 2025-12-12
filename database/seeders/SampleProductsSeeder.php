<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use App\Models\ProductType;
use App\Models\ProductModel;
use App\Models\ProductMaterial;
use App\Services\SkuGeneratorService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SampleProductsSeeder extends Seeder
{
    public function run(): void
    {
        // Clear existing products
        Product::query()->delete();
        
        $skuService = new SkuGeneratorService();

        // Get categories
        $modaFit = Category::where('slug', 'fit')->first();
        $modaPraia = Category::where('slug', 'praia')->first();
        $modaCroche = Category::where('slug', 'croche')->first();
        $losfitNutri = Category::where('slug', 'suplementos')->first();

        // Get attributes
        $types = ProductType::all()->keyBy('code');
        $materials = ProductMaterial::all()->keyBy('name');
        $models = ProductModel::all()->keyBy('code');

        $products = [
            // MODA FIT
            [
                'category_id' => $modaFit->id,
                'product_type_id' => $types['CAM']->id ?? null,
                'product_model_id' => $models['ATHLETIC']->id ?? null,
                'product_material_id' => $materials['Dry-Fit']->id ?? null,
                'color' => 'Preto',
                'size' => 'M',
                'price' => 89.90,
                'stock' => 50,
                'description' => 'Camisa fitness de alta performance com tecnologia dry-fit que mantém o corpo seco durante o treino.',
                'is_active' => true,
            ],
            [
                'category_id' => $modaFit->id,
                'product_type_id' => $types['CAL']->id ?? null,
                'product_model_id' => $models['SKINNY']->id ?? null,
                'product_material_id' => $materials['Elastano']->id ?? null,
                'color' => 'Cinza',
                'size' => 'P',
                'price' => 129.90,
                'stock' => 30,
                'description' => 'Calça legging fitness com tecido de alta elasticidade e modelagem anatômica.',
                'is_active' => true,
            ],

            // MODA PRAIA
            [
                'category_id' => $modaPraia->id,
                'product_type_id' => $types['REG']->id ?? null,
                'product_model_id' => $models['CLASSIC']->id ?? null,
                'product_material_id' => $materials['Microfibra']->id ?? null,
                'color' => 'Azul',
                'size' => 'M',
                'price' => 159.90,
                'stock' => 25,
                'description' => 'Biquíni top com bojo removível e acabamento premium em microfibra.',
                'is_active' => true,
            ],
            [
                'category_id' => $modaPraia->id,
                'product_type_id' => $types['REG']->id ?? null,
                'product_model_id' => $models['SLIM']->id ?? null,
                'product_material_id' => $materials['Microfibra']->id ?? null,
                'color' => 'Vermelho',
                'size' => 'G',
                'price' => 199.90,
                'stock' => 20,
                'description' => 'Maiô com recortes estratégicos e proteção UV50+.',
                'is_active' => true,
            ],

            // MODA CROCHÊ
            [
                'category_id' => $modaCroche->id,
                'product_type_id' => $types['BON']->id ?? null,
                'product_model_id' => $models['SNAPBACK']->id ?? null,
                'product_material_id' => $materials['Algodão']->id ?? null,
                'color' => 'Bege',
                'size' => 'U',
                'price' => 79.90,
                'stock' => 15,
                'description' => 'Chapéu de crochê feito à mão com fio 100% algodão.',
                'is_active' => true,
            ],
            [
                'category_id' => $modaCroche->id,
                'product_type_id' => $types['CAM']->id ?? null,
                'product_model_id' => $models['OVERSIZED']->id ?? null,
                'product_material_id' => $materials['Algodão']->id ?? null,
                'color' => 'Branco',
                'size' => 'U',
                'price' => 149.90,
                'stock' => 10,
                'description' => 'Saída de praia em crochê artesanal com padrão exclusivo.',
                'is_active' => true,
            ],

            // LOSFIT NUTRI
            [
                'category_id' => $losfitNutri->id,
                'product_type_id' => null,
                'product_model_id' => null,
                'product_material_id' => null,
                'color' => null,
                'size' => '900g',
                'price' => 119.90,
                'stock' => 100,
                'description' => 'Whey Protein isolado com 90% de proteína. Sabor chocolate. Ideal para ganho de massa muscular.',
                'is_active' => true,
            ],
            [
                'category_id' => $losfitNutri->id,
                'product_type_id' => null,
                'product_model_id' => null,
                'product_material_id' => null,
                'color' => null,
                'size' => '60 cáps',
                'price' => 49.90,
                'stock' => 150,
                'description' => 'Complexo vitamínico completo com 13 vitaminas e 11 minerais essenciais.',
                'is_active' => true,
            ],
        ];

        foreach ($products as $index => $productData) {
            // Generate title
            $titleParts = array_filter([
                $productData['product_type_id'] ? ProductType::find($productData['product_type_id'])->name : null,
                $productData['product_model_id'] ? ProductModel::find($productData['product_model_id'])->name : null,
                $productData['product_material_id'] ? 'Em ' . ProductMaterial::find($productData['product_material_id'])->name : null,
                $productData['color'] ? '– ' . $productData['color'] : null,
                $productData['size'] && $productData['category_id'] != $losfitNutri->id ? 'Tamanho ' . $productData['size'] : null,
            ]);

            // Generate name based on available data
            if (!empty($titleParts)) {
                $name = implode(' ', $titleParts);
            } else {
                // For supplements without attributes, create descriptive name
                $category = Category::find($productData['category_id']);
                $sizeInfo = $productData['size'] ? ' ' . $productData['size'] : '';
                $name = $category->name . $sizeInfo . ' - ' . substr($productData['description'], 0, 30);
            }
            
            // Generate SKU
            if ($productData['category_id'] == $losfitNutri->id) {
                // For supplements, simple SKU
                $sku = 'NUT-' . str_pad($index + 1, 4, '0', STR_PAD_LEFT);
            } else if ($productData['product_type_id']) {
                $category = Category::find($productData['category_id']);
                $type = ProductType::find($productData['product_type_id']);
                $sku = $skuService->generate(
                    $category->name,
                    $type->name,
                    $productData['color'] ?? 'STD',
                    $productData['size'] ?? 'U'
                );
            } else {
                $sku = null;
            }

            Product::create([
                'name' => $name,
                'slug' => Str::slug($name),
                'sku' => $sku,
                'category_id' => $productData['category_id'],
                'product_type_id' => $productData['product_type_id'],
                'product_model_id' => $productData['product_model_id'],
                'product_material_id' => $productData['product_material_id'],
                'color' => $productData['color'],
                'size' => $productData['size'],
                'description' => $productData['description'],
                'price' => $productData['price'],
                'stock' => $productData['stock'],
                'is_active' => $productData['is_active'],
            ]);
        }

        $this->command->info('✅ Sample Products Seeder completed!');
        $this->command->info('   - ' . count($products) . ' Products created');
    }
}
