<?php

namespace App\Livewire\Admin;

use App\Models\ProductMaterial;
use Livewire\Component;

class ProductMaterialForm extends Component
{
    public $materialId;
    public $name = '';
    public $is_active = true;

    protected $rules = [
        'name' => 'required|min:2',
        'is_active' => 'boolean',
    ];

    public function mount($materialId = null)
    {
        if ($materialId) {
            $this->materialId = $materialId;
            $this->loadMaterial();
        }
    }

    public function loadMaterial()
    {
        $material = ProductMaterial::findOrFail($this->materialId);
        $this->name = $material->name;
        $this->is_active = $material->is_active;
    }

    public function save()
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'is_active' => $this->is_active,
        ];

        if ($this->materialId) {
            ProductMaterial::find($this->materialId)->update($data);
            session()->flash('message', 'Material atualizado com sucesso!');
        } else {
            ProductMaterial::create($data);
            session()->flash('message', 'Material criado com sucesso!');
        }

        $this->dispatch('materialSaved');
        $this->reset();
    }

    public function render()
    {
        return view('livewire.admin.product-material-form');
    }
}
