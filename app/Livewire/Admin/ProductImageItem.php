<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\ProductImage;
use App\Services\ProductImageService;

class ProductImageItem extends Component
{
    public $imageId;
    public $productId;
    public $imagePath;
    public $isMain;

    public function mount($imageId, $productId)
    {
        $this->imageId = $imageId;
        $this->productId = $productId;
        
        $image = ProductImage::find($imageId);
        if ($image) {
            $this->imagePath = $image->path;
            $this->isMain = $image->is_main;
        }
    }

    public function deleteImage()
    {
        \Log::info('ProductImageItem: deleteImage called', [
            'imageId' => $this->imageId,
            'productId' => $this->productId,
            'component_id' => $this->getId()
        ]);

        $success = app(ProductImageService::class)->deleteImage($this->imageId, $this->productId);
        
        \Log::info('ProductImageItem: deleteImage result', ['success' => $success]);

        if ($success) {
            $this->dispatch('image-deleted', imageId: $this->imageId);
            session()->flash('success', 'Imagem excluída com sucesso!');
        } else {
            session()->flash('error', 'Erro ao excluir imagem.');
        }
    }

    public function setMainImage()
    {
        \Log::info('ProductImageItem: setMainImage called', [
            'imageId' => $this->imageId,
            'productId' => $this->productId,
            'component_id' => $this->getId()
        ]);

        $success = app(ProductImageService::class)->setMainImage($this->imageId, $this->productId);
        
        \Log::info('ProductImageItem: setMainImage result', ['success' => $success]);

        if ($success) {
            $this->dispatch('main-image-updated', imageId: $this->imageId);
            session()->flash('success', 'Imagem definida como capa!');
        } else {
            session()->flash('error', 'Erro ao definir imagem como capa.');
        }
    }

    public function render()
    {
        return view('livewire.admin.product-image-item');
    }
}
