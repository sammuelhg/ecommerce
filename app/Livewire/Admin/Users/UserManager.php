<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Users;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class UserManager extends Component
{
    use WithPagination;

    public string $search = '';
    public string $filterType = 'all'; // all, customers, users

    public $selectedUser = null;
    public $userBestSellers = [];
    public $isDetailModalOpen = false;

    // Reset pagination when searching or filtering
    public function updatedSearch(): void
    {
        $this->resetPage();
    }
    
    public function updatedFilterType(): void
    {
        $this->resetPage();
    }

    public function setFilter(string $type): void
    {
        $this->filterType = $type;
    }

    public function viewUser($userId)
    {
        $this->selectedUser = User::withCount('orders')
            ->withSum('orders', 'total_price')
            ->findOrFail($userId);

        // Calculate Best Sellers for this user
        $this->userBestSellers = \App\Models\OrderItem::whereHas('order', function ($q) use ($userId) {
                $q->where('user_id', $userId);
            })
            ->selectRaw('product_id, sum(quantity) as total_qty, sum(quantity * unit_price) as total_spent')
            ->with('product')
            ->groupBy('product_id')
            ->orderByDesc('total_qty')
            ->take(5)
            ->get();

        $this->isDetailModalOpen = true;
    }

    public function closeDetailModal()
    {
        $this->isDetailModalOpen = false;
        $this->selectedUser = null;
        $this->userBestSellers = [];
    }

    public function render()
    {
        $query = User::query()
            ->withCount('orders')
            ->orderBy('created_at', 'desc');

        // Apply Search
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%')
                  ->orWhere('id', $this->search);
            });
        }

        // Apply Filter
        if ($this->filterType === 'customers') {
            $query->has('orders');
        } elseif ($this->filterType === 'users') {
            $query->doesntHave('orders');
        }
        
        $query->withSum('orders', 'total_price');

        $totalRev = \App\Models\Order::sum('total_price');
        $totalOrders = \App\Models\Order::count();
        $storeAov = $totalOrders > 0 ? $totalRev / $totalOrders : 0;

        return view('livewire.admin.users.user-manager', [
            'users' => $query->paginate(20),
            'storeAov' => $storeAov
        ]);
    }
}
