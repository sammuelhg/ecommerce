<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Category;
use App\Models\Product;

class ShopSeeder extends Seeder
{
    public function run(): void
    {
        // Disable foreign key checks to allow truncation
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // Truncate tables
        Product::truncate();
        Category::truncate();
        
        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $categories = [
            'Biquínis',
            'Maiôs',
            'Moda Fitness',
            'Moda Praia',
            'Suplementos',
            'Chapéus',
            'Bolsas',
            'Moda Crochê',
            'Acessórios para Casa',
            'Roupas para Natação'
        ];

        foreach ($categories as $categoryName) {
            $category = Category::create([
                'name' => $categoryName,
                'slug' => Str::slug($categoryName),
                'is_active' => true,
            ]);

            // Create 3-5 products for each category
            $numProducts = rand(3, 5);
            
            for ($i = 1; $i <= $numProducts; $i++) {
                $price = rand(50, 300);
                $isOffer = rand(0, 10) > 7; // 30% chance of being an offer
                $oldPrice = $isOffer ? $price * 1.2 : null;

                Product::create([
                    'category_id' => $category->id,
                    'name' => $this->getProductName($categoryName, $i),
                    'slug' => Str::slug($this->getProductName($categoryName, $i)) . '-' . Str::random(5),
                    'description' => "Descrição detalhada do produto " . $this->getProductName($categoryName, $i) . ". Alta qualidade e design exclusivo.",
                    'marketing_description' => $this->getMarketingDescription($categoryName),
                    'price' => $price,
                    'old_price' => $oldPrice,
                    'stock' => rand(10, 100),
                    'is_active' => true,
                    'is_offer' => $isOffer,
                    'image' => 'https://placehold.co/600x600?text=' . urlencode($categoryName . ' ' . $i),
                ]);
            }
        }
    }

    private function getProductName($category, $index)
    {
        $prefixes = ['Lindo', 'Exclusivo', 'Novo', 'Premium', 'Confortável'];
        $prefix = $prefixes[array_rand($prefixes)];
        
        return "$prefix $category Modelo $index";
    }

    private function getMarketingDescription($category)
    {
        $descriptions = [
            'Biquínis' => 'Destaque da Coleção: Eleve seu estilo na praia com a qualidade premium que você merece. Design exclusivo, conforto inigualável e durabilidade garantida para acompanhar seu verão.',
            'Maiôs' => 'Destaque da Coleção: Sofisticação e elegância em cada detalhe. Modelagem perfeita que valoriza suas curvas com conforto absoluto para seus momentos de lazer.',
            'Moda Fitness' => 'Destaque da Coleção: Performance e estilo em perfeita harmonia. Tecnologia de ponta em tecidos que acompanham cada movimento, mantendo você confortável e confiante.',
            'Moda Praia' => 'Destaque da Coleção: Versatilidade e charme para seus dias ensolarados. Peças que transitam perfeitamente da praia ao beach club com muito estilo.',
            'Suplementos' => 'Destaque da Linha: Potencialize seus resultados com a qualidade LosfitNutri. Fórmulas cientificamente desenvolvidas para máxima performance e bem-estar.',
            'Chapéus' => 'Destaque da Coleção: Proteção e estilo sob o sol. Design moderno que complementa qualquer look com sofisticação e funcionalidade.',
            'Bolsas' => 'Destaque da Coleção: Praticidade encontra elegância. Espaço inteligente e design atemporal para acompanhar seu dia a dia com muito charme.',
            'Moda Crochê' => 'Destaque da Coleção: Arte artesanal em cada ponto. Peças únicas que celebram a tradição do crochê com um toque contemporâneo e sofisticado.',
            'Acessórios para Casa' => 'Destaque da Coleção: Transforme seu espaço com detalhes que fazem diferença. Design funcional e estético para elevar o conforto do seu lar.',
            'Roupas para Natação' => 'Destaque da Coleção: Hidrodinâmica e conforto para sua melhor performance. Tecnologia avançada em tecidos que secam rápido e mantêm a forma.'
        ];

        return $descriptions[$category] ?? 'Destaque da Coleção: Eleve seu estilo com a qualidade premium que você merece. Design exclusivo, conforto inigualável e durabilidade garantida para acompanhar seu ritmo.';
    }
}
