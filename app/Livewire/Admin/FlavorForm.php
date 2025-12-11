<?php

namespace App\Livewire\Admin;

use App\Models\Flavor;
use Livewire\Component;
use Illuminate\Validation\Rule;

class FlavorForm extends Component
{
    public $flavorId;
    public $name;
    public $slug;
    public $hex_code;
    public $is_active = true;

    public function mount($flavorId = null)
    {
        $this->flavorId = $flavorId;

        if ($flavorId) {
            $flavor = Flavor::findOrFail($flavorId);
            $this->name = $flavor->name;
            $this->slug = $flavor->slug;
            $this->hex_code = $flavor->hex_code;
            $this->is_active = (bool) $flavor->is_active;
        }
    }

    public function generateSlug()
    {
        $this->slug = \Str::slug($this->name);
    }

    public function updatedName()
    {
        if (!$this->flavorId) {
            $this->generateSlug();
        }
    }

    public function rules()
    {
        return [
            'name' => 'required|min:2',
            'slug' => ['required', Rule::unique('flavors', 'slug')->ignore($this->flavorId)],
            'hex_code' => 'nullable|string|max:7',
            'is_active' => 'boolean',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'O nome é obrigatório.',
            'slug.required' => 'O slug é obrigatório.',
            'slug.unique' => 'Este slug já está em uso.',
        ];
    }

    public function save()
    {
        $this->validate();

        Flavor::updateOrCreate(
            ['id' => $this->flavorId],
            [
                'name' => $this->name,
                'slug' => $this->slug ?: \Str::slug($this->name),
                'hex_code' => $this->hex_code,
                'is_active' => $this->is_active,
            ]
        );

        session()->flash('message', 'Sabor salvo com sucesso!');
        
        $this->dispatch('flavorSaved'); // Parent listener
    }

    public function render()
    {
        return view('livewire.admin.flavor-form');
    }
}
