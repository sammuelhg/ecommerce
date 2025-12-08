<?php

namespace App\Livewire\Admin\Grid;

use App\Models\GridRule;
use Livewire\Component;

class GridManager extends Component
{
    use \Livewire\WithFileUploads;

    public $rules;
    public $showModal = false;

    // Form fields
    public $position;
    public $type = 'marketing_banner';
    public $col_span = 1;
    public $config_title;
    public $config_text;
    public $config_link;
    public $config_bg_class = 'bg-primary text-white';
    public $config_image; // Temporary file upload

    protected $rules_validation = [
        'position' => 'required|integer|min:1', // User inputs 1-based
        'type' => 'required',
        'col_span' => 'required|integer|min:1|max:5',
        'config_image' => 'nullable|image|max:1024', // 1MB max
    ];

    public function mount()
    {
        $this->loadRules();
    }

    public function loadRules()
    {
        $this->rules = GridRule::orderBy('position')->get();
    }

    // Product Search
    public $productSearch = '';
    public $foundProducts = [];
    public $selectedProduct = null;
    public $formatted_config_product_id; // For binding

    public function updatedProductSearch()
    {
        if (strlen($this->productSearch) < 2) {
            $this->foundProducts = [];
            return;
        }

        $this->foundProducts = \App\Models\Product::where('name', 'like', '%' . $this->productSearch . '%')
            ->where('is_active', true)
            ->take(5)
            ->get();
    }

    public function selectProduct($id)
    {
        $product = \App\Models\Product::find($id);
        if ($product) {
            $this->selectedProduct = $product;
            $this->formatted_config_product_id = $product->id;
            $this->productSearch = ''; // Clear search
            $this->foundProducts = [];
        }
    }

    public function save()
    {
        $this->validate($this->rules_validation);
        
        // Convert user 1-based input to 0-based DB index
        $dbPosition = (int) $this->position - 1;

        // Manual uniqueness check for the transformed position
        $existing = GridRule::where('position', $dbPosition)->first();
        if ($existing) {
            $this->addError('position', 'A posição ' . $this->position . ' (interna: '.$dbPosition.') já está ocupada.');
            return;
        }

        $config = [];
        
        if ($this->type === 'marketing_banner') {
            $config = [
                'title' => $this->config_title,
                'text' => $this->config_text,
                'link' => $this->config_link,
                'bg_class' => $this->config_bg_class,
            ];
        } elseif ($this->type === 'card.product_highlight' || $this->type === 'product_highlight') {
            $config = [
                'product_id' => $this->formatted_config_product_id
            ];
        } elseif ($this->type === 'card.newsletter_form') {
            $config = [];
            if ($this->config_image) {
                $path = $this->config_image->store('newsletter-assets', 'public');
                $config['image'] = $path;
            }
        }

        GridRule::create([
            'position' => $dbPosition,
            'type' => $this->type,
            'col_span' => $this->col_span,
            'configuration' => $config,
            'is_active' => true
        ]);

        $this->reset(['position', 'type', 'col_span', 'config_title', 'config_text', 'config_link', 'config_bg_class', 'config_image', 'selectedProduct', 'formatted_config_product_id']);
        $this->loadRules();
        $this->showModal = false;
    }

    public function delete($id)
    {
        GridRule::find($id)->delete();
        $this->loadRules();
    }

    public function render()
    {
        return view('livewire.admin.grid.index')
            ->extends('layouts.admin')
            ->section('content');
    }
}
