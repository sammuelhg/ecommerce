<?php

namespace App\Livewire\Admin;

use App\Models\Product;
use App\Models\Category;
use App\Models\ProductType;
use App\Models\ProductModel;
use App\Models\ProductMaterial;
use App\Services\MediaService;
use App\Services\SkuGeneratorService;
use Livewire\Component;
use Livewire\WithFileUploads;

class ProductForm extends Component
{
    use WithFileUploads;

    public $productId;
    public $name = '';
    public $slug = '';
    public $sku = '';
    public $description = '';
    public $marketing_description = '';
    public $price = '';
    public $cost_price = '';
    public $compare_at_price = '';
    public $stock = '';
    public $category_id = '';
    public $is_active = true;
    public $images = []; // For new uploads
    public $existingImages = []; // For displaying existing gallery
    
    // Attribute fields for title generation
    public $product_type_id = '';
    public $product_model_id = '';
    public $product_material_id = '';
    public $color = '';
    public $attribute = '';
    public $size = '';

    // Bundle/Kit specific properties
    public $isKit = false;
    public $bundleItems = []; // Array of ['product_id', 'name', 'quantity']
    public $productSearch = '';
    public $searchResults = [];

    // Media Library
    public $mediaLibrary = [];
    public $librarySearch = '';

    public $activeTab = 'general'; // Default tab

    public $isEditing = false;

    protected $rules = [
        'name' => 'required|min:3',
        'slug' => 'required|unique:products,slug',
        'sku' => 'nullable|unique:products,sku',
        'description' => 'nullable',
        'marketing_description' => 'nullable|string|max:500',
        'price' => 'required|numeric|min:0',
        'cost_price' => 'nullable|numeric|min:0',
        'compare_at_price' => 'nullable|numeric|min:0|gt:price',
        'stock' => 'required|integer|min:0',
        'category_id' => 'required|exists:categories,id',
        'is_active' => 'boolean',
        'images.*' => 'file|mimes:jpeg,jpg,png,gif,webp|max:20480', // 20MB per image
        'product_type_id' => 'nullable|exists:product_types,id',
        'product_model_id' => 'nullable|exists:product_models,id',
        'product_material_id' => 'nullable|exists:product_materials,id',
        'color' => 'nullable|string|max:50',
        'size' => 'nullable|string|max:20',
    ];

    public function mount($productId = null)
    {
        if ($productId) {
            $this->isEditing = true;
            $this->productId = $productId;
            $this->loadProduct();
        }
        
        // Load media library
        $this->loadMediaLibrary();
    }

    public function loadProduct()
    {
        $product = Product::with('productType', 'bundleItems')->findOrFail($this->productId);
        $this->name = $product->name;
        $this->slug = $product->slug;
        $this->sku = $product->sku;
        $this->description = $product->description;
        $this->marketing_description = $product->marketing_description;
        $this->price = $product->price;
        $this->cost_price = $product->cost_price;
        $this->compare_at_price = $product->compare_at_price;
        $this->stock = $product->stock;
        $this->category_id = $product->category_id;
        $this->is_active = $product->is_active;
        $this->product_type_id = $product->product_type_id;
        $this->product_model_id = $product->product_model_id;
        $this->product_material_id = $product->product_material_id;
        $this->color = $product->color;
        $this->attribute = $product->attribute;
        $this->size = $product->size;

        // Load existing images
        $this->existingImages = $product->images;

        // Load bundle items if it's a kit
        if ($product->isKit()) {
            $this->isKit = true;
            $this->bundleItems = $product->bundleItems->map(function($item) {
                return [
                    'product_id' => $item->id,
                    'name' => $item->name,
                    'quantity' => $item->pivot->quantity,
                    'price' => $item->price, // Optional: for reference
                ];
            })->toArray();
        }
    }

    public function updatedName()
    {
        $this->slug = \Str::slug($this->name);
    }

    /**
     * Auto-generate title and SKU when attributes change
     */
    public function updated($propertyName)
    {
        if (in_array($propertyName, ['category_id', 'product_type_id', 'product_model_id', 'product_material_id', 'color', 'size', 'attribute'])) {
            $this->generateTitle();
            $this->generateSku();
        }

        if ($propertyName === 'product_type_id') {
            $this->checkIfKit();
        }

        if ($propertyName === 'productSearch') {
            $this->searchProducts();
        }

        if ($propertyName === 'librarySearch') {
            $this->loadMediaLibrary();
        }
    }

