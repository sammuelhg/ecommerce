<?php

namespace App\Livewire\Admin;

use App\Models\Product;
use App\Models\Category;
use App\Models\ProductType;
use App\Models\ProductModel;
use App\Models\ProductMaterial;
use App\Services\SkuGeneratorService;
use Livewire\Component;
use Livewire\WithFileUploads;

class ProductForm extends Component
{
    use WithFileUploads;
    use ProductKitTrait; // módulo de kits separado

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
    public $is_featured = false;
    public $is_offer = false;
    public $images = []; // For new uploads
    public $existingImages = []; // For displaying existing gallery
    public $activeTab = 'general'; // Control active tab state
    
    // Attribute fields for title generation
    public $product_type_id = '';
    public $product_model_id = '';
    public $product_material_id = '';
    public $color = '';
    public $attribute = '';
    public $size = '';



    // Media Library - Removed (Global Component)


    // public $activeTab = 'general'; // Removed: Using Bootstrap native tabs

    public $isEditing = false;

    public function rules()
    {
        return [
            'name' => 'required|min:3',
            'slug' => 'required|unique:products,slug,' . $this->productId,
            'sku' => 'nullable|unique:products,sku,' . $this->productId,
            'description' => 'nullable',
            'marketing_description' => 'nullable|string|max:500',
            'price' => 'required|numeric|min:0',
            'cost_price' => 'nullable|numeric|min:0',
            'compare_at_price' => 'nullable|numeric|min:0',
            'stock' => 'nullable|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'is_offer' => 'boolean',
            'images.*' => 'file|mimes:jpeg,jpg,png,gif,webp|max:20480',
            'product_type_id' => 'nullable|exists:product_types,id',
            'product_model_id' => 'nullable|exists:product_models,id',
            'product_material_id' => 'nullable|exists:product_materials,id',
            'color' => 'nullable|string|max:50',
            'size' => 'nullable|string|max:20',
        ];
    }

    public function mount(Product $product = null)
    {
        $this->activeTab = 'general';

        \Log::info('ProductForm mount called', [
            'product_passed' => $product ? 'yes' : 'no',
            'product_id' => $product ? $product->id : 'null',
            'product_exists' => $product && $product->exists ? 'yes' : 'no'
        ]);
        
        if ($product && $product->exists) {
            $this->isEditing = true;
            $this->productId = $product->id;
            \Log::info('Loading product', ['id' => $this->productId]);
            $this->loadProduct();
        } else {
            \Log::info('No product to load - creating new');
        }
        
        // Load media library - Removed

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
        $this->is_active = (bool) $product->is_active;
        $this->is_featured = (bool) $product->is_featured; // Added
        $this->is_offer = (bool) $product->is_offer; // Added
        
        // Attributes
        $this->product_type_id = $product->product_type_id;
        $this->product_model_id = $product->product_model_id;
        $this->product_material_id = $product->product_material_id;
        $this->color = $product->color;
        $this->size = $product->size;
        $this->attribute = $product->attribute;

        // Load existing images
        $this->existingImages = $product->images()->orderBy('is_main', 'desc')->get();
        \Log::info('ProductForm: Loaded images', ['count' => $this->existingImages->count(), 'images' => $this->existingImages->toArray()]);
        
        // Check if kit
        $this->checkIfKit();
        if ($this->isKit) {
            $this->bundleItems = $product->bundleItems->map(function($item) {
                return [
                    'product_id' => $item->id,
                    'name' => $item->name,
                    'quantity' => $item->pivot->quantity,
                    'price' => $item->price
                ];
            })->toArray();
        }
    }

    public function updatedName()
    {
        $this->generateSlug();
    }

    public function updated($property, $value)
    {
        // Auto-generate title and SKU when relevant attributes change
        if (in_array($property, [
            'product_type_id',
            'product_model_id',
            'product_material_id',
            'color',
            'size',
            'attribute'
        ])) {
            $this->generateTitle();
            $this->generateSku();
        }
        
        // Generate SKU when category changes
        if ($property === 'category_id') {
            $this->generateSku();
        }
        
        // Check if product is a kit when type changes
        if ($property === 'product_type_id') {
            $this->checkIfKit();
        }
        
        // Search products for kit bundle
        if ($property === 'productSearch') {
            $this->searchProducts();
        }
    }

