<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Product;

use Livewire\Attributes\On;

class ProductIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $showCreateForm = false;
    public $editingProductId = null;

    protected $paginationTheme = 'bootstrap';
    
    // protected $listeners = ['productSaved' => 'refreshList', 'closeForm' => 'closeForm'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function delete($id)
    {
        Product::find($id)?->delete();
        session()->flash('message', 'Produto excluído com sucesso.');
    }
    
    public function edit($id)
    {
        $this->editingProductId = $id;
        $this->showCreateForm = true;
    }
    
    #[On('productSaved')]
    public function refreshList()
    {
        $this->showCreateForm = false;
        $this->editingProductId = null;
        $this->resetPage();
    }
    
    #[On('closeForm')]
    public function closeForm()
    {
        $this->showCreateForm = false;
        $this->editingProductId = null;
    }

    public $duplicatingProductId = null;

    #[On('productDuplicated')]
    public function productDuplicated($sku)
    {
        session()->flash('message', 'Produto duplicado com sucesso! SKU: ' . $sku);
        $this->duplicatingProductId = null;
        $this->resetPage();
    }

    #[On('modalClosed')]
    public function modalClosed()
    {
        $this->duplicatingProductId = null;
    }

    public function render()
    {
        return view('livewire.admin.product-index', [
            'products' => Product::with('category')
                ->where('name', 'like', '%' . $this->search . '%')
                ->orderBy('created_at', 'desc')
                ->paginate(10),
        ]);
    }
}
