<?php

namespace App\Livewire\Admin;

use App\Models\ProductSize;
use Livewire\Component;
use Illuminate\Support\Str;

class ProductSizeForm extends Component
{
    public $sizeId;
    public $name;
    public $code;
    public $is_active = true;

    protected $rules = [
        'name' => 'required|min:1',
        'code' => 'required|max:10|unique:product_sizes,code',
        'is_active' => 'boolean',
    ];

    public function mount($sizeId = null)
    {
        if ($sizeId) {
            $size = ProductSize::find($sizeId);
            $this->sizeId = $size->id;
            $this->name = $size->name;
            $this->code = $size->code;
            $this->is_active = $size->is_active;
        }
    }

    public function updatedName($value)
    {
        if (!$this->sizeId && empty($this->code)) {
            $this->code = strtoupper(Str::slug($value));
        }
    }

    public function updatedCode($value)
    {
        $this->code = strtoupper($value);
    }

    public function save()
    {
        // Adjust unique rule for update
        if ($this->sizeId) {
            $this->rules['code'] = 'required|max:10|unique:product_sizes,code,' . $this->sizeId;
        }

        $this->validate();

        ProductSize::updateOrCreate(
            ['id' => $this->sizeId],
            [
                'name' => $this->name,
                'code' => strtoupper($this->code),
                'is_active' => $this->is_active,
            ]
        );

        $this->dispatch('sizeSaved');
        session()->flash('message', 'Tamanho salvo com sucesso!');
    }

    public function render()
    {
        return view('livewire.admin.product-size-form');
    }
}
