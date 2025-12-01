<?php

namespace App\Livewire\Admin;

use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use App\Models\User;
use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        return view('livewire.admin.dashboard', [
            'totalProducts' => Product::count(),
            'activeProducts' => Product::where('is_active', true)->count(),
            'totalCategories' => Category::count(),
            'totalUsers' => User::where('is_admin', false)->count(),
            'totalOrders' => Order::count(),
            'lowStockProducts' => Product::where('stock', '<', 10)->where('stock', '>', 0)->count(),
        ]);
    }
}