    public function generateTitle()
    {
        $this->name = app(\App\Services\ProductTitleService::class)->generateTitle(
            $this->product_type_id,
            $this->product_model_id,
            $this->product_material_id,
            $this->attribute,
            $this->color,
            $this->size
        );

        $this->generateSlug();
        $this->generateSku();
    }

    public function generateSlug()
    {
        if ($this->name) {
            $this->slug = \Str::slug($this->name);
        }
    }

    public function generateSku()
    {
        \Log::info('generateSku called', [
            'category_id' => $this->category_id,
            'product_type_id' => $this->product_type_id,
            'color' => $this->color,
            'size' => $this->size,
        ]);
        
        // Only generate if we have the minimum required fields
        if (!$this->category_id || !$this->product_type_id) {
            $this->sku = '';
            \Log::warning('SKU not generated - missing category or type');
            return;
        }

        $category = Category::find($this->category_id);
        $type = ProductType::find($this->product_type_id);

        if (!$category || !$type) {
            $this->sku = '';
            \Log::warning('SKU not generated - category or type not found in DB');
            return;
        }

        $this->sku = app(\App\Services\SkuGeneratorService::class)->generate(
            $category->name,
            $type->name,
            $this->color ?: 'STD', // Standard if no color
            $this->size ?: 'U',  // Universal if no size
            $this->productId  // Exclude current product ID when editing
        );
        
        \Log::info('SKU generated', ['sku' => $this->sku]);
    }

