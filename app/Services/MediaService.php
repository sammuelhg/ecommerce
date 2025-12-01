<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class MediaService
{
    protected $manager;
    protected $hasGd;

    public function __construct()
    {
        // Check if GD extension is available
        $this->hasGd = extension_loaded('gd');
        
        if ($this->hasGd) {
            $this->manager = new ImageManager(new Driver());
        }
    }

    /**
     * Upload and optimize an image (Resize + WebP conversion).
     * Falls back to regular storage if GD is not available.
     *
     * @param UploadedFile $file
     * @param string $path
     * @param int $maxWidth
     * @param int $quality
     * @return string The path to the stored file
     */
    public function uploadImage(UploadedFile $file, string $path = 'products', int $maxWidth = 1200, int $quality = 80): string
    {
        // Fallback: If GD is not available, store without optimization
        if (!$this->hasGd) {
            return $file->store($path, 'public');
        }

        try {
            // Generate unique filename with .webp extension
            $filename = uniqid() . '_' . time() . '.webp';
            $fullPath = $path . '/' . $filename;

            // Read image
            $image = $this->manager->read($file);

            // Resize if width is larger than maxWidth, maintaining aspect ratio
            if ($image->width() > $maxWidth) {
                $image->scale(width: $maxWidth);
            }

            // Encode to WebP
            $encoded = $image->toWebp($quality);

            // Store in public disk
            Storage::disk('public')->put($fullPath, (string) $encoded);

            return $fullPath;

        } catch (\Exception $e) {
            // Log error but fallback to original file
            \Log::error('MediaService: Optimization failed', ['error' => $e->getMessage()]);
            return $file->store($path, 'public');
        }
    }

    /**
     * Upload and crop an image based on provided crop data from Cropper.js
     *
     * @param UploadedFile $file
     * @param array $cropData ['x', 'y', 'width', 'height']
     * @param string $path
     * @param int $maxWidth
     * @param int $quality
     * @return string The path to the stored file
     */
    public function uploadImageWithCrop(UploadedFile $file, array $cropData, string $path = 'products', int $maxWidth = 1200, int $quality = 80): string
    {
        // Fallback: If GD is not available or no crop data, use regular upload
        if (!$this->hasGd || empty($cropData)) {
            return $this->uploadImage($file, $path, $maxWidth, $quality);
        }

        try {
            // Generate unique filename with .webp extension
            $filename = uniqid() . '_' . time() . '.webp';
            $fullPath = $path . '/' . $filename;

            // Read image
            $image = $this->manager->read($file);

            // Apply crop if crop data is provided
            if (isset($cropData['width']) && isset($cropData['height'])) {
                $image->crop(
                    width: (int) $cropData['width'],
                    height: (int) $cropData['height'],
                    offset_x: (int) ($cropData['x'] ?? 0),
                    offset_y: (int) ($cropData['y'] ?? 0)
                );
            }

            // Resize if width is larger than maxWidth, maintaining aspect ratio
            if ($image->width() > $maxWidth) {
                $image->scale(width: $maxWidth);
            }

            // Encode to WebP
            $encoded = $image->toWebp($quality);

            // Store in public disk
            Storage::disk('public')->put($fullPath, (string) $encoded);

            return $fullPath;

        } catch (\Exception $e) {
            // Log error but fallback to regular upload
            \Log::error('MediaService: Crop failed', ['error' => $e->getMessage()]);
            return $this->uploadImage($file, $path, $maxWidth, $quality);
        }
    }

    /**
     * Upload video or audio file (Basic storage).
     * Note: Optimization/Transcoding requires FFMpeg binary which might not be available on shared hosting.
     *
     * @param UploadedFile $file
     * @param string $path
     * @return string
     */
    public function uploadMedia(UploadedFile $file, string $path = 'media'): string
    {
        // Generate unique filename
        $filename = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();
        
        // Store directly
        return $file->storeAs($path, $filename, 'public');
    }
}
