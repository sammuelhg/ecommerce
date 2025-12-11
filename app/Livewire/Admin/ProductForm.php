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
    use \Livewire\WithPagination;
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
    public $product_color_id = '';
    public $product_flavor_id = ''; // New flavor property
    public $variant_type = 'color'; // Default variant type
    public $product_size_id = '';
    public $color = ''; // Deprecated, mantido para compatibilidade temporária
    public $attribute = '';
    public $size = ''; // Deprecated, mantido para compatibilidade temporária
    public $card_type = 'product_standard'; // Default card type



    // Media Library - Removed (Global Component)


    // public $activeTab = 'general'; // Removed: Using Bootstrap native tabs

    public $isEditing = false;

    protected $listeners = [
        'image-deleted' => 'refreshImages',
        'main-image-updated' => 'refreshImages',
        'refresh-gallery' => 'refreshImages'
    ];

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
            'compare_at_price' => 'nullable|numeric|min:0|gt:price',
            'stock' => 'nullable|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'is_offer' => 'boolean',
            'images.*' => 'file|mimes:jpeg,jpg,png,gif,webp|max:20480',
            'product_type_id' => 'nullable|exists:product_types,id',
            'product_model_id' => 'nullable|exists:product_models,id',
            'product_material_id' => 'nullable|exists:product_materials,id',
            'product_color_id' => 'nullable|exists:product_colors,id',
            'product_flavor_id' => 'nullable|exists:flavors,id',
            'product_size_id' => 'nullable|exists:product_sizes,id',
            'variant_type' => 'required|in:color,flavor',
        ];
    }

    public function mount(Product $product = null)
    {
        // Check if tab parameter is in URL
        $requestedTab = request()->query('tab');
        $this->activeTab = in_array($requestedTab, ['general', 'images', 'pricing', 'inventory', 'seo', 'kit']) 
            ? $requestedTab 
            : 'general';

        \Log::info('ProductForm mount called', [
            'product_passed' => $product ? 'yes' : 'no',
            'product_id' => $product ? $product->id : 'null',
            'product_exists' => $product && $product->exists ? 'yes' : 'no',
            'requested_tab' => $requestedTab,
            'active_tab' => $this->activeTab
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
        $this->product_material_id = $product->product_material_id;
        $this->product_color_id = $product->product_color_id;
        $this->product_flavor_id = $product->product_flavor_id;
        $this->variant_type = $product->variant_type ?: 'color';
        $this->product_size_id = $product->product_size_id;
        $this->color = $product->color; // Legacy field
        $this->size = $product->size; // Legacy field
        $this->attribute = $product->attribute;
        $this->card_type = $product->card_type ?: 'product_standard';

        // Load existing images
        $this->existingImages = $product->images()->orderBy('is_main', 'desc')->get();
        
        // Migration for legacy image: if gallery is empty but product has main image
        if ($this->existingImages->isEmpty() && $product->image) {
            \App\Models\ProductImage::create([
                'product_id' => $product->id,
                'path' => $product->image,
                'is_main' => true,
                'order' => 0
            ]);
            
            // Reload images
            $this->existingImages = $product->images()->orderBy('is_main', 'desc')->get();
        }

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
            'product_material_id',
            'product_color_id',
            'product_flavor_id',
            'variant_type',
            'product_size_id',
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
        // Get color and size names from IDs
        $colorName = '';
        $sizeName = '';
        
        if ($this->variant_type === 'color') {
            if ($this->product_color_id) {
                $color = \App\Models\ProductColor::find($this->product_color_id);
                $colorName = $color ? $color->name : '';
            } elseif ($this->color) {
                $colorName = $this->color;
            }
        } elseif ($this->variant_type === 'flavor') {
            if ($this->product_flavor_id) {
                $flavor = \App\Models\Flavor::find($this->product_flavor_id);
                // We use colorName variable but fill it with flavor name for title generation
                // ProductTitleService might interpret it as color/variant
                $colorName = $flavor ? $flavor->name : '';
            }
        }
        
        if ($this->product_size_id) {
            $size = \App\Models\ProductSize::find($this->product_size_id);
            $sizeName = $size ? $size->name : '';
        } elseif ($this->size) {
            // Fallback to legacy text field
            $sizeName = $this->size;
        }
        
        $this->name = app(\App\Services\ProductTitleService::class)->generateTitle(
            $this->product_type_id,
            $this->product_model_id,
            $this->product_material_id,
            $this->attribute,
            $colorName,
            $sizeName
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
            'product_color_id' => $this->product_color_id,
            'product_size_id' => $this->product_size_id,
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
        
        // Get variant code (color or flavor)
        $colorCode = 'STD';
        if ($this->variant_type === 'color') {
            if ($this->product_color_id) {
                $color = \App\Models\ProductColor::find($this->product_color_id);
                $colorCode = $color && $color->code ? $color->code : 'STD';
            } elseif ($this->color) {
                $colorCode = $this->color;
            }
        } elseif ($this->variant_type === 'flavor') {
            if ($this->product_flavor_id) {
                $flavor = \App\Models\Flavor::find($this->product_flavor_id);
                // Use slug or name as code for flavor, maybe slug is safer
                $colorCode = $flavor ? strtoupper(substr($flavor->slug, 0, 3)) : 'SAB';
            }
        }
        
        // Get size code
        $sizeCode = 'U';
        if ($this->product_size_id) {
            $size = \App\Models\ProductSize::find($this->product_size_id);
            $sizeCode = $size && $size->code ? $size->code : 'U';
        } elseif ($this->size) {
            $sizeCode = $this->size;
        }

        $this->sku = app(\App\Services\SkuGeneratorService::class)->generate(
            $category->name,
            $type->name,
            $colorCode,
            $sizeCode,
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
        $this->product_color_id = $this->product_color_id ?: null;
        $this->product_flavor_id = $this->product_flavor_id ?: null;
        $this->product_size_id = $this->product_size_id ?: null;
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

            if ($errors->has('name') || $errors->has('category_id') || $errors->has('product_type_id') || $errors->has('product_model_id') || $errors->has('product_material_id') || $errors->has('product_color_id') || $errors->has('product_size_id')) {
                $targetTab = 'general';
            } elseif ($errors->has('price') || $errors->has('stock') || $errors->has('sku') || $errors->has('cost_price') || $errors->has('compare_at_price')) {
                $targetTab = 'pricing';
            } elseif ($errors->has('images') || $errors->has('images.*')) {
                $targetTab = 'images';
            } elseif ($errors->has('slug') || $errors->has('description') || $errors->has('marketing_description')) {
                $targetTab = 'seo';
            }
            
            $this->activeTab = $targetTab;
            
            // Dispatch event for frontend to switch tabs
            $this->dispatch('validation-errors', ['tab' => $targetTab]);

            // Dispatch event for toast notification
            $this->dispatch('show-validation-toast', ['errors' => $e->validator->errors()->toArray()]);
            
            // Re-throw to let Livewire handle the error bag
            throw $e;
        }

        // Sanitize variant type data
        if ($this->variant_type === 'color') {
            $this->product_flavor_id = null;
        } else {
            $this->product_color_id = null;
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
                'product_color_id' => $this->product_color_id,
                'product_flavor_id' => $this->product_flavor_id,
                'variant_type' => $this->variant_type,
                'product_size_id' => $this->product_size_id,
                'color' => $this->color,
                'size' => $this->size,
                'attribute' => $this->attribute,
                'sku' => $this->sku,
                'is_active' => $this->is_active,
                'is_featured' => $this->is_featured,
                'is_offer' => $this->is_offer,
                'card_type' => $this->card_type,
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
            // Directly query to avoid any caching issues
            $this->existingImages = \App\Models\ProductImage::where('product_id', $this->productId)
                ->orderBy('is_main', 'desc') // Main image first
                ->orderBy('created_at', 'desc') // Then newest first
                ->get();
                
            \Log::info('ProductForm: Gallery refreshed', [
                'product_id' => $this->productId,
                'count' => $this->existingImages->count()
            ]);
        }
    }

    public function deleteImage($imageId)
    {
        \Log::info('ProductForm: Deleting image', ['imageId' => $imageId, 'productId' => $this->productId]);
        $success = app(\App\Services\ProductImageService::class)->deleteImage($imageId, $this->productId);
        
        if ($success) {
            \Log::info('ProductForm: Image deleted successfully');
            $this->refreshImages(); // Only reload images
            $this->dispatch('switch-tab', 'images');
        } else {
            \Log::error('ProductForm: Failed to delete image');
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

    public function cropExistingImage($existingImageId, $base64Data)
    {
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
        
        // Add to tempImages
        $this->tempImages[] = $newFilename;
        $newIndex = count($this->tempImages) - 1;

        // Check if original image was main
        $originalImage = \App\Models\ProductImage::find($existingImageId);
        if ($originalImage && $originalImage->is_main) {
            $this->newMainImageIndex = $newIndex;
            session()->flash('success', 'Imagem recortada criada e definida como nova capa.');
        } else {
            session()->flash('success', 'Imagem recortada adicionada como nova imagem.');
        }
        
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
        $colors = \App\Models\ProductColor::where('is_active', true)->get();
        $flavors = \App\Models\Flavor::where('is_active', true)->get();
        $sizes = \App\Models\ProductSize::where('is_active', true)->get();

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

        // Kit Products Pagination
        $kitProducts = null;
        if ($this->isKit) {
            $kitProducts = Product::where('name', 'like', '%' . $this->productSearch . '%')
                ->where('id', '!=', $this->productId)
                ->where('is_active', true)
                ->paginate(5, ['*'], 'kit_page')
                ->withPath(route('admin.products.edit', $this->productId));
        }

        return view('livewire.admin.product-form', [
            'categories' => $categories,
            'types' => $types,
            'models' => $models,
            'materials' => $materials,
            'colors' => $colors,
            'flavors' => $flavors,
            'sizes' => $sizes,
            'kitProducts' => $kitProducts,
        ])->layout('layouts.admin');
    }
}