    public function save()
    {
        \Log::info('ProductForm: Save method called');

        // Convert empty strings to null for optional fields
        $this->product_material_id = $this->product_material_id ?: null;
        $this->product_model_id = $this->product_model_id ?: null;
        $this->product_type_id = $this->product_type_id ?: null;
        // Default stock to 1 if not provided
        $this->stock = ($this->stock === '' || $this->stock === null) ? 1 : $this->stock;

        // Sanitize prices
        $this->price = $this->sanitizePrice($this->price);
        $this->cost_price = $this->sanitizePrice($this->cost_price);
        $this->compare_at_price = $this->sanitizePrice($this->compare_at_price);

        try {
            $this->validate();
            \Log::info('ProductForm: Validation passed');
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('ProductForm: Validation failed', ['errors' => $e->validator->errors()->toArray()]);
            
            // Dispatch event for frontend to handle tab switching
            $errors = $e->validator->errors();
            $targetTab = 'general'; // Default

            if ($errors->has('name') || $errors->has('category_id') || $errors->has('product_type_id')) {
                $targetTab = 'general';
            } elseif ($errors->has('price') || $errors->has('stock')) {
                $targetTab = 'pricing';
            } elseif ($errors->has('images') || $errors->has('images.*')) {
                $targetTab = 'images';
            }
            
            $this->activeTab = $targetTab;
            
            // Dispatch event for toast notification
            $this->dispatch('show-validation-toast', ['errors' => $e->validator->errors()->toArray()]);
            
            // Re-throw to let Livewire handle the error bag
            throw $e;
        }

        try {
            \DB::beginTransaction();

            $data = [
                'name' => $this->name,
                'slug' => $this->slug ?: \Str::slug($this->name),
                'description' => $this->description,
                'marketing_description' => $this->marketing_description,
                'price' => $this->price,
                // 'old_price' => $this->old_price, // Removed: Property does not exist
                'cost_price' => $this->cost_price,
                'compare_at_price' => $this->compare_at_price,
                'stock' => $this->stock,
                'category_id' => $this->category_id,
                'product_type_id' => $this->product_type_id,
                'product_model_id' => $this->product_model_id,
                'product_material_id' => $this->product_material_id,
                'color' => $this->color,
                'size' => $this->size,
                'attribute' => $this->attribute,
                'sku' => $this->sku,
                'is_active' => $this->is_active,
                'is_featured' => $this->is_featured,
                'is_offer' => $this->is_offer,
            ];

            if ($this->productId) {
                $product = Product::find($this->productId);
                $product->update($data);
            } else {
                $product = Product::create($data);
                $this->productId = $product->id;
                $this->isEditing = true;
            }

            // Handle Bundle Items (Kit)
            if ($this->isKit) {
                $product->bundleItems()->detach();
                foreach ($this->bundleItems as $item) {
                    $product->bundleItems()->attach($item['product_id'], ['quantity' => $item['quantity']]);
                }
            }
            
            // Handle Images via Service
            $imagesToUpload = [];
            
            // 1. Process standard Livewire uploads
            if (!empty($this->images)) {
                $imagesToUpload = array_merge($imagesToUpload, $this->images);
            }
            
            // 2. Process temp images (from library/crop)
            if (!empty($this->tempImages)) {
                foreach ($this->tempImages as $tempPath) {
                    if (\Storage::disk('public')->exists($tempPath)) {
                        $absolutePath = storage_path('app/public/' . $tempPath);
                        $mime = \Storage::disk('public')->mimeType($tempPath);
                        
                        $file = new \Illuminate\Http\UploadedFile(
                            $absolutePath,
                            basename($tempPath),
                            $mime,
                            null,
                            true
                        );
                        $imagesToUpload[] = $file;
                    }
                }
            }

            if (!empty($imagesToUpload)) {
                app(\App\Services\ProductImageService::class)->handleUploads($product, $imagesToUpload, $this->newMainImageIndex);
                
                // Cleanup temp images
                foreach ($this->tempImages as $tempPath) {
                    if (\Storage::disk('public')->exists($tempPath)) {
                        \Storage::disk('public')->delete($tempPath);
                    }
                }
                
                $this->images = []; // Clear input
                $this->tempImages = []; // Clear temp paths
                $this->newMainImageIndex = null;
            }

            \DB::commit();

            session()->flash('message', 'Produto salvo com sucesso!');
            
            return redirect()->route('admin.products.index');

        } catch (\Exception $e) {
            \DB::rollBack();
            // Log error and show message
            session()->flash('error', 'Erro ao salvar produto: ' . $e->getMessage());
            \Log::error('Erro ao salvar produto: ' . $e->getMessage());
        }
    }

    public function refreshImages()
    {
        if ($this->productId) {
            $product = Product::find($this->productId);
            if ($product) {
                $this->existingImages = $product->images()->orderBy('is_main', 'desc')->get();
            }
        }
    }

    public function deleteImage($imageId)
    {
        $success = app(\App\Services\ProductImageService::class)->deleteImage($imageId, $this->productId);
        
        if ($success) {
            $this->refreshImages(); // Only reload images
            $this->dispatch('switch-tab', 'images');
        }
    }

    public function setMainImage($imageId)
    {
        $success = app(\App\Services\ProductImageService::class)->setMainImage($imageId, $this->productId);
        
        if ($success) {
            $this->refreshImages();
        }
    }

    public $newMainImageIndex = null;

    public $tempImages = []; // Stores paths relative to storage/app/public/temp

    #[\Livewire\Attributes\On('handle-library-image')]
    public function addFromLibrary($paths)
    {
        if (empty($paths)) return;

        // Ensure paths is an array
        if (is_string($paths)) {
            $paths = [$paths];
        }

        // Ensure temp directory exists
        if (!\Storage::disk('public')->exists('temp')) {
            \Storage::disk('public')->makeDirectory('temp');
        }

        foreach ($paths as $path) {
            // Check if file exists in storage
            if (!\Storage::disk('public')->exists($path)) {
                continue;
            }

            // Get file content
            $content = \Storage::disk('public')->get($path);
            $extension = pathinfo($path, PATHINFO_EXTENSION);
            
            // Create temp file in PUBLIC storage
            $newFilename = 'temp/' . uniqid() . '.' . $extension;
            \Storage::disk('public')->put($newFilename, $content);
            
            // Store relative path
            $this->tempImages[] = $newFilename;
        }

        $this->dispatch('switch-tab', 'images');
        session()->flash('success', count($paths) . ' imagem(ns) adicionada(s) à lista de upload.');
    }

