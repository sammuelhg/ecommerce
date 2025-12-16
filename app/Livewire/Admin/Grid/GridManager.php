<?php

namespace App\Livewire\Admin\Grid;

use App\Models\GridRule;
use Livewire\Component;

class GridManager extends Component
{
    use \Livewire\WithFileUploads;

    public $rules = [];
    public $showModal = false;
    public $editingRuleId = null;

    // Form fields
    public $position;
    public $type = 'marketing_banner';
    public $col_span = 1;
    
    // Config Fields
    public $config_title;
    public $config_text;
    public $config_link;
    public $config_bg_class = 'bg-primary text-white'; // Legacy/Custom fallback
    public $config_success_message; // Added

    // Visual Config
    public $config_text_color = 'text-dark';
    public $config_bg_color = 'bg-light';
    public $config_btn_color = 'btn-primary';
    public $config_badge_type = 'best_buy';
    
    public $config_image; // Shared file upload (Newsletter & Banner)
    public $existingImage; // Shared existing image
    public $config_image_style = 'background'; // 'background' or 'top'
    public $config_form_id; // New Form ID
    public $config_campaign_id; // Legacy Campaign ID (for migration support)
    public $config_button_text; // Button Text
    public $availableForms = [];

    protected $rules_validation = [
        'position' => 'required|integer|min:1', 
        'type' => 'required',
        'col_span' => 'required|integer|min:1|max:5',
        'config_image' => 'nullable|image|max:1024', 
    ];

    public function mount()
    {
        $this->loadRules();
        $this->availableForms = \App\Models\Form::where('is_active', true)->get();
    }

    public function loadRules()
    {
        $this->rules = \App\Models\GridRule::orderBy('position')->get();
    }

    // Product Search logic...
    public $productSearch = '';
    public $foundProducts = [];
    public $selectedProduct = null;
    public $formatted_config_product_id; 
    public $activeTab = 'content';

