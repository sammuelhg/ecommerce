<?php

namespace App\Livewire\Admin;

use App\Models\ProductMaterial;
use Livewire\Component;
use Livewire\WithPagination;

class ProductMaterialIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $showForm = false;
    public $editingId = null;

    protected $listeners = ['materialSaved' => 'closeForm'];

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function create()
    {
        $this->editingId = null;
        $this->showForm = true;
        $this->dispatch('open-material-modal');
    }

    public function edit($id)
    {
        $this->editingId = $id;
        $this->showForm = true;
        $this->dispatch('open-material-modal');
    }

    public function delete($id)
    {
        ProductMaterial::find($id)->delete();
        session()->flash('message', 'Material deletado com sucesso!');
    }

    #[On('materialSaved')]
    public function refreshList()
    {
        $this->showForm = false;
        $this->editingId = null;
        $this->resetPage();
        $this->dispatch('close-material-modal');
    }
    
    #[On('closeForm')]
    public function closeForm()
    {
        $this->showForm = false;
        $this->editingId = null;
        $this->dispatch('close-material-modal');
    }

    public function render()
    {
        return view('livewire.admin.product-material-index', [
            'materials' => \App\Models\ProductMaterial::where('name', 'like', '%' . $this->search . '%')
                ->paginate(10)
                ->withPath(route('admin.materials.index')),
        ]);
    }
}
