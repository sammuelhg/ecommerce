<?php

namespace App\Services;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class ProductImageService
{
    protected $mediaService;

    public function __construct(MediaService $mediaService)
    {
        $this->mediaService = $mediaService;
    }

    /**
     * Handle upload of new images for a product
     */
    public function handleUploads(Product $product, array $images, ?int $mainImageIndex = null)
    {
        if (empty($images)) {
            return;
        }

        foreach ($images as $index => $image) {
            // Accept both standard UploadedFile and Livewire TemporaryUploadedFile
            if (!$image instanceof UploadedFile && !$image instanceof TemporaryUploadedFile) {
                continue;
            }

            // Use MediaService to upload/optimize
            // This handles resizing (max 1200px) and WebP conversion
            $path = $this->mediaService->uploadImage($image, 'products');
            
            // Determine if this image should be main
            // 1. If mainImageIndex is specified and matches current index
            // 2. OR if no mainImageIndex is specified AND it's the first image AND product has no image
            $isMain = false;
            
            if ($mainImageIndex !== null) {
                if ($index === $mainImageIndex) {
                    $isMain = true;
                }
            } elseif (!$product->image && $index === 0) {
                $isMain = true;
            }

            if ($isMain) {
                // Unset any existing main image
                $product->images()->update(['is_main' => false]);
                // Update product main image path
                $product->update(['image' => $path]);
            }
            
            $product->images()->create([
                'path' => $path,
                'is_main' => $isMain
            ]);
        }
    }

    /**
     * Delete an image
     */
    public function deleteImage(int $imageId, int $productId)
    {
        \Log::info('ProductImageService: deleteImage called', [
            'imageId' => $imageId,
            'productId' => $productId
        ]);

        $image = ProductImage::find($imageId);
        
        if (!$image) {
            \Log::warning('ProductImageService: Image not found', ['imageId' => $imageId]);
            return false;
        }

        if ($image->product_id !== $productId) {
            \Log::warning('ProductImageService: Product ID mismatch', [
                'imageProductId' => $image->product_id,
                'requestedProductId' => $productId
            ]);
            return false;
        }

        \Log::info('ProductImageService: Image found, proceeding with deletion', [
            'is_main' => $image->is_main,
            'path' => $image->path
        ]);

        // If it's the main image, clear it from product and try to set another
        if ($image->is_main) {
            $product = Product::find($productId);
            $product->update(['image' => null]);
            
            // Try to set another image as main
            $nextImage = $product->images()->where('id', '!=', $imageId)->first();
            if ($nextImage) {
                $product->update(['image' => $nextImage->path]);
                $nextImage->update(['is_main' => true]);
            }
        }
        
        // Optional: Delete file from storage
        // Storage::disk('public')->delete($image->path);
        
        $image->delete();
        \Log::info('ProductImageService: Image deleted successfully');
        return true;
    }

    /**
     * Set an image as the main image
     */
    public function setMainImage(int $imageId, int $productId)
    {
        $image = ProductImage::find($imageId);
        
        if (!$image || $image->product_id !== $productId) {
            return false;
        }

        $product = Product::find($productId);
        
        // Unset current main
        $product->images()->update(['is_main' => false]);
        
        // Set new main
        $image->update(['is_main' => true]);
        $product->update(['image' => $image->path]);
        
        return true;
    }

    /**
     * Get images for media library
     */
    public function getLibraryImages(string $search = '', int $limit = 50)
    {
        $query = ProductImage::query();

        if ($search) {
            $query->where('path', 'like', '%' . $search . '%');
        }

        // Get unique images (distinct by path)
        return $query->select('id', 'path', 'created_at')
            ->distinct()
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Attach selected images from library to product
     */
    public function attachFromLibrary(Product $product, array $selectedPaths)
    {
        if (empty($selectedPaths)) {
            return 0;
        }

        $addedCount = 0;
        $isFirstImage = !$product->image;

        foreach ($selectedPaths as $path) {
            // Check if image already exists for this product
            $exists = $product->images()->where('path', $path)->exists();
            
            if ($exists) {
                continue;
            }

            // Set as main if it's the first image
            if ($isFirstImage && $addedCount === 0) {
                $product->update(['image' => $path]);
            }

            $product->images()->create([
                'path' => $path,
                'is_main' => ($isFirstImage && $addedCount === 0)
            ]);

            $addedCount++;
        }

        return $addedCount;
    }
}
