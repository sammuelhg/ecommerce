<?php

namespace App\Livewire\Admin;

use App\Models\Category;
use Livewire\Component;

class CategoryForm extends Component
{
    public $categoryId;
    public $name = '';
    public $slug = '';
    public $description = '';
    public $parent_id = '';
    public $is_active = true;
    
    public $isEditing = false;

    protected $rules = [
        'name' => 'required|min:3',
        'slug' => 'required|unique:categories,slug',
        'is_active' => 'boolean',
    ];

    public function mount($categoryId = null)
    {
        if ($categoryId) {
            $this->isEditing = true;
            $this->categoryId = $categoryId;
            $this->loadCategory();
        }
    }

    public function loadCategory()
    {
        $category = Category::findOrFail($this->categoryId);
        $this->name = $category->name;
        $this->slug = $category->slug;
        $this->description = $category->description ?? '';
        $this->parent_id = $category->parent_id ?? '';
        $this->is_active = $category->is_active;
    }

    public function updatedName()
    {
        $this->slug = \Str::slug($this->name);
    }

    protected function rules()
    {
        return [
            'name' => 'required|min:3',
            'slug' => 'required|unique:categories,slug,' . ($this->categoryId ?? 'NULL'),
            'is_active' => 'boolean',
        ];
    }

    public function save()
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'parent_id' => $this->parent_id ?: null,
            'is_active' => $this->is_active,
        ];

        if ($this->isEditing) {
            Category::find($this->categoryId)->update($data);
            session()->flash('message', 'Categoria atualizada com sucesso!');
        } else {
            Category::create($data);
            session()->flash('message', 'Categoria criada com sucesso!');
        }

        $this->dispatch('categorySaved');
        $this->reset();
    }

    public function render()
    {
        $parentCategories = Category::whereNull('parent_id')->where('id', '!=', $this->categoryId ?? 0)->get();
        return view('livewire.admin.category-form', compact('parentCategories'));
    }
}
