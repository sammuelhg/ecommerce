<?php

namespace App\Livewire\Admin;

use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;

use Livewire\Attributes\On;

class CategoryIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $showCreateForm = false;
    public $editingCategoryId = null;

    protected $paginationTheme = 'bootstrap';
    
    // protected $listeners = ['categorySaved' => 'refreshList', 'closeForm' => 'closeForm'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function delete($id)
    {
        Category::find($id)->delete();
        session()->flash('message', 'Categoria excluída com sucesso.');
    }
    
    public function create()
    {
        $this->editingCategoryId = null;
        $this->showCreateForm = true;
        // $this->dispatch('open-modal', 'categoryModal');
        $this->dispatch('open-category-modal');
    }
    
    public function edit($id)
    {
        $this->editingCategoryId = $id;
        $this->showCreateForm = true;
        $this->dispatch('open-category-modal');
    }
    
    #[On('categorySaved')]
    public function refreshList()
    {
        $this->showCreateForm = false;
        $this->editingCategoryId = null;
        $this->resetPage();
        $this->dispatch('close-category-modal');
    }
    
    #[On('closeForm')]
    public function closeForm()
    {
        $this->showCreateForm = false;
        $this->editingCategoryId = null;
        $this->dispatch('close-category-modal');
    }

    public function render()
    {
        return view('livewire.admin.category-index', [
            'categories' => Category::where('name', 'like', '%' . $this->search . '%')
                ->withCount('products')
                ->paginate(10)
                ->withPath(route('admin.categories.index')),
        ]);
    }
}
