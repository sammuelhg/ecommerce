<?php

namespace App\Livewire\Admin\Crm;

use Livewire\Component;
use App\Models\Order;
use App\Models\User;
use App\Models\MarketingExpense;
use App\Models\OrderItem;
use Carbon\Carbon;

class FinancialReport extends Component
{
    public $startDate;
    public $endDate;

    public function mount()
    {
        $this->startDate = Carbon::now()->startOfMonth()->format('Y-m-d');
        $this->endDate = Carbon::now()->endOfMonth()->format('Y-m-d');
    }

    public function render()
    {
        $start = Carbon::parse($this->startDate)->startOfDay();
        $end = Carbon::parse($this->endDate)->endOfDay();

        // 1. Revenue (DRE)
        $revenue = Order::whereBetween('created_at', [$start, $end])
            // .where('payment_status', 'paid') // Uncomment when status is populated
            ->sum('total_price');

        // 2. COGS (Cost of Goods Sold)
        $orderIds = Order::whereBetween('created_at', [$start, $end])
            // .where('payment_status', 'paid')
            ->pluck('id');
            
        $cogs = OrderItem::whereIn('order_id', $orderIds)
            ->with('product')
            ->get()
            ->sum(function ($item) {
                return $item->quantity * ($item->product->cost_price ?? 0);
            });

        // 3. Marketing Expenses
        $marketingCost = MarketingExpense::whereBetween('date', [$this->startDate, $this->endDate])
            ->sum('amount');

        // 4. CAC (Marketing / New Paying Customers)
        // Using users created in period who have placed an order
        $newCustomers = User::whereBetween('created_at', [$start, $end])
            ->has('orders')
            ->count();
        
        $cac = $newCustomers > 0 ? $marketingCost / $newCustomers : 0;

        // 5. LTV (Total Revenue / Total Customers) - All Time
        $totalRev = Order::sum('total_price');
        $totalCust = User::has('orders')->count();
        $ltv = $totalCust > 0 ? $totalRev / $totalCust : 0;

        // 6. Best Sellers
        $bestSellers = OrderItem::whereHas('order', function ($query) use ($start, $end) {
                $query->whereBetween('created_at', [$start, $end]);
                    // ->where('payment_status', 'paid');
            })
            ->selectRaw('product_id, sum(quantity) as total_qty, sum(quantity * unit_price) as total_revenue')
            ->with('product')
            ->groupBy('product_id')
            ->orderByDesc('total_qty')
            ->take(5)
            ->get();

        return view('livewire.admin.crm.financial-report', [
            'revenue' => $revenue,
            'cogs' => $cogs,
            'marketingCost' => $marketingCost,
            'grossMargin' => $revenue - $cogs,
            'netProfit' => ($revenue - $cogs) - $marketingCost,
            'cac' => $cac,
            'ltv' => $ltv,
            'newCustomers' => $newCustomers,
            'bestSellers' => $bestSellers,
        ])->layout('layouts.admin');
    }
}
