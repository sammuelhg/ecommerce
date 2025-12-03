<?php

namespace App\Livewire\Admin;

use App\Models\ProductColor;
use Livewire\Component;
use Illuminate\Support\Str;

class ProductColorForm extends Component
{
    public $colorId;
    public $name;
    public $code;
    public $hex_code = '#000000';
    public $is_active = true;

    protected $rules = [
        'name' => 'required|min:2',
        'code' => 'required|size:3|unique:product_colors,code',
        'hex_code' => 'required|regex:/^#[a-fA-F0-9]{6}$/',
        'is_active' => 'boolean',
    ];

    public function mount($colorId = null)
    {
        if ($colorId) {
            $color = ProductColor::find($colorId);
            $this->colorId = $color->id;
            $this->name = $color->name;
            $this->code = $color->code;
            $this->hex_code = $color->hex_code;
            $this->is_active = $color->is_active;
        }
    }

    public function updatedName($value)
    {
        if (!$this->colorId && empty($this->code)) {
            $this->code = strtoupper(substr(Str::slug($value), 0, 3));
        }
    }

    public function updatedCode($value)
    {
        $this->code = strtoupper($value);
    }

    public function save()
    {
        // Adjust unique rule for update
        if ($this->colorId) {
            $this->rules['code'] = 'required|size:3|unique:product_colors,code,' . $this->colorId;
        }

        $this->validate();

        ProductColor::updateOrCreate(
            ['id' => $this->colorId],
            [
                'name' => $this->name,
                'code' => strtoupper($this->code),
                'hex_code' => $this->hex_code,
                'is_active' => $this->is_active,
            ]
        );

        $this->dispatch('colorSaved');
        $this->dispatch('show-validation-toast', ['message' => 'Cor salva com sucesso!']);
    }

    public function render()
    {
        return view('livewire.admin.product-color-form');
    }
}
