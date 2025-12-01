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
    }

    public function edit($id)
    {
        $this->editingId = $id;
        $this->showForm = true;
    }

    public function delete($id)
    {
        ProductMaterial::find($id)->delete();
        session()->flash('message', 'Material deletado com sucesso!');
    }

    public function closeForm()
    {
        $this->showForm = false;
        $this->editingId = null;
    }

    public function render()
    {
        $materials = ProductMaterial::where('name', 'like', '%' . $this->search . '%')
            ->orderBy('name')
            ->paginate(10);

        return view('livewire.admin.product-material-index', [
            'materials' => $materials
        ]);
    }
}
