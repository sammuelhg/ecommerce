<?php

namespace App\Livewire\Admin;

use App\Models\ProductSize;
use Livewire\Component;
use Livewire\WithPagination;

class ProductSizeIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $showForm = false;
    public $editingId = null;

    protected $listeners = ['sizeSaved' => 'closeForm'];

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
        ProductSize::find($id)->delete();
        session()->flash('message', 'Tamanho deletado com sucesso!');
    }

    public function closeForm()
    {
        $this->showForm = false;
        $this->editingId = null;
    }

    public function render()
    {
        $sizes = ProductSize::where('name', 'like', '%' . $this->search . '%')
            ->orWhere('code', 'like', '%' . $this->search . '%')
            ->orderBy('name')
            ->paginate(10)
            ->withPath(route('admin.sizes.index'));

        return view('livewire.admin.product-size-index', [
            'sizes' => $sizes
        ]);
    }
}
