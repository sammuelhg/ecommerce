<?php

namespace App\Livewire\Admin;

use App\Models\ProductType;
use Livewire\Component;
use Livewire\WithPagination;

class ProductTypeIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $showForm = false;
    public $editingId = null;

    protected $listeners = ['typeSaved' => 'closeForm'];

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
        ProductType::find($id)->delete();
        session()->flash('message', 'Tipo deletado com sucesso!');
    }

    public function closeForm()
    {
        $this->showForm = false;
        $this->editingId = null;
    }

    public function render()
    {
        $types = ProductType::where('name', 'like', '%' . $this->search . '%')
            ->orWhere('code', 'like', '%' . $this->search . '%')
            ->orderBy('name')
            ->paginate(10)
            ->withPath(route('admin.types.index'));

        return view('livewire.admin.product-type-index', [
            'types' => $types
        ]);
    }
}
