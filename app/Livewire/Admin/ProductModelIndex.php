<?php

namespace App\Livewire\Admin;

use App\Models\ProductModel;
use Livewire\Component;
use Livewire\WithPagination;

class ProductModelIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $showForm = false;
    public $editingId = null;

    protected $listeners = ['modelSaved' => 'closeForm'];

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
        ProductModel::find($id)->delete();
        session()->flash('message', 'Modelo deletado com sucesso!');
    }

    public function closeForm()
    {
        $this->showForm = false;
        $this->editingId = null;
    }

    public function render()
    {
        $models = ProductModel::where('name', 'like', '%' . $this->search . '%')
            ->orWhere('code', 'like', '%' . $this->search . '%')
            ->orderBy('name')
            ->paginate(10)
            ->withPath(route('admin.models.index'));

        return view('livewire.admin.product-model-index', [
            'models' => $models
        ]);
    }
}
