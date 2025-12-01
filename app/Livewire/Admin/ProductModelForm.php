<?php

namespace App\Livewire\Admin;

use App\Models\ProductModel;
use Livewire\Component;

class ProductModelForm extends Component
{
    public $modelId;
    public $name = '';
    public $code = '';
    public $is_active = true;

    protected $rules = [
        'name' => 'required|min:2',
        'code' => 'required|max:10|unique:product_models,code',
        'is_active' => 'boolean',
    ];

    public function mount($modelId = null)
    {
        if ($modelId) {
            $this->modelId = $modelId;
            $this->loadModel();
        }
    }

    public function loadModel()
    {
        $model = ProductModel::findOrFail($this->modelId);
        $this->name = $model->name;
        $this->code = $model->code;
        $this->is_active = $model->is_active;
    }

    public function save()
    {
        // Auto-generate code from name if not editing
        if (!$this->modelId) {
            $this->code = strtoupper(substr(preg_replace('/[^A-Za-z0-9]/', '', $this->name), 0, 10));
        }

        $rules = $this->rules;
        if ($this->modelId) {
            $rules['code'] = 'required|max:10|unique:product_models,code,' . $this->modelId;
        }

        $this->validate($rules);

        $data = [
            'name' => $this->name,
            'code' => strtoupper($this->code),
            'is_active' => $this->is_active,
        ];

        if ($this->modelId) {
            ProductModel::find($this->modelId)->update($data);
            session()->flash('message', 'Modelo atualizado com sucesso!');
        } else {
            ProductModel::create($data);
            session()->flash('message', 'Modelo criado com sucesso!');
        }

        $this->dispatch('modelSaved');
        $this->reset();
    }

    public function render()
    {
        return view('livewire.admin.product-model-form');
    }
}
