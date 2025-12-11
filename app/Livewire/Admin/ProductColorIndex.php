<?php

namespace App\Livewire\Admin;

use App\Models\ProductColor;
use Livewire\Component;
use Livewire\WithPagination;

class ProductColorIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $showForm = false;
    public $editingId = null;

    protected $listeners = ['colorSaved' => 'closeForm'];

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function create()
    {
        $this->editingId = null;
        $this->showForm = true;
        // Dispatch open-modal event
        $this->dispatch('open-color-modal');
    }

    public function edit($id)
    {
        $this->editingId = $id;
        $this->showForm = true;
        $this->dispatch('open-color-modal');
    }

    public function delete($id)
    {
        ProductColor::find($id)->delete();
        session()->flash('message', 'Cor deletada com sucesso!');
    }

    #[\Livewire\Attributes\On('colorSaved')]
    public function refreshList()
    {
        $this->showForm = false;
        $this->editingId = null;
        $this->resetPage();
        $this->dispatch('close-color-modal');
    }

    #[\Livewire\Attributes\On('closeForm')]
    public function closeForm()
    {
        $this->showForm = false;
        $this->editingId = null;
        $this->dispatch('close-color-modal');
    }

    public function render()
    {
        $colors = ProductColor::where('name', 'like', '%' . $this->search . '%')
            ->orWhere('code', 'like', '%' . $this->search . '%')
            ->orWhere('hex_code', 'like', '%' . $this->search . '%')
            ->orderBy('name')
            ->paginate(10)
            ->withPath(route('admin.colors.index'));

        return view('livewire.admin.product-color-index', [
            'colors' => $colors
        ]);
    }
}
