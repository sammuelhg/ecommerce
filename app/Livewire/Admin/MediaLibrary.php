<?php

namespace App\Livewire\Admin;

use Livewire\Component;

class MediaLibrary extends Component
{
    public $mediaLibrary = [];
    public $selectedLibraryImages = []; // Changed to array
    public $librarySearch = '';

    public function mount()
    {
        $this->loadMediaLibrary();
    }

    public function updatedLibrarySearch()
    {
        $this->loadMediaLibrary();
    }

    public function loadMediaLibrary()
    {
        try {
            $this->mediaLibrary = app(\App\Services\ProductImageService::class)
                ->getLibraryImages($this->librarySearch);
        } catch (\Exception $e) {
            \Log::error('Failed to load media library', ['error' => $e->getMessage()]);
            $this->mediaLibrary = collect();
        }
    }

    public function selectFromLibrary($path)
    {
        if (in_array($path, $this->selectedLibraryImages)) {
            $this->selectedLibraryImages = array_diff($this->selectedLibraryImages, [$path]);
        } else {
            $this->selectedLibraryImages[] = $path;
        }
    }

    #[\Livewire\Attributes\On('addSelectedLibraryImage')]
    public function addSelectedLibraryImage()
    {
        if (empty($this->selectedLibraryImages)) {
            return;
        }

        $this->dispatch('handle-library-image', paths: $this->selectedLibraryImages);
        
        // Reset selection after dispatch
        $this->selectedLibraryImages = [];
        
        // Close modal
        $this->dispatch('close-media-library-modal');
    }

    #[\Livewire\Attributes\On('open-media-library')]
    public function openLibrary()
    {
        $this->loadMediaLibrary(); // Refresh library
        $this->dispatch('open-media-library-modal');
    }

    public function render()
    {
        return view('livewire.admin.media-library');
    }
}
