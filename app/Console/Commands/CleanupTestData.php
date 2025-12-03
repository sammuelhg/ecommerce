<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductType;
use App\Models\ProductModel;
use App\Models\ProductMaterial;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class CleanupTestData extends Command
{
    protected $signature = 'db:cleanup-test-data {--force : Skip confirmation}';
    protected $description = 'Clean test data, preserving essential categories and Kit type';

    // Categorias com links hardcoded no front da loja
    protected $preservedCategorySlugs = ['fit', 'praia', 'croche', 'suplementos'];

    public function handle()
    {
        if (!$this->option('force')) {
            if (!$this->confirm('⚠️  This will DELETE all products, images, and most categories. Continue?')) {
                $this->info('Operation cancelled.');
                return 0;
            }
        }

        \Illuminate\Support\Facades\Schema::disableForeignKeyConstraints();
        DB::beginTransaction();

        try {
            $this->info('🧹 Starting cleanup...');

            // 1. Delete all product images (files and DB records)
            $this->deleteProductImages();

            // 2. Delete all products
            $this->deleteProducts();

            // 3. Delete categories (except preserved ones)
            $this->deleteCategories();

            // 4. Delete materials
            $this->deleteMaterials();

            // 5. Delete models
            $this->deleteModels();

            // 6. Delete types (except Kit)
            $this->deleteTypes();

            DB::commit();

            $this->newLine();
            $this->info('✅ Cleanup completed successfully!');
            $this->displayPreservedData();

            return 0;

        } catch (\Exception $e) {
            DB::rollBack();
            $this->error('❌ Error during cleanup: ' . $e->getMessage());
            $this->error($e->getTraceAsString());
            return 1;
        } finally {
            \Illuminate\Support\Facades\Schema::enableForeignKeyConstraints();
        }
    }

    protected function deleteProductImages()
    {
        $this->info('📸 Deleting product images...');

        $images = ProductImage::all();
        $count = $images->count();

        $bar = $this->output->createProgressBar($count);
        $bar->start();

        foreach ($images as $image) {
            // Delete actual files
            if ($image->path && Storage::disk('public')->exists($image->path)) {
                Storage::disk('public')->delete($image->path);
            }

            $image->delete();
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->line("   Deleted {$count} images");

        // Clean temp folder
        $tempPath = 'temp';
        if (Storage::disk('public')->exists($tempPath)) {
            $tempFiles = Storage::disk('public')->files($tempPath);
            foreach ($tempFiles as $file) {
                Storage::disk('public')->delete($file);
            }
            $this->line("   Cleaned " . count($tempFiles) . " temp files");
        }
    }

    protected function deleteProducts()
    {
        $this->info('📦 Deleting products...');

        $count = Product::count();
        
        // Delete related data first to avoid foreign key constraints
        DB::table('cart_items')->delete();
        DB::table('order_items')->delete();
        DB::table('product_bundles')->delete();
        
        // Delete products
        Product::query()->delete();

        $this->line("   Deleted {$count} products");
    }

    protected function deleteCategories()
    {
        $this->info('🏷️  Deleting categories...');

        $preservedIds = Category::whereIn('slug', $this->preservedCategorySlugs)
            ->pluck('id')
            ->toArray();

        $count = DB::table('categories')->whereNotIn('id', $preservedIds)->count();
        DB::table('categories')->whereNotIn('id', $preservedIds)->delete();

        $this->line("   Deleted {$count} categories");
        $this->line("   Preserved: " . implode(', ', $this->preservedCategorySlugs));
    }

    protected function deleteMaterials()
    {
        $this->info('🧵 Deleting materials...');

        $count = ProductMaterial::count();
        ProductMaterial::query()->delete();

        $this->line("   Deleted {$count} materials");
    }

    protected function deleteModels()
    {
        $this->info('📐 Deleting models...');

        $count = ProductModel::count();
        ProductModel::query()->delete();

        $this->line("   Deleted {$count} models");
    }

    protected function deleteTypes()
    {
        $this->info('🏭 Deleting types...');

        // Preserve "Kit" type
        $kitType = ProductType::where('name', 'Kit')->orWhere('slug', 'kit')->first();
        
        $query = ProductType::query();
        if ($kitType) {
            $query->where('id', '!=', $kitType->id);
        }

        $count = $query->count();
        $query->delete();

        $this->line("   Deleted {$count} types");
        if ($kitType) {
            $this->line("   Preserved: Kit (ID: {$kitType->id})");
        }
    }

    protected function displayPreservedData()
    {
        $this->newLine();
        $this->info('📋 Preserved Data:');
        
        // Categories
        $categories = Category::whereIn('slug', $this->preservedCategorySlugs)->get(['id', 'name', 'slug']);
        $this->table(['ID', 'Name', 'Slug'], $categories->map(fn($c) => [$c->id, $c->name, $c->slug])->toArray());

        // Kit type
        $kitType = ProductType::where('name', 'Kit')->orWhere('slug', 'kit')->first();
        if ($kitType) {
            $this->newLine();
            $this->line("Kit Type: {$kitType->name} (ID: {$kitType->id})");
        }
    }
}
