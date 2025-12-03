<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Product;
use App\Models\ProductColor;
use App\Models\ProductSize;
use App\Services\SkuGeneratorService;

class ProductDuplicateModal extends Component
{
    public $showModal = false;
    public $originalProductId;
    public $originalProduct;
    
    public $newAttribute = '';
    public $newColorId = '';
    public $newSizeId = '';
    
    public $errorMessage = '';
    
    public $availableColors = [];
    public $availableSizes = [];

    public function mount($productId = null)
    {
        if ($productId) {
            $this->originalProductId = $productId;
            $this->originalProduct = Product::with(['productColor', 'productSize'])->findOrFail($productId);
            
            // Carregar opções disponíveis
            $this->availableColors = ProductColor::where('is_active', true)->get();
            $this->availableSizes = ProductSize::where('is_active', true)->get();
            
            // Pré-preencher com valores corretos
            $this->newAttribute = $this->originalProduct->attribute ?? '';
            $this->newColorId = $this->originalProduct->product_color_id ?? '';
            $this->newSizeId = $this->originalProduct->product_size_id ?? '';
            
            $this->errorMessage = '';
            $this->showModal = true;
        }
    }

    public function duplicate()
    {
        // Validar se há diferença
        if ($this->newAttribute === ($this->originalProduct->attribute ?? '') &&
            $this->newColorId === ($this->originalProduct->product_color_id ?? '') &&
            $this->newSizeId === ($this->originalProduct->product_size_id ?? '')) {
            
            $this->errorMessage = 'Você precisa alterar pelo menos um campo (Atributo, Cor ou Tamanho) para criar um novo produto.';
            return;
        }

        // Create a copy
        $newProduct = $this->originalProduct->replicate();
        
        // Update fields from selects
        $newProduct->attribute = $this->newAttribute ?: null;
        $newProduct->product_color_id = $this->newColorId ?: null;
        $newProduct->product_size_id = $this->newSizeId ?: null;
        
        // Sync string values from relationships
        if ($newProduct->product_color_id) {
            $color = ProductColor::find($newProduct->product_color_id);
            $newProduct->color = $color ? $color->name : null;
        } else {
            $newProduct->color = null;
        }
        
        if ($newProduct->product_size_id) {
            $size = ProductSize::find($newProduct->product_size_id);
            $newProduct->size = $size ? $size->name : null;
        } else {
            $newProduct->size = null;
        }
        
        // Regenerate name using the same logic as ProductForm
        $parts = [];
        
        if ($newProduct->product_type_id) {
            $type = \App\Models\ProductType::find($newProduct->product_type_id);
            if ($type) $parts[] = $type->name;
        }
        
        if ($newProduct->product_model_id) {
            $model = \App\Models\ProductModel::find($newProduct->product_model_id);
            if ($model) $parts[] = $model->name;
        }
        
        if ($newProduct->product_material_id) {
            $material = \App\Models\ProductMaterial::find($newProduct->product_material_id);
            if ($material) $parts[] = "em {$material->name}";
        }
        
        if ($newProduct->attribute) {
            $parts[] = $newProduct->attribute;
        }
        
        if ($newProduct->color) {
            $parts[] = "– {$newProduct->color}";
        }
        
        // Apply title case to parts (without size)
        $name = '';
        if (!empty($parts)) {
            $name = ucwords(strtolower(implode(' ', $parts)));
        }
        
        // Add size without case transformation to preserve GG, PP, etc.
        if ($newProduct->size) {
            $name .= ($name ? ' ' : '') . "Tamanho {$newProduct->size}";
        }
        
        if ($name) {
            $newProduct->name = $name;
            $newProduct->slug = \Illuminate\Support\Str::slug($newProduct->name);
            
            // Check for slug uniqueness
            if (Product::where('slug', $newProduct->slug)->exists()) {
                $newProduct->slug .= '-' . uniqid();
            }
        }
        
        // Generate new SKU
        $category = $this->originalProduct->category->name ?? null;
        $type = $newProduct->product_type_id 
            ? \App\Models\ProductType::find($newProduct->product_type_id)?->name 
            : null;
        
        if ($category && $type) {
            $skuService = app(SkuGeneratorService::class);
            
            $newProduct->sku = $skuService->generate(
                $category,
                $type,
                $newProduct->color ?: 'STD',
                $newProduct->size ?: 'U'
            );
        } else {
            $newProduct->sku = null;
        }

        $newProduct->save();
        
        $this->showModal = false;
        
        // Redirect to edit the newly created product
        session()->flash('success', 'Produto duplicado com sucesso! SKU: ' . ($newProduct->sku ?? 'N/A'));
        
        return redirect()->route('admin.products.edit', $newProduct->id);
    }


    public function closeModal()
    {
        $this->showModal = false;
        $this->errorMessage = '';
        $this->dispatch('modalClosed');
    }

    public function render()
    {
        return view('livewire.admin.product-duplicate-modal');
    }
}