    public function setNewMainImage($index)
    {
        if (isset($this->tempImages[$index])) {
            $this->newMainImageIndex = $index;
        }
    }

    public function removeTempImage($index)
    {
        if (isset($this->tempImages[$index])) {
            // Optional: Clean up temp file
            $path = $this->tempImages[$index];
            if (\Storage::disk('public')->exists($path)) {
                \Storage::disk('public')->delete($path);
            }

            unset($this->tempImages[$index]);
            $this->tempImages = array_values($this->tempImages); // Re-index array
            
            // Reset main image index if needed
            if ($this->newMainImageIndex === $index) {
                $this->newMainImageIndex = null;
            } elseif ($this->newMainImageIndex > $index) {
                $this->newMainImageIndex--;
            }
        }
    }

    public function updateCroppedImage($index, $base64Data)
    {
        if (!isset($this->tempImages[$index])) return;

        // Decode base64
        $image_parts = explode(";base64,", $base64Data);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);

        // Ensure temp directory exists
        if (!\Storage::disk('public')->exists('temp')) {
            \Storage::disk('public')->makeDirectory('temp');
        }

        // Create temp file in PUBLIC storage
        $newFilename = 'temp/' . uniqid() . '.' . $image_type;
        \Storage::disk('public')->put($newFilename, $image_base64);
        
        // Remove old temp file
        $oldPath = $this->tempImages[$index];
        if (\Storage::disk('public')->exists($oldPath)) {
            \Storage::disk('public')->delete($oldPath);
        }

        // Update path in array
        $this->tempImages[$index] = $newFilename;
        
        $this->dispatch('image-cropped-success');
    }

    public function cropLivewireUpload($index, $base64Data)
    {
        if (!isset($this->images[$index])) return;

        // Decode base64
        $image_parts = explode(";base64,", $base64Data);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);

        // Ensure temp directory exists
        if (!\Storage::disk('public')->exists('temp')) {
            \Storage::disk('public')->makeDirectory('temp');
        }

        // Create temp file in PUBLIC storage
        $newFilename = 'temp/' . uniqid() . '.' . $image_type;
        \Storage::disk('public')->put($newFilename, $image_base64);
        
        // Move from Livewire uploads to tempImages
        unset($this->images[$index]);
        $this->images = array_values($this->images); // Re-index
        
        // Add to tempImages
        $this->tempImages[] = $newFilename;
        
        $this->dispatch('image-cropped-success');
    }

    public function getTempUrl($index)
    {
        if (!isset($this->tempImages[$index])) return '';
        
        $path = $this->tempImages[$index];
        
        // If it's a Livewire TemporaryUploadedFile (not used in this flow anymore but good for safety)
        if (is_object($path) && method_exists($path, 'temporaryUrl')) {
            return $path->temporaryUrl();
        }
        
        // It's a string path relative to public disk
        return asset('storage/' . $path);
    }

    protected function sanitizePrice($value)
    {
        if (empty($value)) return null;
        if (is_numeric($value)) return $value;
        return str_replace(',', '.', str_replace('.', '', $value));
    }

    public function render()
    {
        $types = ProductType::where('is_active', true)->get();
        $models = ProductModel::where('is_active', true)->get();
        $materials = ProductMaterial::where('is_active', true)->get();

        // Carregar categorias para o select (hierarquia simples para visualização)
        $categories = Category::with('parent')->get()->map(function($category) {
            $name = $category->name;
            if ($category->parent) {
                $name = $category->parent->name . ' > ' . $name;
            }
            return [
                'id' => $category->id,
                'name' => $name
            ];
        })->sortBy('name');

        return view('livewire.admin.product-form', [
            'categories' => $categories,
            'types' => $types,
            'models' => $models,
            'materials' => $materials,
        ])->layout('layouts.admin');
    }
}