    public function checkIfKit()
    {
        if ($this->product_type_id) {
            $type = ProductType::find($this->product_type_id);
            $this->isKit = ($type && $type->code === 'KIT');
        } else {
            $this->isKit = false;
        }
    }

    public function searchProducts()
    {
        if (strlen($this->productSearch) < 2) {
            $this->searchResults = [];
            return;
        }

        $this->searchResults = Product::where('name', 'like', '%' . $this->productSearch . '%')
            ->where('id', '!=', $this->productId) // Exclude self
            ->where('is_active', true)
            ->limit(10)
            ->get(['id', 'name', 'price']);
    }

    public function addToBundle($productId, $productName, $productPrice)
    {
        // Check if already in bundle
        foreach ($this->bundleItems as $item) {
            if ($item['product_id'] == $productId) {
                return; // Already added
            }
        }

        $this->bundleItems[] = [
            'product_id' => $productId,
            'name' => $productName,
            'quantity' => 1,
            'price' => $productPrice
        ];

        $this->productSearch = '';
        $this->searchResults = [];
    }

    public function removeFromBundle($index)
    {
        unset($this->bundleItems[$index]);
        $this->bundleItems = array_values($this->bundleItems); // Re-index
    }

    public function updateBundleQuantity($index, $qty)
    {
        if (isset($this->bundleItems[$index])) {
            $this->bundleItems[$index]['quantity'] = max(1, intval($qty));
        }
    }

    public function generateTitle()
    {
        $parts = [];

        if ($this->product_type_id) {
            $type = ProductType::find($this->product_type_id);
            if ($type) $parts[] = $type->name;
        }

        if ($this->product_model_id) {
            $model = ProductModel::find($this->product_model_id);
            if ($model) $parts[] = $model->name;
        }

        if ($this->product_material_id) {
            $material = ProductMaterial::find($this->product_material_id);
            if ($material) $parts[] = "em {$material->name}";
        }

        if ($this->attribute) {
            $parts[] = $this->attribute;
        }

        if ($this->color) {
            $parts[] = "– {$this->color}";
        }

        if ($this->size) {
            $parts[] = "Tamanho {$this->size}";
        }

        if (!empty($parts)) {
            // Capitalize each word (Title Case)
            $this->name = ucwords(strtolower(implode(' ', $parts)));
            $this->slug = \Str::slug($this->name);
        }
    }

    public function generateSku()
    {
        // Only generate if we have the minimum required fields
        if (!$this->category_id || !$this->product_type_id) {
            $this->sku = '';
            return;
        }

        $category = Category::find($this->category_id);
        $type = ProductType::find($this->product_type_id);

        if (!$category || !$type) {
            $this->sku = '';
            return;
        }

        $skuGenerator = new SkuGeneratorService();
        
        $this->sku = $skuGenerator->generate(
            $category->name,
            $type->name,
            $this->color ?: 'STD', // Standard if no color
            $this->size ?: 'U',  // Universal if no size
            $this->productId  // Exclude current product ID when editing
        );
    }

