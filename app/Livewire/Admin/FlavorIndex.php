<?php

namespace App\Livewire\Admin;

use App\Models\Flavor;
use Livewire\Component;
use Livewire\WithPagination;

class FlavorIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $showForm = false;
    public $editingId = null;

    protected $listeners = ['flavorSaved' => 'closeForm'];

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function create()
    {
        $this->editingId = null;
        $this->showForm = true;
        $this->dispatch('open-flavor-modal');
    }

    public function edit($id)
    {
        $this->editingId = $id;
        $this->showForm = true;
        $this->dispatch('open-flavor-modal');
    }

    public function delete($id)
    {
        Flavor::find($id)->delete();
        session()->flash('message', 'Sabor excluído com sucesso!');
    }

    #[\Livewire\Attributes\On('flavorSaved')]
    public function refreshList()
    {
        $this->showForm = false;
        $this->editingId = null;
        $this->resetPage();
        $this->dispatch('close-flavor-modal');
    }

    #[\Livewire\Attributes\On('closeForm')]
    public function closeForm()
    {
        $this->showForm = false;
        $this->editingId = null;
        $this->dispatch('close-flavor-modal');
    }

    public function render()
    {
        $flavors = Flavor::where('name', 'like', '%' . $this->search . '%')
            ->orderBy('name')
            ->paginate(10)
            ->withPath(route('admin.flavors.index'));

        return view('livewire.admin.flavor-index', [
            'flavors' => $flavors
        ]);
    }
}
