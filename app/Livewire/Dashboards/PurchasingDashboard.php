<?php

namespace App\Livewire\Dashboards;

use Livewire\Component;
use App\Models\Product;
use App\Models\OrderLogistic;

class PurchasingDashboard extends Component
{
    /**
     * PERFORMANCE OPTIMIZATION:
     * wire:poll.2s refreshes every 2 seconds (currently set for testing).
     * For production with many concurrent users, consider:
     * - Increase to 5s or 10s: wire:poll.5s or wire:poll.10s
     * - Use wire:poll.keep-alive to only poll when tab is visible
     * - Use Laravel Echo + Pusher for event-driven real-time updates instead of polling
     */
    
    public $stockFilter = 'all';

    public function setFilter($filter)
    {
        $this->stockFilter = $filter;
    }

    public function render()
    {
        // Total stock value - calculated in PHP for SQLite compatibility
        $totalStockValue = Product::all()->sum(function($p) { return $p->stock * $p->price; });
        
        // Product counts
        $productCount = Product::sum('stock');
        
        // Low stock products (threshold: 15 units)
        $lowStockThreshold = 15;
        $lowStockProducts = Product::where('stock', '<', $lowStockThreshold)
            ->where('stock', '>', 0)
            ->orderBy('stock')
            ->take(5)
            ->get();
        $lowStockCount = Product::where('stock', '<', $lowStockThreshold)->count();
        
        // Open orders (orders created in last month)
        $openOrdersCount = OrderLogistic::where('created_at', '>=', now()->subMonth())->count();
        
        // Recent orders
        $recentOrders = OrderLogistic::with('product')
            ->latest()
            ->take(5)
            ->get();

        // All products for stock overview
        $query = Product::query();
        
        if ($this->stockFilter === 'low') {
            $query->where('stock', '<', $lowStockThreshold);
        }
        
        $allProducts = $query->orderBy('stock')->take(10)->get();

        return view('livewire.dashboards.purchasing-dashboard', compact(
            'totalStockValue',
            'productCount',
            'lowStockProducts',
            'lowStockCount',
            'openOrdersCount',
            'recentOrders',
            'allProducts'
        ));
    }
}