    public function save(MediaService $mediaService)
    {
        // Ajustar validação do slug para edição
        $rules = $this->rules;
        if ($this->isEditing) {
            $rules['slug'] = 'required|unique:products,slug,' . $this->productId;
            $rules['sku'] = 'nullable|unique:products,sku,' . $this->productId;
        }
        
        $this->validate($rules);

        $data = [
            'name' => $this->name,
            'slug' => $this->slug,
            'sku' => $this->sku ?: null, // Convert empty string to null
            'description' => $this->description,
            'marketing_description' => $this->marketing_description,
            'price' => $this->price,
            'cost_price' => $this->cost_price ?: null,
            'compare_at_price' => $this->compare_at_price ?: null,
            'stock' => $this->stock,
            'category_id' => $this->category_id,
            'is_active' => $this->is_active,
            // Persist attributes
            'product_type_id' => $this->product_type_id ?: null,
            'product_model_id' => $this->product_model_id ?: null,
            'product_material_id' => $this->product_material_id ?: null,
            'color' => $this->color ?: null,
            'attribute' => $this->attribute ?: null,
            'size' => $this->size ?: null,
        ];

        if ($this->isEditing) {
            $product = Product::find($this->productId);
            $product->update($data);
            
            // Sync bundle items
            if ($this->isKit) {
                $syncData = [];
                foreach ($this->bundleItems as $item) {
                    $syncData[$item['product_id']] = ['quantity' => $item['quantity']];
                }
                $product->bundleItems()->sync($syncData);
            } else {
                $product->bundleItems()->detach();
            }

            session()->flash('message', 'Produto atualizado com sucesso!');
        } else {
            $product = Product::create($data);
            
            // Sync bundle items
            if ($this->isKit && !empty($this->bundleItems)) {
                $syncData = [];
                foreach ($this->bundleItems as $item) {
                    $syncData[$item['product_id']] = ['quantity' => $item['quantity']];
                }
                $product->bundleItems()->sync($syncData);
            }

            session()->flash('message', 'Produto criado com sucesso!');
        }

        // Handle multiple images
        if (!empty($this->images)) {
            foreach ($this->images as $img) {
                $path = $mediaService->uploadImage($img, 'products');
                
                // If product has no main image, set this one
                if (!$product->image) {
                    $product->update(['image' => $path]);
                }
                
                // Add to gallery
                $product->images()->create([
                    'path' => $path,
                    'is_main' => ($product->image === $path)
                ]);
            }
        }

        $this->dispatch('productSaved');
        $this->reset();
    }

    public function deleteImage($imageId)
    {
        $image = \App\Models\ProductImage::find($imageId);
        if ($image) {
            // If it's the main image, clear it from product
            if ($image->is_main) {
                $product = Product::find($this->productId);
                $product->update(['image' => null]);
                
                // Try to set another image as main
                $nextImage = $product->images()->where('id', '!=', $imageId)->first();
                if ($nextImage) {
                    $product->update(['image' => $nextImage->path]);
                    $nextImage->update(['is_main' => true]);
                }
            }
            
            // Delete file (optional, usually good practice)
            // \Storage::disk('public')->delete($image->path);
            
            $image->delete();
            $this->loadProduct(); // Reload to update UI
        }
    }

    public function setMainImage($imageId)
    {
        $image = \App\Models\ProductImage::find($imageId);
        if ($image) {
            $product = Product::find($this->productId);
            
            // Unset current main
            $product->images()->update(['is_main' => false]);
            
            // Set new main
            $image->update(['is_main' => true]);
            $product->update(['image' => $image->path]);
            
            $this->loadProduct();
        }
    }

    public function loadMediaLibrary()
    {
        try {
            $query = \App\Models\ProductImage::query();

            if ($this->librarySearch) {
                $query->where('path', 'like', '%' . $this->librarySearch . '%');
            }

            // Get unique images (distinct by path)
            $this->mediaLibrary = $query->select('id', 'path', 'created_at')
                ->distinct()
                ->orderBy('created_at', 'desc')
                ->limit(50)
                ->get();
                
            \Log::info('Media library loaded', ['count' => count($this->mediaLibrary)]);
        } catch (\Exception $e) {
            \Log::error('Failed to load media library', ['error' => $e->getMessage()]);
            $this->mediaLibrary = collect();
        }
    }

    public function selectFromLibrary($path)
    {
        // This would need a different approach since wire:model for files
        // doesn't support programmatic selection
        session()->flash('message', 'Função em desenvolvimento. Use upload do dispositivo.');
    }

    public function render()
    {
        $categories = Category::with('parent')->get()->map(function($category) {
            if ($category->parent) {
                $category->display_name = $category->parent->name . ' > ' . $category->name;
            } else {
                $category->display_name = $category->name;
            }
            return $category;
        })->sortBy('display_name');

        $types = ProductType::all();
        $models = ProductModel::all();
        $materials = ProductMaterial::all();

        return view('livewire.admin.product-form', [
            'categories' => $categories,
            'types' => $types,
            'models' => $models,
            'materials' => $materials,
        ]);
    }
}
