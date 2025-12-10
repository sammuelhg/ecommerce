<?php

namespace App\Livewire\Admin;

use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use App\Models\User;
use App\Models\Lead;
use App\Models\Form;
use Livewire\Component;
use App\Models\OrderItem;

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
            'totalLeads' => Lead::count(),
            'totalForms' => Form::count(),
            'recentLeads' => Lead::with('form')->latest()->take(5)->get(),
            'bestSellers' => OrderItem::selectRaw('product_id, sum(quantity) as total_qty')
                ->with('product')
                ->groupBy('product_id')
                ->orderByDesc('total_qty')
                ->take(5)
                ->get(),
        ]);
    }
}
