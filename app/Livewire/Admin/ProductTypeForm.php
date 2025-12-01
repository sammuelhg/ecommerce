<?php

namespace App\Livewire\Admin;

use App\Models\ProductType;
use Livewire\Component;

class ProductTypeForm extends Component
{
    public $typeId;
    public $name = '';
    public $code = '';
    public $is_active = true;

    protected $rules = [
        'name' => 'required|min:2',
        'code' => 'required|size:3|unique:product_types,code',
        'is_active' => 'boolean',
    ];

    public function mount($typeId = null)
    {
        if ($typeId) {
            $this->typeId = $typeId;
            $this->loadType();
        }
    }

    public function loadType()
    {
        $type = ProductType::findOrFail($this->typeId);
        $this->name = $type->name;
        $this->code = $type->code;
        $this->is_active = $type->is_active;
    }

    public function save()
    {
        $rules = $this->rules;
        if ($this->typeId) {
            $rules['code'] = 'required|size:3|unique:product_types,code,' . $this->typeId;
        }

        $this->validate($rules);

        $data = [
            'name' => $this->name,
            'code' => strtoupper($this->code),
            'is_active' => $this->is_active,
        ];

        if ($this->typeId) {
            ProductType::find($this->typeId)->update($data);
            session()->flash('message', 'Tipo atualizado com sucesso!');
        } else {
            ProductType::create($data);
            session()->flash('message', 'Tipo criado com sucesso!');
        }

        $this->dispatch('typeSaved');
        $this->reset();
    }

    public function render()
    {
        return view('livewire.admin.product-type-form');
    }
}
