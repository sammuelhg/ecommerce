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
    }

    public function edit($id)
    {
        $this->editingId = $id;
        $this->showForm = true;
    }

    public function delete($id)
    {
        ProductColor::find($id)->delete();
        session()->flash('message', 'Cor deletada com sucesso!');
    }

    public function closeForm()
    {
        $this->showForm = false;
        $this->editingId = null;
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
