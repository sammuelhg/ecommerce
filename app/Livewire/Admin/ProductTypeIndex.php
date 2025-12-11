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
        // Dispatch event to open modal
        $this->dispatch('open-type-modal');
    }

    public function edit($id)
    {
        $this->editingId = $id;
        $this->showForm = true;
        $this->dispatch('open-type-modal');
    }

    public function delete($id)
    {
        ProductType::find($id)->delete();
        session()->flash('message', 'Tipo deletado com sucesso!');
    }

    #[\Livewire\Attributes\On('typeSaved')]
    public function refreshList()
    {
        $this->showForm = false;
        $this->editingId = null;
        $this->resetPage();
        $this->dispatch('close-type-modal');
    }

    #[\Livewire\Attributes\On('closeForm')]
    public function closeForm()
    {
        $this->showForm = false;
        $this->editingId = null;
        $this->dispatch('close-type-modal');
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