    public function setTab($tab)
    {
        $this->activeTab = $tab;
    }

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
            $this->productSearch = ''; 
            $this->foundProducts = [];
        }
    }

    public function create()
    {
        $this->resetForm();
        $this->showModal = true;
    }

    public function edit($id)
    {
        $this->resetForm();
        $this->editingRuleId = $id;
        $rule = GridRule::find($id);
        
        if (!$rule) return;

        $this->position = $rule->position + 1; 
        $this->type = $rule->type;
        $this->col_span = $rule->col_span;
        
        // Load Form ID
        $this->config_form_id = $rule->form_id;

        // Load Config
        $config = $rule->configuration ?? [];
        $this->config_title = $config['title'] ?? '';
        $this->config_text = $config['text'] ?? '';
        $this->config_link = $config['link'] ?? '';
        $this->config_bg_class = $config['bg_class'] ?? 'bg-primary text-white'; // Keep for legacy
        $this->config_campaign_id = $config['campaign_id'] ?? null;
        $this->config_button_text = $config['button_text'] ?? '';
        $this->config_success_message = $config['success_message'] ?? ''; // Added
        
        // Load Visual Config
        $this->config_text_color = $config['text_color'] ?? 'text-dark';
        $this->config_bg_color = $config['bg_color'] ?? 'bg-light';
        $this->config_btn_color = $config['btn_color'] ?? 'btn-primary';
        $this->config_badge_type = $config['badge_type'] ?? 'best_buy';
        $this->config_image_style = $config['image_style'] ?? 'background';
        $this->existingImage = $config['image'] ?? null;
        
        if (isset($config['product_id'])) {
            $this->selectProduct($config['product_id']);
        }

        $this->showModal = true;
    }

    public function resetForm()
    {
        $this->reset([
            'editingRuleId', 'position', 'type', 'col_span', 
            'config_title', 'config_text', 'config_link', 
            'config_bg_class', 'config_image', 'config_campaign_id', 'config_button_text', 'config_success_message',
            'config_text_color', 'config_bg_color', 'config_btn_color', 'config_badge_type',
            'productSearch', 'selectedProduct', 'formatted_config_product_id', 'config_image_style',
            'config_form_id'
        ]);
        $this->type = 'marketing_banner'; 
        $this->col_span = 1;
        $this->config_bg_class = 'bg-primary text-white';
        $this->activeTab = 'content';
        $this->config_image_style = 'background';
    }

    public function save()
    {
        $this->validate($this->rules_validation);
        
        // Convert user 1-based input to 0-based DB index
        $dbPosition = (int) $this->position - 1;

        // Manual uniqueness check
        $query = GridRule::where('position', $dbPosition);
        if ($this->editingRuleId) {
            $query->where('id', '!=', $this->editingRuleId);
        }
        
        if ($query->exists()) {
            $this->addError('position', 'A posição ' . $this->position . ' já está ocupada.');
            return;
        }

        // Specific Validation
        if ($this->type === 'card.newsletter_form' && empty($this->config_form_id)) {
             $this->addError('config_form_id', 'Selecione um formulário.');
             return;
        }

        $config = [];
        
        // Handle Image Upload
        $imagePath = null;
        if ($this->config_image) {
            $imagePath = $this->config_image->store('newsletter-assets', 'public');
        } elseif ($this->editingRuleId) {
            $existingRule = GridRule::find($this->editingRuleId);
            $imagePath = $existingRule->configuration['image'] ?? null;
        }

        // Common visual config
        $visualConfig = [
            'text_color' => $this->config_text_color,
            'bg_color' => $this->config_bg_color,
            'image' => $imagePath, // Banners & Newsletter use 'image'
            'image_style' => $this->config_image_style, // 'background' or 'top'
        ];

        if ($this->type === 'marketing_banner') {
            $config = array_merge($visualConfig, [
                'title' => $this->config_title,
                'text' => $this->config_text,
                'link' => $this->config_link,
                // 'bg_class' is legacy/fallback, new visual uses bg_color + text_color
                'bg_class' => $this->config_bg_color . ' ' . $this->config_text_color, 
                'btn_color' => $this->config_btn_color,
                'button_text' => $this->config_button_text,
            ]);
        } elseif ($this->type === 'card.product_highlight' || $this->type === 'product_highlight') {
            $config = [
                'product_id' => $this->formatted_config_product_id
            ];
        } elseif ($this->type === 'card.product_special') {
            $config = [
                'product_id' => $this->formatted_config_product_id,
                'badge_type' => $this->config_badge_type,
            ];
        } elseif ($this->type === 'card.newsletter_form') {
            // CLEAN CONFIG: Only visual, no content overrides
            $config = array_merge($visualConfig, [
                // No title, text, button_text here!
                // form_id is saved in column
            ]);
        }

        $data = [
            'position' => $dbPosition,
            'type' => $this->type,
            'col_span' => $this->col_span,
            'configuration' => $config,
            // 'form_id' => $this->config_form_id, // Wait, I need to check if 'form_id' is fillable in GridRule model? Assuming yes or guarded=[] by default? No, usually fillable.
            // I updated GridRule.php but did I check $fillable? I looked at it earlier.
            // Let's check existing GridRule.php content from previous view_file
            // It had $fillable ['position', 'type', 'col_span', 'configuration', 'is_active'].
            // I need to ADD 'form_id' to $fillable in GridRule.php!
        ];

        if ($this->type === 'card.newsletter_form') {
            $data['form_id'] = $this->config_form_id;
        } else {
            $data['form_id'] = null;
        }

        if ($this->editingRuleId) {
            $rule = GridRule::find($this->editingRuleId);
            $rule->update($data);
        } else {
            $data['is_active'] = true;
            GridRule::create($data);
        }

        $this->showModal = false;
        $this->loadRules();
        $this->resetForm();
    }

    public function delete($id)
    {
        GridRule::find($id)->delete();
        $this->loadRules();
    }

    public function getCampaignsProperty()
    {
        return \App\Models\NewsletterCampaign::orderBy('created_at', 'desc')->get();
    }

    public function render()
    {
        return view('livewire.admin.grid.index')
            ->extends('layouts.admin')
            ->section('content');
    }
}
