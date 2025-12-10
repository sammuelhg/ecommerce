<?php

namespace App\Livewire\Admin\Crm;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\MarketingExpense;

class ExpenseManager extends Component
{
    use WithPagination;

    public $sourceFilter = '';
    
    // Form Inputs
    public $date;
    public $amount;
    public $source = 'meta';
    public $description;
    
    public bool $isModalOpen = false;

    public function mount()
    {
        $this->sourceFilter = request()->query('source', '');
        $this->date = now()->format('Y-m-d');
    }

    protected $rules = [
        'date' => 'required|date',
        'amount' => 'required|numeric|min:0',
        'source' => 'required|string',
        'description' => 'nullable|string',
    ];

    public function create()
    {
        $this->reset(['amount', 'description']);
        $this->date = now()->format('Y-m-d');
        $this->isModalOpen = true;
    }

    public function store()
    {
        $this->validate();

        MarketingExpense::create([
            'date' => $this->date,
            'amount' => $this->amount,
            'source' => $this->source,
            'description' => $this->description,
        ]);

        $this->isModalOpen = false;
        session()->flash('message', 'Despesa registrada com sucesso.');
    }

    public function delete($id)
    {
        MarketingExpense::find($id)->delete();
    }

    public function render()
    {
        $query = MarketingExpense::query()->orderBy('date', 'desc');

        if ($this->sourceFilter && $this->sourceFilter !== 'all') {
            $query->where('source', $this->sourceFilter);
        }

        return view('livewire.admin.crm.expense-manager', [
            'expenses' => $query->paginate(10)
        ])->layout('layouts.admin');
    }
}
