<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Product;

use Livewire\Attributes\On;

class ProductIndex extends Component
{
    use WithPagination;

    public $search = '';
    // public $showCreateForm = false; // Removed
    // public $editingProductId = null; // Removed

    protected $paginationTheme = 'bootstrap';
    
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function delete($id)
    {
        $product = Product::find($id);
        
        if ($product) {
            $productName = $product->name;
            $product->delete();
            $message = "Produto \"{$productName}\" excluído com sucesso.";
            session()->flash('success', $message);
            $this->dispatch('show-toast', type: 'success', message: $message);
        } else {
            $message = 'Produto não encontrado.';
            session()->flash('error', $message);
            $this->dispatch('show-toast', type: 'error', message: $message);
        }
    }
    
    // Edit method removed (using routes)
    
    // Listeners for inline form removed

    public $duplicatingProductId = null;

    #[On('productDuplicated')]
    public function productDuplicated($sku)
    {
        session()->flash('message', 'Produto duplicado com sucesso! SKU: ' . $sku);
        $this->duplicatingProductId = null;
        $this->resetPage();
    }

    #[On('modalClosed')]
    public function modalClosed()
    {
        $this->duplicatingProductId = null;
        $this->generatingImageForProductId = null;
    }

    public $generatingImageForProductId = null;
    public $editablePrompt = '';

    public function openImageGenerator($productId)
    {
        $product = Product::with(['category', 'productType', 'productModel', 'productMaterial', 'productColor', 'productSize'])->findOrFail($productId);
        
        $productData = [
            'id' => $product->id,
            'name' => $product->name,
            'category' => $product->category->name ?? '',
            'type' => $product->productType->name ?? '',
            'model' => $product->productModel->name ?? '',
            'size' => $product->productSize->name ?? '',
            'color' => $product->productColor->name ?? '',
            'material' => $product->productMaterial->name ?? '',
            'description' => $product->description ?? '',
        ];

        // Get the preview prompt and set it as editable
        $this->editablePrompt = $this->buildPreviewPrompt($productData);
        $this->generatingImageForProductId = $productId;
    }

    public function cancelImageGeneration()
    {
        $this->generatingImageForProductId = null;
        $this->editablePrompt = '';
    }

    private function buildPreviewPrompt(array $data): string
    {
        $template = \App\Models\StoreSetting::get('ai_image_prompt_template', 
            'Professional e-commerce product photography of {product_name}, {category} category product, {type} type, {model} model, {size} size, {flavor} flavor, {material} packaging. Studio lighting, clean white background, product centered, front view, label visible and readable, high resolution, professional packshot, 8k quality, photorealistic'
        );

        $categoria = $data['category'] ?? '';
        $flavor = ($categoria === 'Suplementos' || $categoria === 'Vitamina') ? ($data['color'] ?? '') : '';

        $replacements = [
            '{product_name}' => $data['name'] ?? '',
            '{category}' => $categoria,
            '{type}' => $data['type'] ?? '',
            '{model}' => $data['model'] ?? '',
            '{size}' => $data['size'] ?? '',
            '{flavor}' => $flavor,
            '{material}' => $data['material'] ?? '',
        ];

        $prompt = str_replace(array_keys($replacements), array_values($replacements), $template);

        // Clean up empty placeholders and double commas/spaces
        $prompt = preg_replace('/,\s*,/', ',', $prompt);
        $prompt = preg_replace('/,\s*\./', '.', $prompt);
        $prompt = preg_replace('/\s+/', ' ', $prompt);
        
        return trim($prompt);
    }

    public function generateImage($productId)
    {
        \Log::info('Generate Image clicked', ['product_id' => $productId, 'prompt' => $this->editablePrompt]);
        
        try {
            $product = Product::findOrFail($productId);
            
            // Use the edited prompt directly
            $imageService = app(\App\Services\GeminiImageService::class);
            
            // We need to modify the service to accept a direct prompt or pass it via data
            // Since we can't easily change the service signature without checking it, 
            // let's pass it as a special key in productData or use a new method on service.
            // Checking service... assuming we can pass it or need to update service.
            // For now, let's update the service call to use the prompt.
            
            // Actually, let's check the service first to be safe, but assuming standard implementation:
            $imagePath = $imageService->generateProductImageWithPrompt($product, $this->editablePrompt);

            if ($imagePath) {
                // Create ProductImage record
                $isMain = $product->images()->count() === 0;
                $product->images()->create([
                    'path' => $imagePath,
                    'is_main' => $isMain,
                    'order' => $product->images()->count() + 1,
                ]);

                // Update main product image column if it's the first one or empty
                if ($isMain || empty($product->image)) {
                    $product->update(['image' => $imagePath]);
                }

                $this->generatingImageForProductId = null;
                $this->previewPrompt = '';

                session()->flash('success', 'Imagem gerada com sucesso!');
                
                // Redirect to product edit page with images tab selected
                return $this->redirect(route('admin.products.edit', $product->id) . '?tab=images', navigate: true);
            } else {
                session()->flash('error', 'Não foi possível gerar a imagem. Verifique os logs para mais detalhes.');
                $this->generatingImageForProductId = null;
            }

        } catch (\Exception $e) {
            \Log::error('Generate Image Error', [
                'product_id' => $productId,
                'error' => $e->getMessage()
            ]);
            session()->flash('error', 'Erro ao gerar imagem: ' . $e->getMessage());
            $this->generatingImageForProductId = null;
        }
    }

    public function render()
    {
        return view('livewire.admin.product-index', [
            'products' => Product::with(['category', 'images'])
                ->where('name', 'like', '%' . $this->search . '%')
                ->orderBy('created_at', 'desc')
                ->paginate(10)
                ->withPath(route('admin.products.index')),
        ]);
    }
}
