<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Product;
use App\Services\SkuGeneratorService;

class ProductDuplicateModal extends Component
{
    public $showModal = false;
    public $originalProductId;
    public $originalProduct;
    
    public $newAttribute = '';
    public $newColor = '';
    public $newSize = '';
    
    public $errorMessage = '';

    public function mount($productId = null)
    {
        if ($productId) {
            $this->originalProductId = $productId;
            $this->originalProduct = Product::findOrFail($productId);
            
            // Pré-preencher com valores atuais
            $this->newAttribute = $this->originalProduct->attribute ?? '';
            $this->newColor = $this->originalProduct->color ?? '';
            $this->newSize = $this->originalProduct->size ?? '';
            
            $this->errorMessage = '';
            $this->showModal = true;
        }
    }

    public function duplicate()
    {
        // Validar se há diferença
        if ($this->newAttribute === ($this->originalProduct->attribute ?? '') &&
            $this->newColor === ($this->originalProduct->color ?? '') &&
            $this->newSize === ($this->originalProduct->size ?? '')) {
            
            $this->errorMessage = 'Você precisa alterar pelo menos um campo (Atributo, Cor ou Tamanho) para criar um novo produto.';
            return;
        }

        // Create a copy
        $newProduct = $this->originalProduct->replicate();
        
        // Update fields
        $newProduct->attribute = $this->newAttribute ?: null;
        $newProduct->color = $this->newColor ?: null;
        $newProduct->size = $this->newSize ?: null;
        
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
        
        if ($newProduct->size) {
            $parts[] = "Tamanho {$newProduct->size}";
        }
        
        if (!empty($parts)) {
            $newProduct->name = ucwords(strtolower(implode(' ', $parts)));
            $newProduct->slug = \Illuminate\Support\Str::slug($newProduct->name);
            
            // Check for slug uniqueness
            if (Product::where('slug', $newProduct->slug)->exists()) {
                $newProduct->slug .= '-' . uniqid();
            }
        }
        
        // Generate new SKU
        if ($newProduct->product_type_id && $newProduct->color && $newProduct->size) {
            $skuService = app(SkuGeneratorService::class);
            $category = $this->originalProduct->category->name ?? 'produto';
            $type = \App\Models\ProductType::find($newProduct->product_type_id)?->name ?? 'item';
            
            $newProduct->sku = $skuService->generate(
                $category,
                $type,
                $newProduct->color,
                $newProduct->size
            );
        } else {
            $newProduct->sku = null;
        }
        
        $newProduct->save();
        
        $this->showModal = false;
        $this->dispatch('productDuplicated', sku: $newProduct->sku ?? 'N/A');
        $this->dispatch('$refresh');
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
